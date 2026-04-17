  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ route('homees') }}" class="nav-link {{ request()->routeIs('homees') ? 'active' : '' }}" target="_blank">
              <i class="mr-1 fas fa-globe"></i>
              Website
          </a>
      </li>

      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>

  @php
    // ✅ Unread guest messages count (read_at null)
    $unreadCount = App\Models\ChatMessage::where('sender','guest')
        ->whereNull('read_at')
        ->count();

    // ✅ Latest threads (only those with messages)
    $threads = App\Models\ChatThread::with('latestMessage')
        ->whereHas('latestMessage')
        ->orderByDesc('last_message_at')
        ->limit(10)
        ->get();
  @endphp
    <!-- Right navbar links -->
    

     




      <ul class="ml-auto navbar-nav">

            @auth
                {{-- Notifications, etc. চাইলে এখানে আরেকটা icon দিতে পারো --}}

                {{-- USER DROPDOWN --}}
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        {{-- avatar --}}
                        <img
                            src="{{ asset('backend-asset') }}/dist/img/user2-160x160.jpg"
                            class="user-image img-circle elevation-2"
                            alt="{{ Auth::user()->name ?? ''}}"
                        >
                        <span class="d-none d-md-inline">
                            {{ Auth::user()->name ?? ''}}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        {{-- dropdown header --}}
                        <li class="user-header bg-primary">
                            <img
                                src="{{ asset('backend-asset') }}/dist/img/user2-160x160.jpg"
                                class="img-circle elevation-2"
                                alt="{{ Auth::user()->name }}"
                            >
                            <p>
                                {{ Auth::user()->name }}
                                <small>{{ Auth::user()->email }}</small>
                            </p>
                        </li>

                        {{-- dropdown footer: profile + logout --}}
                        <li class="user-footer d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-default btn-flat">
                                <i class="mr-1 fas fa-user"></i> Profile
                            </a>

                            {{-- Logout: POST form --}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-flat">
                                    <i class="mr-1 fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth

            @guest
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="mr-1 fas fa-sign-in-alt"></i> Login
                    </a>
                </li>
            @endguest

        </ul>

    </ul>
  </nav>





  
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


