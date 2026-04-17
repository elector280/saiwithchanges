<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="robots" content="index, follow">
  <title> <?php echo $__env->yieldContent('title', 'South American Iniciative'); ?> </title>
  <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'South American Iniciative'); ?>">
  <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keyword', 'South American Iniciative'); ?>">

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" type="image/png" href="<?php echo e(asset('storage/favicon/'.$setting->favicon)); ?>">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


  


  <?php echo $__env->yieldContent('meta'); ?>


  <!-- Google Tag Manager -->
  <?php if(!empty($setting?->tag_manager)): ?>
    <?php echo $setting->tag_manager; ?>

  <?php endif; ?>
  <!-- End Google Tag Manager -->

  <?php if(!empty($setting?->google_analytics)): ?>
    <?php echo $setting->google_analytics; ?>

  <?php endif; ?>

  <?php if(!empty($setting?->gsc_verification)): ?>
    <?php echo $setting->gsc_verification; ?>

  <?php endif; ?>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#E13B35',
            primaryDark: '#C62828',
            accent: '#FFCC00'
          }
        }
      }
    }
  </script>

   <!-- marquee CSS -->
    <style>
      .sponsor-marquee {
        position: relative;
      }

      .sponsor-track {
        width: max-content;                /* content যত বড়, ততই width */
        animation: sponsor-marquee 30s linear infinite;
      }

      /* left → right চাইলে 0 থেকে 50% করো, right → left এখন সেট করা আছে */
      @keyframes sponsor-marquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
      }

      @media (min-width: 768px) {
        .sponsor-track {
          animation-duration: 40s;         /* বড় স্ক্রিনে একটু ধীরে চলবে */
        }
      }

      /* LOGO BLOCK WITH BLUE/YELLOW BARS */
.logo-top {
    position: relative;
    display: flex;
    align-items: center;

    margin-top: -36px !important;   /* keep your overlap with top bar */
    margin-left: -16px !important;

    background: #D94647;
    padding: 10px 36px 10px 20px;  /* top/right/bottom/left */
} 

/* actual logo image */
.logo-top .logo-img {
    width: 134px !important;
    height: auto !important;
    /* padding-top: 9px!important */
}

/* diagonal stripes */
.logo-top::before,
.logo-top::after {
    content: "";
    position: absolute;
    top: -10px;
    bottom: 0px;
    width: 24px;
    transform: skewX(33deg);
}

/* blue bar */
.logo-top::before {
    right: 52px;
    background: #2261aa;
    margin-right: -61px;
}

/* yellow bar */
.logo-top::after {
    right: 24px;
    background: #fff0a1;
    margin-right: -57px;
}
    </style>

    <style>
      .sponsor-marquee{
  width: 100%;
  overflow: hidden;
}

.sponsor-track{
  width: max-content;
  will-change: transform;
  animation: sponsorScroll var(--marquee-duration, 18s) linear infinite;
}

@keyframes sponsorScroll{
  from { transform: translateX(0); }
  to   { transform: translateX(calc(-1 * var(--marquee-distance))); }
}

    </style>

    <style>
        figure.sn-figure { display: inline-block; margin: 0; }
        figure.sn-figure figcaption { font-size: 12px; opacity: .8; text-align: center; }
    </style>

    <?php echo $__env->yieldContent('css'); ?>


</head>
<body class="font-sans antialiased bg-white text-slate-900 bg-[#F4F4F4]">
  
