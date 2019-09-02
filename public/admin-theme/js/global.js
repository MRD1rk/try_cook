
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
 * @param text
 * @param status available values => ['success','info','warning','danger'];
 */
function showAlert(text, status = 'success') {
    status.replace('error', 'danger');
    let html = '<div id="alert" class="alert alert-' + status + '"><button type="button" class="close" data-dismiss="alert">&times;</button>'
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