<footer>
    <script src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/hitokoto/api?encode=js"></script>
    <div id="hitokoto">
        <script>hitokoto()</script>
    </div>
    <section>
        <?php echo @date('Y'); ?> Power by <a href="https://www.flxxyz.com" target="_blank">冯小贤</a>.
    </section>
</footer>
</body>
<script>
    <?php echo $script; ?>
</script>
</html>