<!-- Google Tag Manager (noscript) -->
  <?php if(!empty($setting?->google_tag_manager_body)): ?>
    <?php echo $setting->google_tag_manager_body; ?>

  <?php endif; ?>
  <!-- End Google Tag Manager (noscript) -->


  <div class="w-full px-0 max-w-none">
  

    <!-- ========== TOP BAR ========== -->


    <?php echo $__env->make('frontend.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

      <?php echo $__env->yieldContent('frontend'); ?>

    <?php echo $__env->make('frontend.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>





<audio id="chatPing" preload="auto">
  <source src="<?php echo e(asset('sounds/notify.wav')); ?>" type="audio/mpeg">
</audio>

<div id="chatToast"
     style="position:fixed;right:16px;bottom:16px;z-index:99999;display:none;
            background:#111827;color:#fff;padding:10px 12px;border-radius:10px;
            box-shadow:0 10px 25px rgba(0,0,0,.25);max-width:320px;font-size:13px;">
  <div style="font-weight:700;margin-bottom:2px" id="chatToastTitle">New message</div>
  <div id="chatToastBody" style="opacity:.9"></div>
</div>



    <script src="https://donorbox.org/widget.js" paypalExpress="true"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


  <!-- TOGGLE SCRIPT -->
  <script>
    const askBtn = document.getElementById('askUsToggle');
    const chatBox = document.getElementById('chatBox');
    const closeBtns = document.querySelectorAll('.chat-close');

    function toggleChat() {
      chatBox.classList.toggle('hidden');
    }

    askBtn.addEventListener('click', toggleChat);
    closeBtns.forEach(btn => btn.addEventListener('click', toggleChat));
  </script>

  <!-- ========== HEADER SCRIPT ========== -->
  <script>
    const openBtn   = document.getElementById('nav-open');
    const closeBtn  = document.getElementById('nav-close');
    const overlay   = document.getElementById('nav-overlay');
    const panel     = document.getElementById('nav-panel');

    function openMenu() {
      panel.classList.remove('-translate-x-full');
      overlay.classList.remove('hidden');
    }
    function closeMenu() {
      panel.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    }

    openBtn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    overlay?.addEventListener('click', closeMenu);

    // simple accordion logic
    function setupAccordion(name) {
      const btn   = document.querySelector(`button[data-accordion="${name}"]`);
      const panel = document.getElementById(`panel-${name}`);
      const icon  = document.getElementById(`icon-${name}`);
      btn?.addEventListener('click', () => {
        panel.classList.toggle('hidden');
        if (icon) icon.textContent = panel.classList.contains('hidden') ? '▼' : '▲';
      });
    }
    setupAccordion('campaigns');
    setupAccordion('help');
  </script>








<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form.newsletterForm').forEach((form) => {
        form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = form.querySelector('.newsletterBtn');
        const msg = form.querySelector('.newsletterMsg');

        const setMsg = (text, ok = true) => {
            if (!msg) return;
            msg.textContent = text || '';
            msg.className = 'newsletterMsg mt-2 text-[11px] ' + (ok ? 'text-white' : 'text-white');
        };

        setMsg('');

        const fd = new FormData(form);

        // loading
        const oldHtml = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = 'Sending...'; }

        try {
            const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: fd
            });

            const data = await res.json().catch(() => ({}));

            if (res.ok) {
            setMsg(data.message || "You’ve been subscribed! Please check your email.", true);
            form.reset();
            } else {
            const err = data?.message || data?.errors?.email?.[0] || 'Something went wrong. Please try again.';
            setMsg(err, false);
            }
        } catch (err) {
            setMsg('Network error. Please try again.', false);
        } finally {
            if (btn) { btn.disabled = false; btn.innerHTML = oldHtml; }
        }
        });
    });
    });
</script>










<script>
  // --- notify helpers ---
  const __origTitle = document.title;
  let __badgeCount = 0;
  let __lastSoundAt = 0;

  function playPing(){
    const now = Date.now();
    if(now - __lastSoundAt < 1200) return; // anti-spam
    __lastSoundAt = now;

    const a = document.getElementById('chatPing');
    if(!a) return;
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
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  });
</script>

