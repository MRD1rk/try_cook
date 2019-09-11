$(function () {
    let values = {};
    $('.feature-select').selectize({
        persist: true,
        onChange:function (value) {
            let input = this.$input.val()
            let name = this.$input.attr('name')
            values[name] = input;
        }
    });
    $('.submit').on('click',function (e) {
        e.preventDefault();
        $.ajax({
            type:'POST',
            dataType:'json',
            data:values,
            success:function (data) {

            }
        })
    })
});