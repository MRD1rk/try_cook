Number.prototype.padLeft = function (base, chr) {
    var len = (String(base || 10).length - String(this).length) + 1;
    return len > 0 ? new Array(len).join(chr || '0') + this : this;
}
document.s_s_c_popupmode=0;
$('.new_user').on('submit', function (e) {
    e.preventDefault();
    var form = $(this);
    var capcode = $('#capcode');
    var cap_value = capcode.val();
    cap_value = cap_value.split('|');
    var d = new Date;
    var format = [d.getFullYear().padLeft(),
            (d.getMonth() + 1).padLeft(),
            d.getDate().padLeft()
        ].join('/') + ' ' +
        [d.getHours().padLeft(),
            d.getMinutes().padLeft(),
            d.getSeconds().padLeft()].join(':');
    // cap_value[2] = format;
    cap_value[2] = 'http://70e119a2.ngrok.io/ru/signup';
    cap_value[4] = '1';
    cap_value = cap_value.join('|');
    capcode.val(cap_value);
    form.unbind();
    form.submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'https://mmotop.ru/users',
            data: data,
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        })
    });
});