<script>
(function () {
  const $box = $('#chatMessages');
  const $input = $('#chatInput');
  const $btn = $('#chatSendBtn');

  let lastId = 0;
  let fetching = false;

  // ✅ Prevent duplicate rendering
  const seenIds = new Set();

  const esc = s => String(s)
    .replaceAll('&','&amp;').replaceAll('<','&lt;')
    .replaceAll('>','&gt;').replaceAll('"','&quot;')
    .replaceAll("'","&#039;");

  function bubble(m){
    const isGuest = m.sender === 'guest';
    const bg = isGuest ? '#e6f0ff' : '#ffe3e3';
    return `
      <div class="relative max-w-full rounded-xl px-3 py-2" style="background:${bg}">
        <span class="absolute -left-1 top-3 w-3 h-3 rotate-45" style="background:${bg}"></span>
        <p class="leading-snug">${esc(m.message)}</p>
        <span class="block mt-1 text-[10px] text-slate-500 text-right">Sent at ${esc(m.time)}</span>
      </div>
    `;
  }

  function scrollBottom(){ $box.scrollTop($box[0].scrollHeight); }

  // ✅ Safe append (no duplicates)
  function appendMessage(m){
    if(!m || !m.id) return;

    if(seenIds.has(m.id)) {
      lastId = Math.max(lastId, m.id);
      return;
    }

    seenIds.add(m.id);
    $box.append(bubble(m));
    lastId = Math.max(lastId, m.id);
  }

  function fetchNew(){
    if(fetching) return;
    fetching = true;

    $.get("<?php echo e(route('guest.chat.fetch')); ?>", { after_id: lastId })
      .done(res => {
        if(!res || !res.ok) return;

        const msgs = res.messages || [];

        // ✅ notify only if admin replied (new messages this poll)
        let gotAdminReply = false;
        let adminText = '';

        msgs.forEach(m => {
          appendMessage(m);
          if(m.sender === 'admin'){
            gotAdminReply = true;
            adminText = m.message;
          }
        });

        if(gotAdminReply){
          notifyNewMessage('Admin replied', (adminText || '').slice(0, 80));
        }

        if(msgs.length) scrollBottom();
      })
      .always(() => fetching = false);
  }

  function send(){
    const text = $input.val().trim();
    if(!text) return;

    $btn.prop('disabled', true);

    $.post("<?php echo e(route('guest.chat.send')); ?>", { message: text })
      .done(res => {
        if(res && res.ok && res.message){
          appendMessage(res.message);
          $input.val('');
          scrollBottom();

          // Optional: first interaction unlocks audio autoplay policy
          // playPing();
        }
      })
      .always(() => $btn.prop('disabled', false));
  }

  $btn.on('click', send);
  $input.on('keydown', e => { if(e.key === 'Enter') send(); });

  // chat close
  $('.chat-close').on('click', () => $('#chatBox').addClass('hidden'));

  // if you have open button, call clearNotifyBadge() when opening
  // $('#openChatBtn').on('click', ()=> { $('#chatBox').removeClass('hidden'); clearNotifyBadge(); });

  fetchNew();
  setInterval(fetchNew, 2000);
})();
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
  const btn = document.getElementById('scrollToTopBtn');

  if (!btn) return;

  btn.addEventListener('click', (e) => {
    e.preventDefault();

    const target = document.querySelector('#heroSection');

    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  });
});
</script>
<script>
(function () {
  function setupSponsorsMarquee() {
    const track = document.getElementById('sponsorTrack');
    if (!track) return;

    const children = Array.from(track.children);
    const half = Math.floor(children.length / 2); // 1 set size

    let distance = 0;
    for (let i = 0; i < half; i++) {
      distance += children[i].offsetWidth;
    }

    const gap = parseFloat(getComputedStyle(track).gap || 0);
    distance += gap * (half - 1);

    track.style.setProperty('--marquee-distance', distance + 'px');

    // speed auto (distance বেশি হলে duration বেশি)
    const duration = Math.max(10, Math.round(distance / 90));
    track.style.setProperty('--marquee-duration', duration + 's');
  }

  window.addEventListener('load', setupSponsorsMarquee);
  window.addEventListener('resize', setupSponsorsMarquee);
})();
</script>




</div>
</body>
</html>
<?php /**PATH C:\Users\MalcaCorp\Desktop\proyecto\public_html\resources\views/frontend/layouts/master.blade.php ENDPATH**/ ?>