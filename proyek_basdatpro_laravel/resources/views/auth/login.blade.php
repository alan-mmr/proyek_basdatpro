<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Inventaris QYU</title>
  <style>
    body{font-family:Inter,system-ui,Arial;padding:28px;background:#f7f8f9}
    .box{max-width:420px;margin:40px auto;background:#fff;padding:20px;border-radius:10px;border:1px solid #eee}
    input{width:100%;padding:10px;margin:8px 0;border:1px solid #ddd;border-radius:6px}
    button{padding:10px 14px;border-radius:8px;border:0;background:#c92b2b;color:#fff;cursor:pointer}
    .err{color:#c92b2b;margin-bottom:8px}
  </style>
</head>
<body>
  <div class="box">
    <h3>Login Inventaris QYU</h3>

    @if(session('success'))<div style="color:green">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="err">{{ $errors->first() }}</div>@endif

    <form method="post" action="{{ route('login.post') }}">
      @csrf
      <label>Username</label>
      <input name="username" value="{{ old('username') }}" autofocus>

      <label>Password</label>
      <input type="password" name="password">

      <div style="margin-top:10px">
        <button type="submit">Login</button>
      </div>
    </form>

   <dl style="font-size:13px;color:#666;margin-top:12px">
    <dt>Dev helper:</dt>
    <dd><a href="/set-session/1">set superadmin</a></dd>
    <dd><a href="/set-session/2">set Admin</a></dd>
    <dd><a href="/set-session/3">set Manager</a></dd>
    <dd><a href="/set-session/4">set Staff</a></dd>
    <dd><a href="/set-session/5">set Gudang</a></dd>
   </dl>

  </div>
</body>
</html>
