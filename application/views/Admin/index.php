<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>首页</title>
    <link rel="stylesheet" href="/static/css/demo.css">
    <link rel="stylesheet" href="/static/css/chrome-tabs.css">
    <link rel="stylesheet" href="/static/css/chrome-tabs-dark-theme.css">
</head>
<body>

<iframe src="<?php echo base_url('admin/domain/list')?>" frameborder="1"></iframe>
<script src="/static/js/deps/draggabilly.js"></script>
<script src="/static/js/chrome-tabs.js"></script>
<script>
</script>
</body>
</html>
