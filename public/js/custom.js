
/**
 * Delay for sending ajax calls
 * @param callback
 * @param ms
 * @returns {Function}
 */
function delay(callback, ms,context) {
    var timer = 0;
    return function() {
        var args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}
function buttonUpdateStart(button) {
    button.html('<i class="fa fa-spinner fa-spin"></i> ' + button.text());
}

function buttonUpdateOk(button) {
    button.html('<i class="fa fa-check" aria-hidden="true"></i> ' + button.text());
}

function buttonUpdateError(button) {
    button.html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + button.text());
}
function csrf() {
    let token = $('meta[name=token]');
    if (token.length === 0)
        return;
    let tokenKey = token.attr('title');
    let tokenValue = token.attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN-KEY': tokenKey,
            'X-CSRF-TOKEN-VALUE': tokenValue
        }
    });
}
//begin input's filters function
function numberFilter(){

}
function stringFilter(){

}
//end input's filters function

$(function () {
    csrf();
    $('.needs-validation').on('submit', function (e) {
        let form = $(this);
        if (!form[0].checkValidity()) {
            e.preventDefault();
            e.stopPropagation()
        }
        form.addClass('was-validated');
    });
    $('#signin_form').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        let form = $(this);
        let button = form.find('button');
        let data = {};
        buttonUpdateStart(button);
        data.email = $('#signin_form #email').val();
        data.password = $('#signin_form #password').val();
        data.remember_me = +$('#signin_form #remember_me').is(':checked');
        $.ajax({
            url: '/' + iso_code + '/auth/signin',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function (data) {
                if (data.status) {
                    buttonUpdateOk(button);
                    let output = form.find('.valid-feedback');
                    output.html(data.message);
                    setTimeout(function () {
                        if (data.login_redirect_url)
                            location.href = data.login_redirect_url;
                        else
                            location.reload();
                    }, 1500)
                } else {
                    buttonUpdateError(button);
                    let output = form.find('.invalid-feedback');
                    output.html(data.message);
                }
            }
        })
    })
});

