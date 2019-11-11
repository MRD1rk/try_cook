function updateCategoryActive(object) {
    let is_active = +object.is(':checked');
    let id_category = object.data('id_category');
    $.ajax({
        type: 'POST',
        url: prefix + '/categories/update-active',
        dataType: 'json',
        data: {id_category: id_category, active: is_active},
        success: function (data) {
            showAlert(data.message, data.status)
        }
    })
}
$(function () {
    $('#categories-index,#categories-view').tableDnD({
            onDrop: function (table, row) {
                let rows = table.tBodies[0].rows;
                for (var i = 0; i < rows.length; i++) {
                    $('#' + rows[i].id + ' .position').val(i + 1);
                }
                let position = $('#' + row.id + ' .position').val();
                let id_category = row.id;
                $.ajax({
                    type: 'POST',
                    url: prefix + '/categories/update-position',
                    dataType: 'json',
                    data: {id_category: id_category, position: position},
                    success: function (data) {
                        showAlert(data.message, data.status)
                    }
                })
            },
            dragHandle: ".drugHandler",
        }
    );

});