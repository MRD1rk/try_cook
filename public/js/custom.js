/**
 * Delay for sending ajax calls
 * @param callback
 * @param ms
 * @returns {Function}
 */
function delay(callback, ms, context) {
    var timer = 0;
    return function () {
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

function showAlert(text, status) {
    console.log('called');
    let alert_block = $('.toast-wrapper');
    let delay = 4000;
    let type, icon;
    let auto_hide = true;
    if (status) {
        type = 'success';
        icon = 'fa-check';
    } else {
        type = 'error';
        icon = 'fa-exclamation-triangle';
    }
    let html = '<div class="toast toast-' + type + '" data-autohide="' + auto_hide + '" data-delay="' + delay + '">\n' +
        '        <div class="toast-header">\n' +
        '            <strong class="mr-auto"><i class="fa ' + icon + '" aria-hidden="true"></i>&nbsp;' + type + '</strong>\n' +
        '            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n' +
        '                <span aria-hidden="true">&times;</span>\n' +
        '            </button>\n' +
        '        </div>\n' +
        '        <div class="toast-body">' + text +
        '        </div>\n' +
        '        <div class="toast-progress"></div>\n' +
        '    </div>';
    alert_block.append(html);
    $('.toast').toast('show');
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

$(function () {
    csrf();
    $('.needs-validation').on('submit', function (e) {
        let form = $(this);
        if (!form[0].checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.addClass('was-validated');
    });
    $('#signin_form').on('submit', function (e) {
        let form = $(this);
        if (!form[0].checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            return false;
        }
        form.addClass('was-validated');
        e.preventDefault();
        e.stopPropagation();
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
    });

    $('body').on('shown.bs.toast','.toast', function () {
        let toast = $(this);
        let autohide = toast.data('autohide');
        if (autohide) {
            let progressBar = toast.find('.toast-progress');
            let delay = toast.data('delay') / 1000;
            progressBar.css('transition', delay + 's');
            progressBar.css('right', '100%');
        }
    });
    $('body').on('hidden.bs.toast','.toast', function () {
        $(this).remove();
    });

    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    });
});

