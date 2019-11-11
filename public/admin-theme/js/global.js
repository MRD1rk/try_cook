function buttonUpdateStart(button) {
    button.html('<i class="fa fa-spinner fa-spin"></i> ' + button.text());
}

function buttonUpdateOk(button) {
    button.html('<i class="fa fa-check" aria-hidden="true"></i> ' + button.text());
}

function buttonUpdateError(button) {
    button.html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' + button.text());
}

/**
 *
 * @param text string
 * @param status boolean
 */
function showAlert(text, status = true) {
    let $class = status ? 'success' : 'danger';
    let html = '<div id="alert" class="alert alert-' + $class + '"><button type="button" class="close" data-dismiss="alert">&times;</button>'
        + text + '</div>';
    $('#alert').replaceWith(html);
    $('#alert').fadeIn();
    let height = $('#alert').outerHeight();
    clearTimeout();
    setTimeout(function () {
        $('#alert').animate({
            'top': -height
        }, 700);
    }, 2500);
}

$(function () {
    // Translation.load('global');

    //Generate link_rewrite
    $('.generate-link_rewrite').on('click', function (e) {
        let button = $(this);
        e.preventDefault();
        let input = $(this).parents('div.col-6').find('input.title-src');
        let title_val = input.val();
        if (title_val.length === 0) {
            showAlert(Translation.get('empty_value'), false);
            return true;
        }
        $.ajax({
            type:'post',
            url: prefix + '/transliteration',
            dataType: 'json',
            data: {value: title_val},
            success: function (data) {
                if (!data.status) {
                    showAlert(data.message, data.status);
                    return true;
                }
                button.siblings('input').val(data.content);
                // showAlert(Translation.get('updated'))
            }
        })
    });


    let current_uri = window.location.pathname;
    let navbar = $('#admin-navbar');
    if (navbar.length > 0) {
        let anchors = navbar.find('a');
        anchors.each(function () {
            if ($(this).attr('href') === current_uri) {
                $(this).parent('li').addClass('active');
            }
        })
    }
});