$(function () {
    $('body').on('change', '#filter-block input', function () {
        changeFilter();
        console.log('checked')
    })
});

function changeFilter() {
    let features = [];
    var checked_inputs = $('#filter-block input:checked');
    checked_inputs.each(function () {
        let feature_value = $(this).val();
        features.push(feature_value);
    });
    let id_category = $('#filter-block').data('id_category');
    let data = {};
    data['id_category'] = id_category;
    data['features'] = features;
    data = $.extend(data, getToken());
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: data,
        url: '/' + iso_code + '/categories/filter',
        success: function (data) {
            $('#filter-block').replaceWith(data.filter_block);
            $('#recipes').replaceWith(data.recipes_block);
        }
    })
}