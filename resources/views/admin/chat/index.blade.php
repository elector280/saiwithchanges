@extends('admin.layouts.master')

@section('admin')

<style>
  .list-group-item.active{
    border-color:#0d6efd;
    box-shadow: inset 0 0 0 2px rgba(255,255,255,.25);
  }
</style>

<br>

<div class="container-fluid">
  <div class="row">

    <!-- LEFT: Thread List -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title">Chats</h5>

            <div class="card-tools">
                <button id="reloadThreads"
                        class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0" style="max-height: 75vh; overflow:auto;">
          <div id="threadList" class="list-group list-group-flush">
            <div class="p-3 text-muted">Loading...</div>
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT: Message Box -->
    <div class="col-md-8">
      <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center justify-content-between">
          <div>
            <h5 class="mb-0" id="chatTitle">Select a chat</h5>
            <small class="text-muted" id="chatSubTitle">No message selected</small>
          </div>
          <span class="badge bg-success" id="liveBadge" style="display:none;">LIVE</span>
        </div>

        <div class="card-body" style="background:#f8fafc;">
          <div id="adminChatMessages" style="height: 60vh; overflow:auto;">
            <div class="text-muted p-2">No message selected</div>
          </div>
        </div>

        <div class="card-footer">
          <div class="input-group">
            <input id="adminChatInput" type="text" class="form-control" placeholder="Type reply..." disabled>
            <button id="adminSendBtn" class="btn btn-primary" disabled>Send</button>
          </div>
          <small class="text-muted d-block mt-2">Auto refresh: threads 5s, messages 2s</small>
        </div>
      </div>
    </div>

  </div>
</div>

<audio id="chatPing" preload="auto">
  <source src="{{ asset('sounds/notify.wav') }}" type="audio/wav">
</audio>

<div id="chatToast"
     style="position:fixed;right:16px;bottom:16px;z-index:99999;display:none;
            background:#111827;color:#fff;padding:10px 12px;border-radius:10px;
            box-shadow:0 10px 25px rgba(0,0,0,.25);max-width:320px;font-size:13px;">
  <div style="font-weight:700;margin-bottom:2px" id="chatToastTitle">New message</div>
  <div id="chatToastBody" style="opacity:.9"></div>
</div>



