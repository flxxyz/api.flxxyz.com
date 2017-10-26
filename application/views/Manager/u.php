<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>主页面 - 管理</title>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/js/manager/manager.js"></script>
</head>
<body>
<header>
    <a href="<?= site_url('manager/logout') ?>">退出登陆</a>
    <?= session_id() ?>
</header>
<main>
    <?= $username ?>
</main>
<footer>
    <?= date('Y') ?>&copy;
</footer>

</body>
</html>