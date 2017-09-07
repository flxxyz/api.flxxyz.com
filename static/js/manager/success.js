var timer = setInterval(function() {
    var a = parseInt($('#time').text());
    if(a === 0) {
        clearInterval(timer);
    }
    $('#time').text(--a);
}, 1000);
var redirect = setTimeout(function() {
    window.location.href = url;
}, 3000);