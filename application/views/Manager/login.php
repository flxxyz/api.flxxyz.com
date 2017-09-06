<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登陆 - 管理</title>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/js/manager.js"></script>
</head>
<body>
<?php
if ( $is_login ) {
    echo "<p>$message</p>" . $script;
}else {
    if ( $message ) {
        echo "<p>$message</p>";
    }
?>
<form action="<?php echo site_url('manager/loginc') ?>">
    <div class="box">
        <label for="username">用户名：</label>
        <input type="text" id="username" name="username" value="<?php echo $username;?>">
    </div>
    <div class="box">
        <label for="password">密&nbsp;&nbsp;码：</label>
        <input type="text" id="password" name="password">
    </div>
    <div class="box">
        <button name="submit">提交</button>
    </div>
</form>
</body>
</html>
<?php
}
?>