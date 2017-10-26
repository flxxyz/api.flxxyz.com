var timer = setInterval(function() {
    var $time = $('#time');
    var n = $time.text();
    if(parseInt($time.text()) === 0) {
        clearInterval(timer);
        $time.text(0);
    }
    $time.text(--n);
}, 1000);
var redirect = setTimeout(function() {
    window.location.href = url;
}, 3000);