function getToken() {
    let token = $('meta[name=token]');
    if (token.length === 0)
        return {};
    let tokenKey = token.attr('title');
    let tokenValue = token.attr('content');
    let data = {};
    data[tokenKey] = tokenValue;
    return data;
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

$(function () {
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
// (function () {
//     'use strict';
//     window.addEventListener('load', function () {
//         // Fetch all the forms we want to apply custom Bootstrap validation styles to
//         var forms = document.getElementsByClassName('needs-validation');
//         // Loop over them and prevent submission
//         var validation = Array.prototype.filter.call(forms, function (form) {
//             form.addEventListener('submit', function (event) {
//                 if (form.checkValidity() === false) {
//                     event.preventDefault();
//                     event.stopPropagation();
//                 }
//                 form.classList.add('was-validated');
//             }, false);
//         });
//     }, false);
// })();