{{-- If admin layout doesn't include jQuery, uncomment below --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">


<script>
  // --- Notification helpers (MUST) ---
  const __origTitle = document.title;
  let __badgeCount = 0;
  let __lastSoundAt = 0;

  function playPing(){
    const now = Date.now();
    if(now - __lastSoundAt < 1200) return;
    __lastSoundAt = now;

    const a = document.getElementById('chatPing');
    if(!a) return;

    // if not unlocked, try unlock (won't always work without gesture)
    if(typeof __soundUnlocked !== 'undefined' && !__soundUnlocked){
      // will be unlocked on next user click/keydown
      return;
    }

    a.currentTime = 0;
    a.play().catch(()=>{});
  }


  function showToast(title, body){
    const $t = $('#chatToast');
    $('#chatToastTitle').text(title || 'New message');
    $('#chatToastBody').text(body || '');
    $t.stop(true,true).fadeIn(150);
    setTimeout(()=> $t.fadeOut(250), 2500);
  }

  function setTitleBadge(on){
    if(on){
      __badgeCount++;
      document.title = `(${__badgeCount}) ${__origTitle}`;
    }else{
      __badgeCount = 0;
      document.title = __origTitle;
    }
  }

  function notifyNewMessage(title, body){
    playPing();
    showToast(title, body);
    setTitleBadge(true);
  }

  function clearNotifyBadge(){
    setTitleBadge(false);
  }
</script>


<script>
(function(){
  $.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
  });

  const THREADS_URL = "{{ route('admin.chat.threads') }}";
  const FETCH_URL_BASE = "{{ url('/admin/chat/fetch') }}";
  const SEND_URL_BASE  = "{{ url('/admin/chat/send') }}";

  const $threadList = $('#threadList');
  const $msgs = $('#adminChatMessages');
  const $input = $('#adminChatInput');
  const $send = $('#adminSendBtn');

  let selectedThreadId = null;
  let lastMsgId = 0;
  let fetching = false;

  // ✅ for admin notifications: remember last message id per thread
  const threadLastMsg = new Map(); // threadId -> last_message_id

  function esc(s){
    return String(s)
      .replaceAll('&','&amp;').replaceAll('<','&lt;')
      .replaceAll('>','&gt;').replaceAll('"','&quot;')
      .replaceAll("'","&#039;");
  }

  function renderThread(t){
    const isActive = selectedThreadId && Number(selectedThreadId) === Number(t.id);

    return `
      <button type="button"
        class="list-group-item list-group-item-action thread-item ${isActive ? 'active' : ''}"
        data-id="${t.id}">

        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="fw-semibold ${isActive ? 'text-white' : ''}">
              Guest message #${t.id}
            </div>

            <div class="small mt-1 ${isActive ? 'text-white-50' : 'text-muted'}">
              ${esc(t.preview || '')}
            </div>

            <span class="badge mt-2 ${isActive ? 'bg-light text-dark' : 'bg-secondary'}">
              ${esc(t.status || 'open')}
            </span>
          </div>

          <small class="${isActive ? 'text-white-50' : 'text-muted'}">
            ${esc(t.last_time || '')}
          </small>
        </div>
      </button>
    `;
  }

  function renderMessage(m){
    const isAdmin = m.sender === 'admin';
    return `
      <div class="d-flex ${isAdmin ? 'justify-content-end' : 'justify-content-start'} mb-2">
        <div style="max-width:75%;" class="p-2 rounded-3 ${isAdmin ? 'bg-primary text-white' : 'bg-white border'}">
          <div style="white-space:pre-wrap;">${esc(m.message)}</div>
          <div class="small mt-1 ${isAdmin ? 'text-white-50' : 'text-muted'}" style="text-align:right;">
            ${esc(m.time || '')}
          </div>
        </div>
      </div>
    `;
  }

  function scrollBottom(){
    const el = $msgs[0];
    el.scrollTop = el.scrollHeight;
  }

  function loadThreads(){
    $.ajax({
      url: THREADS_URL,
      method: 'GET',
      dataType: 'json',
      cache: false,
      success: function(res){
        if(!res || res.ok !== true){
          $threadList.html(`<div class="p-3 text-danger">Threads API response invalid</div>`);
          return;
        }

        const threads = res.threads || [];

        // ✅ detect new guest messages (compare last_message_id)
        let hasNewGuest = false;
        let previewText = '';

        threads.forEach(t => {
          const id = String(t.id);
          const prev = threadLastMsg.get(id) || 0;
          const curr = t.last_message_id || 0;

          if(curr > prev && t.last_sender === 'guest'){
            // if admin currently reading this thread, you may skip notify:
            if(!selectedThreadId || Number(selectedThreadId) !== Number(t.id)){
              hasNewGuest = true;
              previewText = t.preview || '';
            }
          }

          threadLastMsg.set(id, curr);
        });

        $threadList.html(threads.map(renderThread).join('') || `<div class="p-3 text-muted">No chats found</div>`);

        if(hasNewGuest){
          notifyNewMessage('New user message', (previewText || '').slice(0, 80));
        }
      },
      error: function(xhr){
        const msg = `Threads load failed: ${xhr.status}`;
        $threadList.html(`<div class="p-3 text-danger">${msg}<br><small>${esc((xhr.responseText||'').slice(0,200))}</small></div>`);
      }
    });
  }

  function openThread(id){
    clearNotifyBadge(); // ✅ reading chat clears badge

    selectedThreadId = id;
    lastMsgId = 0;
    $('#chatTitle').text('Guest message #' + id);
    $('#chatSubTitle').text('Realtime messages');
    $('#liveBadge').show();

    $msgs.html('');
    $input.prop('disabled', false);
    $send.prop('disabled', false);

    $threadList.find('.thread-item').removeClass('active');
    $threadList.find(`[data-id="${id}"]`).addClass('active');

    fetchMessages(true);
  }

  function fetchMessages(forceScroll){
    if(!selectedThreadId || fetching) return;
    fetching = true;

    $.ajax({
      url: `${FETCH_URL_BASE}/${selectedThreadId}`,
      method: 'GET',
      data: { after_id: lastMsgId },
      dataType: 'json',
      cache: false,
      success: function(res){
        if(!res || res.ok !== true) return;

        const arr = res.messages || [];
        if(arr.length){
          arr.forEach(m => {
            $msgs.append(renderMessage(m));
            lastMsgId = Math.max(lastMsgId, m.id);
          });
          if(forceScroll !== false) scrollBottom();
          loadThreads(); // reorder + preview update
        }
      },
      complete: function(){ fetching = false; }
    });
  }

  function sendAdmin(){
    if(!selectedThreadId) return;
    const text = $input.val().trim();
    if(!text) return;

    $send.prop('disabled', true);

    $.ajax({
      url: `${SEND_URL_BASE}/${selectedThreadId}`,
      method: 'POST',
      dataType: 'json',
      data: { message: text },
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function(res){
        if(res.ok && res.message){
          $msgs.append(renderMessage(res.message));
          lastMsgId = Math.max(lastMsgId, res.message.id);
          $input.val('');
          scrollBottom();
          loadThreads();
        }
      },
      complete: function(){ $send.prop('disabled', false); }
    });
  }

  $threadList.on('click', '.thread-item', function(){
    openThread($(this).data('id'));
  });

  $('#reloadThreads').on('click', loadThreads);
  $send.on('click', sendAdmin);
  $input.on('keydown', e => { if(e.key === 'Enter') sendAdmin(); });

  loadThreads();
  setInterval(loadThreads, 5000);
  setInterval(() => fetchMessages(true), 2000);

  const p = new URLSearchParams(window.location.search);
  const t = p.get('thread');
  if(t){ setTimeout(()=> openThread(Number(t)), 600); }
})();
</script>





