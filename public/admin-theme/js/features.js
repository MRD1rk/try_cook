function updateFeatureActive(object) {
    let is_active = +object.is(':checked');
    let id_feature = object.data('id_feature');
    $.ajax({
        type: 'POST',
        url: prefix + '/features/update-active',
        dataType: 'json',
        data: {id_feature: id_feature, active: is_active},
        success: function (data) {
            showAlert(data.message, data.status)
        }
    })
}

function updateFeatureValueActive(object) {
    let is_active = +object.is(':checked');
    let id_feature_value = object.data('id_feature_value');
    $.ajax({
        type: 'POST',
        url: prefix + '/features/update-value-active',
        dataType: 'json',
        data: {id_feature_value: id_feature_value, active: is_active},
        success: function (data) {
            showAlert(data.message, data.status)
        }
    })
}

$(function () {
    $('#features-index').tableDnD({
            onDrop: function (table, row) {
                let rows = table.tBodies[0].rows;
                for (var i = 0; i < rows.length; i++) {
                    $('#' + rows[i].id + ' .position').val(i + 1);
                }
                let position = $('#' + row.id + ' .position').val();
                let id_feature = row.id;
                $.ajax({
                    type: 'POST',
                    url: prefix + '/features/update-position',
                    dataType: 'json',
                    data: {id_feature: id_feature, position: position},
                    success: function (data) {
                        showAlert(data.message, data.status)
                    }
                })
            },
            dragHandle: ".drugHandler",
        },
    );
    $('#features-view').tableDnD({
            onDrop: function (table, row) {
                let rows = table.tBodies[0].rows;
                for (var i = 0; i < rows.length; i++) {
                    $('#' + rows[i].id + ' .position').val(i + 1);
                }
                let position = $('#' + row.id + ' .position').val();
                let id_feature_value = row.id;
                $.ajax({
                    type: 'POST',
                    url: prefix + '/features/update-value-position',
                    dataType: 'json',
                    data: {id_feature_value: id_feature_value, position: position},
                    success: function (data) {
                        showAlert(data.message, data.status)
                    }
                })
            },
            dragHandle: ".drugHandler",
        },
    );
    let id_category = $('div[data-id_category]').data('id_category');
    $('#category-filters-table').tableDnD({
            onDrop: function (table, row) {
                let rows = table.tBodies[0].rows;
                rows = Array.from(rows);
                rows = rows.filter(function (item) {
                    return item.getElementsByClassName('position').length
                });
                for (var i = 0; i < rows.length; i++) {
                    $('#' + rows[i].id + ' .position').val(i + 1);
                }
                let position = $('#' + row.id + ' .position').val();
                let id_feature = row.id;
                $.ajax({
                    type: 'POST',
                    url: prefix + '/categories/update-feature-position',
                    dataType: 'json',
                    data: {id_feature: id_feature, position: position, id_category: id_category},
                    success: function (data) {
                        showAlert(data.message, data.status)
                    }
                })
            },
            dragHandle: ".drugHandler",
        },
    );
    $('#only-checked').on('change', function () {
        let checked = +$(this).is(':checked');
        if (checked) {
            let checkboxs = $('.category-filter-checkbox');
            $.each(checkboxs, function () {
                if (!$(this).is(':checked')) {
                    $(this).parents('tr').css('display', 'none');
                }
            })
        } else {
            $('tr').css('display', 'table-row');
        }

    })
    // let table = document.getElementById('category-filters-table');
    // if (table)
    //     sortTable(table, 0, -1);
});