var features = [];
var id_category;
$(function () {
    $('body').on('change', '#filter-block input', function () {
        changeFilter();
    });
    $('body').on('click', '#selected-filters .selected-filter-item', function () {
        let element = $(this);
        if (element.hasClass('all')) {
            features = [];
        } else {
            let id_feature_value = element.data('id_feature_value');
            features = features.filter(e => e !== id_feature_value);
        }
        let data = {};
        data['id_category'] = id_category;
        data['features'] = features;
        updateFilter(data);
    });
});

function updateSelectedFilter(filters) {
    let selected_filter_block = $('#selected-filters');
    let block = $('<div id="selected-filters"></div>');
    if (Object.keys(filters).length > 1)
        block.append('<div class="selected-filter-item all">Сбросить все</div>');
    $.each(filters, function () {
        let element = '<div class="selected-filter-item" data-id_feature_value="' + this.id_feature_value + '">' + this.feature_value + '</div>';
        block.append(element)
    });
    selected_filter_block.replaceWith(block);
}

function changeFilter() {
    features = [];
    var checked_inputs = $('#filter-block input:checked');
    checked_inputs.each(function () {
        let feature_value = $(this).val();
        features.push(feature_value);
    });
    id_category = id_category || $('#filter-block').data('id_category');
    let data = {};
    data['id_category'] = id_category;
    data['features'] = features;
    updateFilter(data);
}

function updateFilter(data) {
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: data,
        url: '/' + iso_code + '/categories/filter',
        success: function (data) {
            $('#filter-block').html(data.filter_block);
            if (data.selected_features)
                updateSelectedFilter(data.selected_features);
            $('#recipes').hide(function () {
                $('#recipes').html(data.recipes_block);
                $('#recipes').show("slow");
            });
        }
    })
}