<script>
(function(){
  function csrf(){
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  }

  function setBadge(n){
    const badge = document.getElementById('chatBellBadge');
    const header = document.getElementById('chatBellHeader');
    n = Number(n || 0);

    if(n <= 0){
      badge.style.display = 'none';
      badge.textContent = '0';
      header.textContent = '0 Guest message';
    }else{
      badge.style.display = '';
      badge.textContent = String(n);
      header.textContent = `${n} Guest message`;
    }
  }

  // ✅ decrement badge safely
  function decBadge(){
    const badge = document.getElementById('chatBellBadge');
    const current = Number(badge?.textContent || 0);
    setBadge(Math.max(0, current - 1));
  }

  // ✅ CLICK: mark thread read_at via fetch, then navigate
  document.addEventListener('click', function(e){
    const a = e.target.closest('.chat-notify-item');
    if(!a) return;

    const id = a.getAttribute('data-thread-id');
    if(!id) return;

    // stop immediate navigation (we will navigate after marking read)
    e.preventDefault();

    // optimistic UI: make normal + reduce badge (optional)
    a.style.fontWeight = '400';
    // ⚠️ thread may have multiple unread messages, badge should ideally refresh from server,
    // but this is OK as quick UX. We'll also set to 0 when response says ok if you want.
    // For accurate count, best is: reload with ajax endpoint. For now, decrement 1.
    decBadge();

    fetch(`/admin/chat/notify/read-thread/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf(),
        'Accept': 'application/json'
      },
      credentials:'same-origin'
    })
    .then(r => r.json())
    .then(res => {
      // go to chat page thread after marking read
      window.location.href = a.getAttribute('href');
    })
    .catch(() => {
      // even if failed, still navigate
      window.location.href = a.getAttribute('href');
    });
  });
})();



</script>

@endsection
