<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login | SAI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/dist/css/adminlte.min.css">

 <style>
  /* Page layout */
  .login-wrapper{
    display:flex;
    min-height:100vh;
    background:#fff;
  }

  /* LEFT side image */
  .login-image{
        flex: 0 0 62%;      /* left panel width */
        height: 100vh;      /* full screen height */
        overflow: hidden;
        position: relative;
    }
  .login-image::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(to bottom,
      rgba(0,0,0,.10) 0%,
      rgba(0,0,0,.10) 60%,
      rgba(0,0,0,.65) 100%);
  }

  /* Bottom-left branding like screenshot */
  .login-image-content{
    width:100%;
    height:100%;
    }

    .login-image-content img{
        margin-top: auto;
        margin-bottom: auto;
        width:100%;
        height:100%;
        object-fit: cover;  /* crop করে full cover */
        display:block;
    }


  /* RIGHT side form */
  .login-form{
    flex:1;
    position:relative;
    background:#fff;
    display:flex;
    align-items:flex-start;
    justify-content:flex-start;
    padding:0;
    overflow:hidden;
  }

  /* top blue lines (2 lines like screenshot) */
  /* .login-form::before{
    content:"";
    position:absolute;
    top:0;left:0;right:0;
    height:3px;
    background:#2aa3df;
  } */
  .login-form::after{
    content:"";
    position:absolute;
    top:84px;left:0;right:0;
    height:2px;
    background:#2aa3df;
    opacity:.85;
  }

  .login-form{
  flex: 1;
  position: relative;
  background:#fff;
  display:flex;
  align-items:center;        /* ✅ middle vertically */
  justify-content:center;    /* ✅ middle horizontally */
  padding:0;
}

.login-box{
  width:650px !important;
  max-width:620px;
  margin:0;
  padding:0;                /* ✅ remove top padding */
}

/* optional: keep form inner spacing */
.login-box .card-body{
  padding:40px 60px;
}

@media (max-width: 992px){
  .login-box .card-body{
    padding:30px 24px;
  }
}



  /* text styling like screenshot */
  .login-box-msg{
    text-align:left;
    font-size:11px;
    letter-spacing:1px;
    color:#777;
    text-transform:uppercase;
    margin-bottom:16px;
  }

  /* inputs */
  .input-group .form-control{
    height:46px;
    border-radius:2px !important;
    border:1px solid #dfe5ea;
    box-shadow:none !important;
    font-size:14px;
  }
  .input-group .form-control:focus{
    border-color:#2aa3df;
    box-shadow:0 0 0 .12rem rgba(42,163,223,.18) !important;
  }

  /* hide input icons to match screenshot (keep simple fields) */
  .input-group-append{display:none !important;}

  /* remember checkbox spacing */
  .icheck-primary label{
    color:#888;
    font-weight:400;
    font-size:13px;
  }

  /* LOGIN button like screenshot */
  .btn-primary.btn-block{
    background:#2aa3df;
    border-color:#2aa3df;
    border-radius:2px;
    padding:10px 0;
    font-size:12px;
    letter-spacing:.8px;
    text-transform:uppercase;
  }
  .btn-primary.btn-block:hover{
    background:#1e8fc7;
    border-color:#1e8fc7;
  }

  /* responsive */
  @media (max-width: 992px){
    .login-image{display:none;}
    .login-box{padding:90px 24px 40px 24px; width:100% !important; max-width:520px;}
    .login-form::after{top:70px;}
    .login-form .side-shadow{display:none;}
  }
</style>

<style>
  .field-error{
    margin-top:6px;
    padding:8px 10px;
    border-radius:6px;
    background:#fff5f5;
    border:1px solid #f5c2c7;
    color:#b02a37;
    font-size:13px;
    line-height:1.2;
    display:flex;
    align-items:flex-start;
    gap:8px;
  }
  .field-error i{ margin-top:1px; }
  .is-invalid-custom{
    border-color:#dc3545 !important;
  }
</style>


</head>

<body class="hold-transition">


<div class="login-wrapper">

  <!-- LEFT IMAGE SIDE -->
  <div class="login-image">
  <div class="login-image-content">
    <img src="{{ asset('images/sai_ngo.jpg') }}" alt="Login Image">
  </div>
</div>


  <!-- RIGHT LOGIN FORM -->
  <div class="login-form">
    <div class="login-box">
      <div class="card">
        <div class="card-body">
          <p class="login-box-msg">SIGN IN BELOW:</p>

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-2 input-group">
  <input type="email" name="email"
         value="{{ old('email') }}"
         class="form-control @error('email') is-invalid-custom @enderror"
         placeholder="E-mail" required autofocus autocomplete="username">

  <div class="input-group-append">
    <div class="input-group-text">
      <span class="fas fa-envelope"></span>
    </div>
  </div>
</div>

@error('email')
  <div class="field-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>{{ $message }}</div>
  </div>
@enderror


<div class="mt-3 mb-2 input-group">
  <input type="password" id="password" name="password"
         class="form-control @error('password') is-invalid-custom @enderror"
         placeholder="Password" required autocomplete="current-password">

  <div class="input-group-append">
    <div class="input-group-text">
      <span class="fas fa-lock"></span>
    </div>
  </div>
</div>

@error('password')
  <div class="field-error">
    <i class="fas fa-exclamation-circle"></i>
    <div>{{ $message }}</div>
  </div>
@enderror

            <div class="row align-items-center">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember_me" type="checkbox" name="remember">
                  <label for="remember_me">Remember me</label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>

  </div>
</div>


<!-- Scripts -->
<script src="{{ asset('backend-asset') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('backend-asset') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('backend-asset') }}/dist/js/adminlte.min.js"></script>
</body>
</html>
