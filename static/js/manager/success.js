var timer = setInterval(function() {
    var $time = $('#time');
    if(parseInt($time.text()) === 0) {
        clearInterval(timer);
        $time.text(0);
    }
    $time.text(--a);
}, 1000);
var redirect = setTimeout(function() {
    window.location.href = url;
}, 3000);