$(function () {
    Translation.load('recipes_add');
    let values = {};
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
    $('#need_prepare').on('change', function () {
        let show = $(this).is(':checked');
        if (show)
            $('.prepare-time-block').fadeIn();
        else
            $('.prepare-time-block').fadeOut();
    });

    //delete ingredient
    $('body').on('click', '.delete-ingredient', function () {
        let block = $(this).parents('.ingredient-item');
        block.fadeOut();
        setTimeout(function () {

            block.remove()
        }, 1000);
    });
    $('body').on('click', '.add-recipe-part', function () {
        let childs = $('.parts>div').length;
        let block_number = childs + 1;
        let block_class = 'recipe-part-block-' + block_number;
        let html = '<div class="row recipe-block"><div class="col-12 recipe-part-block ' + block_class + '">\n' +
            '                    <div class="row">\n' +
            '                        <div class="col-12">\n' +
            '                            <div class="row ">\n' +
            '                                <div class="col-10">\n' +
            '                                    <div class="form-group">\n' +
            '                                       <label>Название подраздела</label>' +
            '                                        <select name="recipe_part[id]" class="recipe-part-select"\n' +
            '                                                placeholder="' + Translation.get('begin_input') + '">\n' +
            '                                            <option value=""></option>\n' +
            '                                            <option>Основное</option>\n' +
            '                                            <option>Заправка</option>\n' +
            '                                            <option>Крем</option>\n' +
            '                                        </select>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n' +
            '                        <div class="col-6 add-ingredient-block">\n' +
            '                           <div class="btn-group">' +
            '                            <button class="btn btn-light btn-add-ingredient ">' + Translation.get('add_ingredient') + '<i\n' +
            '                                        class="fa fa-plus"></i></button>\n' +
            '                           </div>' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div></div> ';
        let parent = $(this).parents('.recipe-block');

        parent.after(html);


        $('.' + block_class + ' .recipe-part-select').selectize({
            persist: true
        });
        $('.' + block_class + ' .unit-select').selectize({
            persist: true
        });
    });
    $('body').on('click', '.show-all-filter', function () {
        let button = $(this);
        let parent = button.siblings('.filter-item-values');
        let marked_filter = parent.find('.marked.filter-item-value');
        setTimeout(function () {
            marked_filter.toggleClass('visible-hidden')
        }, 20);
        marked_filter.toggleClass('hide');
        button.find('i').toggleClass('fa-angle-double-up');
    });
    $('body').on('change', '#recipe_image', function () {
        let file = $(this).prop('files') && $(this).prop('files')[0] || null;
        if (!file)
            return true;
        let data = new FormData();
        data.append('preview_img', file);
        $.ajax({
            type: 'POST',
            url: '',
            processData: false,
            contentType: false,
            data:data,
            success: function (data) {
                console.log(data)
            }

        })
    });
    // $('body').on('change', 'input[name=id_category]', function () {
    //     let id_category = $(this).val();
    //
    // });
    $('body').on('click', '.btn-add-ingredient', function () {
        let parent = $(this).parents('.add-ingredient-block');
        let count = parent.parent().find('.ingredient-item').length + 1;
        let block_class = 'ingredient-item-' + count;
        let html =
            '                        <div class="col-12 ingredient-item ' + block_class + '">\n' +
            '                            <div>\n' +
            '                                <div class="row">\n' +
            '                                    <div class="col-6">\n' +
            '                                        <select placeholder="' + Translation.get('begin_input') + '" class="ingredient-select">\n' +
            '                                            <option value=""></option>\n' +
            '                                        </select>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-6">\n' +
            '                                        <div class="row">\n' +
            '                                            <div class="col-5">\n' +
            '                                                <input placeholder="' + Translation.get('weight') + '" class="form-control">\n' +
            '                                            </div>\n' +
            '                                            <div class="col-5">\n' +
            '                                                <select class="unit-select">\n' +
            '                                                    <option value="">...</option>\n' +
            '                                                </select>\n' +
            '                                            </div>\n' +
            '                                            <div class="col-2">\n' +
            '                                                <div class="delete-ingredient"><i class="fas fa-trash fa-2x"></i></div>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>\n';
        parent.before(html);
        let unit_selectize = $('.' + block_class + ' .unit-select').selectize({
            valueField: 'value',
            labelField: 'title',
        });
        $('.' + block_class + ' .ingredient-select').selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            options: [],
            create: false,
            render: {
                item: function (value) {
                    let data = {};
                    data.units = value.unit_available;
                    data = $.extend(data, getToken());
                    $.ajax({
                        type: 'POST',
                        url: '/api/get-units',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            var selectize = unit_selectize[0].selectize;
                            selectize.clearOptions();
                            for (var i in data.data) {
                                selectize.addOption(data.data[i]);
                            }
                            selectize.refreshOptions()

                        }
                    });
                    return '<div data-units="' + value.unit_available + '" data-value="' + value.id + '">' + value.name + '</div>'
                }
            },
            load: function (query, callback) {
                if (!query.length || query.length < 3) return callback();
                let data = {};
                data['query'] = query;
                data = $.extend(data, getToken());
                $.ajax({
                    url: '/api/get-ingredients',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res.data);

                    }
                });
            },
            persist: true
        });


    });
    tinyMCE.init({
        selector: '#recipe_description',
        menubar: false,
        branding: false,
        toolbar: " undo redo | removeformat | bold italic | alignleft aligncenter alignright alignjustify"
    });
});
