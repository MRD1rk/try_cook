$(function () {
    let values = {};
    $('.unit-select').selectize({
        persist: true
    });
    // $('.ingredient-select').selectize({
    //     persist: true
    // });
    // $('.recipe-part-select').selectize({
    //     persist: true
    // });
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


    $('body').on('click', '.add-recipe-part', function () {
        let childs = $('.parts>div').length;
        let block_number = childs + 1;
        let block_class = 'recipe-part-block-' + block_number;
        let html = '<div class="col-12 recipe-part-block ' + block_class + '">\n' +
            '                    <div class="row">\n' +
            '                        <div class="col-12">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-6">\n' +
            '                                    <div class="form-group">\n' +
            '                                        <select name="recipe_part[id]" class="recipe-part-select"\n' +
            '                                                placeholder="Начните вводить...">\n' +
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
            '                            <button class="btn btn-light btn-add-ingredient ">Добавить ингридиент<i\n' +
            '                                        class="fa fa-plus"></i></button>\n' +
            '                           </div>' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                </div>';
        let parent = $(this).parents('.col-12').siblings('.parts');

        parent.append(html);


        $('.' + block_class + ' .recipe-part-select').selectize({
            persist: true
        });
        $('.' + block_class + ' .unit-select').selectize({
            persist: true
        });
    });
    $('body').on('click', '.btn-add-ingredient', function () {
        let parent = $(this).parents('.add-ingredient-block');
        let count = parent.parent().find('.ingredient-item').length + 1;
        let block_class = 'ingredient-item-' + count;
        let html =
            '                        <div class="col-12 ingredient-item ' + block_class + '">\n' +
            '                            <div>\n' +
            '                                <div class="row">\n' +
            '                                    <div class="col-6">\n' +
            '                                        <select class="ingredient-select">\n' +
            '                                            <option value="">Начните вводить...</option>\n' +
            '                                            <option value="2">Рис</option>\n' +
            '                                            <option value="3">Ананас</option>\n' +
            '                                            <option value="4">Авокадо</option>\n' +
            '                                        </select>\n' +
            '                                    </div>\n' +
            '                                    <div class="col-6">\n' +
            '                                        <div class="row">\n' +
            '                                            <div class="col-5">\n' +
            '                                                <input placeholder="Вес" class="form-control">\n' +
            '                                            </div>\n' +
            '                                            <div class="col-5">\n' +
            '                                                <select class="unit-select">\n' +
            '                                                    <option value="">...</option>\n' +
            '                                                    <option value="1">шт</option>\n' +
            '                                                    <option value="2">кг</option>\n' +
            '                                                    <option value="3">пучек</option>\n' +
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
        $('.' + block_class + ' .unit-select').selectize({
            persist: true
        });
        $('.' + block_class + ' .ingredient-select').selectize({
            valueField: 'name',
            labelField: 'name',
            searchField: 'name',
            options: [],
            create: false,
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: 'get-ingredient',
                    type: 'POST',
                    dataType: 'json',
                    data: {query: query,},
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
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