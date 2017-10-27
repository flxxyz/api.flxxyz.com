var on = $('<button id="on">确定</button>');
on.click(function () {
    window.location.href = '/manager/login?token='+$('input.csf').val();
})

var off = $('<button id="off">取消</button>');
off.click(function () {
    window.location.href = '/manager/login?token=quit';
})

var div = $('<div></div>').append(on, off);
$('p').after(div);