<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
</script>
<head>用户登录</head>
<form name="LoginForm" method="post" action="{{url('/login')}}">
    <p>
        <label for="username" class="label">用户名:</label>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input id="username" name="username" type="text" class="input" />
    <p/>
    <p>
        <label for="password" class="label">密 码:</label>
        <input id="password" name="password" type="password" class="input" />
    <p/>
    <p>
        <input type="submit" name="submit" value="  确 定  " class="left" />
    </p>
</form>
</html>