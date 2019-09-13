$(function () {
    let values = {};
    $('.unit-select').selectize({
        persist:true
    });
    $('.ingredient-select').selectize({
        persist:true
    });
    $('.feature-select').selectize({
        persist: true,
        onChange: function () {
            let input = this.$input.val();
            let name = this.$input.attr('name');
            values[name] = input;
        }
    });
    $('.submit').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: values,
            success: function (data) {

            }
        })
    });
    tinyMCE.init({
        selector: '#recipe_description',
        menubar: false,
        branding: false,
        toolbar: " undo redo | removeformat | bold italic | alignleft aligncenter alignright alignjustify"
    })
});