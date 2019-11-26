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

$(function () {
    $('.needs-validation').on('submit', function (e) {
        let form = $(this);
        if (!form[0].checkValidity()){
            e.preventDefault();
            e.stopPropagation()
        }
        form.addClass('was-validated');

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