'use strict';
$(function () {
    Translation.load('recipes_add', 'global');
    let values = {};
    $('.feature-select').selectize({
        persist: true,
        onChange: function () {
            let input = this.$input.val();
            let name = this.$input.attr('name');
            values[name] = input;
        }
    });
    //restore from sessionStorage
    $.each($('.recipes-add input,textarea'), function () {
        let $this = $(this);
        let value = window.sessionStorage.getItem($this.attr('name'));
        if (value) {
            if ($this.attr('type') === 'radio' || $this.attr('type') === 'checkbox') {
                if (value === $this.val())
                    $this.prop('checked', true);
            } else
                $this.val(value)
        }
    });
    $('body').on('input', '.recipes-add input,textarea', function () {
        let $this = $(this);
        if ($this.attr('type') === 'radio' || $this.attr('type') === 'checkbox') {
            if (!$this.is(':checked')){
                window.sessionStorage.removeItem($this.attr('name'));
                return true;
            }
        }
        window.sessionStorage.setItem($this.attr('name'), $this.val());
    });
    //save recipe event
    $('body').on('click', '#save-recipe', function (e) {
        e.preventDefault();
        let recipe_title = $('#recipe_title').val();
        let recipe_description = $('#recipe_description').val();
        let recipe_cooking_hours = $('#recipe_cooking_hours').val();
        let recipe_cooking_minutes = $('#recipe_cooking_minutes').val();
        let recipe_cooking_time = calculateCookTime(recipe_cooking_hours, recipe_cooking_minutes);
        let recipe_person_count = $('#recipe_person_count').val();
        let recipe_prepare_hours = $('#recipe_prepare_hours').val();
        let recipe_prepare_minutes = $('#recipe_prepare_minutes').val();
        let recipe_prepare_time = calculateCookTime(recipe_prepare_hours, recipe_prepare_minutes);


    });
    checkNeedPrepare();
    $('#need_prepare').on('change', checkNeedPrepare);

    /**
     * Delete ingredient item
     */
    $('body').on('click', '.delete-ingredient', function () {
        let block = $(this).parents('.ingredient-item');
        block.fadeOut(function () {
            block.remove();
        });

    });

    /**
     * Add recipe-part block
     */
    $('body').on('click', '.add-recipe-part', function () {
        $.ajax({
            type:'POST',
            url: current_url + '/add-recipe-part',
            dataType: 'json',
            success:function (data) {
                
            }
        });
        let childs = $('.recipe-part-block>div').length;
        let block_number = childs + 1;
        let block_class = 'recipe-part-block-' + block_number;
        
        let html = '<div class="col-12 recipe-part-block"><div class="' + block_class + '">\n' +
            '                    <div class="row">\n' +
            '                        <div class="col-12">\n' +
            '                            <div class="row">\n' +
            '                                <div class="col-12">' +
            '                                   <div class="row">' +
            '                                       <div class="col-6">' +
            '                                           <label>' + Translation.get('recipe_part_title') + '</label></div>' +
            '                                       <div class="col-6 text-right">' +
            '                                           <p class="remove-recipe-part hovered-red"><i class="fas fa-trash"></i>&nbsp;' + Translation.get('remove_recipe_part') + '</p>' +
            '                                       </div> ' +
            '                                       </div>' +
            '                               </div>' +
            '                                <div class="col-10">\n' +
            '                                    <div class="form-group">\n' +
            '                                        <select name="recipe_part[value]" class="recipe-part-select"\n' +
            '                                           placeholder="' + Translation.get('begin_input') + '">\n' +
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
            '                </div></div>';
        console.log(html);
        let parent = $(this).parents('.col-12');
        parent.append($(html).hide().fadeIn());
        // parent.before(html);


        $('.' + block_class + ' .recipe-part-select').selectize({
            persist: true
        });
        $('.' + block_class + ' .unit-select').selectize({
            persist: true
        });
    });

    /**
     * Remove recipe-part
     */
    $('body').on('click', '.remove-recipe-part', function () {
        let block = $(this).parents('.recipe-part-block');
        block.fadeOut(function () {
            block.remove();
            recountPartBlock();
        })
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
        let input = $(this);
        let file = input.prop('files') && input.prop('files')[0] || null;
        if (!file)
            return true;
        let data = new FormData();
        data.append('preview_img', file);
        data = mergeData(data);
        $.ajax({
            type: 'POST',
            url: current_url + '/upload-image',
            processData: false,
            contentType: false,
            data: data,
            success: function (data) {
                if (data.status) {
                    let parent = input.parent('.preview-image-block');
                    parent.removeClass('no-image');
                    parent.find('.add-recipe-preview-img').css('background-image', 'url()');
                    parent.find('.add-recipe-preview-img').css('background-image', 'url(' + data.url + ')');
                }
            }

        })
    });


    /**
     * Delete this recipe's step
     *
     */
    $('body').on('click', '.remove-recipe-step', function () {
        let step_block = $(this).parents('.step-item');
        let textarea = step_block.find('textarea');
        window.sessionStorage.removeItem(textarea.attr('name'));
        let id_step = step_block.data('id_step');
        $.ajax({
            type: 'POST',
            url: current_url + '/delete-step/' + id_step,
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    step_block.fadeOut(function () {
                        this.remove();
                    })
                }
            }
        })
    });
    /**
     * Add new recipe's step
     */
    $('body').on('click', '#add_recipe_step', function () {
        $.ajax({
            type: 'POST',
            url: current_url + '/add-recipe-step',
            dataType: 'json',
            success: function (data) {
                let parent = $('.steps-block');
                let html = data.content;
                parent.append($(html).hide().fadeIn());
            }
        });
    });
    /**
     * Add recipe step image
     */
    $('body').on('change', '.recipe-step-image', function () {
        let input = $(this);
        let file = input.prop('files') && input.prop('files')[0] || null;
        if (!file)
            return true;
        let id_step = $(this).parents('.step-item').data('id_step');
        let data = new FormData();
        data.append('preview_img', file);
        data.append('id_step', id_step);
        data = mergeData(data);
        $.ajax({
            type: 'POST',
            url: current_url + '/upload-step-image',
            processData: false,
            contentType: false,
            data: data,
            success: function (data) {
                if (data.status) {
                    let parent = input.parent('.preview-image-block');
                    parent.find('img').attr('src', data.url);
                }
            }

        })
    });

    /**
     * Add ingredients block
     */
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
            '                                                <input placeholder="' + Translation.get('weight') + '" class="weight-input form-control">\n' +
            '                                            </div>\n' +
            '                                            <div class="col-5">\n' +
            '                                                <select class="unit-select">\n' +
            '                                                    <option value="">...</option>\n' +
            '                                                </select>\n' +
            '                                            </div>\n' +
            '                                            <div class="col-2">\n' +
            '                                                <div class="hovered-red delete-ingredient"><i class="fas fa-trash fa-2x"></i></div>\n' +
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

    initEditor('#recipe_description');
});

function calculateCookTime(hours = 0, minutes = 0) {
    let hour_coefficient = 3600;
    let minute_coefficient = 60;
    let result = (hours * hour_coefficient) + (minutes * minute_coefficient);
    return result;

}

function initEditor(selector) {
    tinyMCE.init({
        selector: selector,
        menubar: false,
        branding: false,
        language: iso_code || 'ru',
        toolbar: "undo redo | removeformat | bold italic | alignleft aligncenter alignright alignjustify"
    });
}

function recountPartBlock() {
    let childs = $('.recipe-part-block');
    let count = 1;
    $.each(childs, function () {
        let child = $(this).children();
        child.attr('class', '');//remove all classes
        child.addClass('recipe-part-block-' + count);
        count++;
    });
}
function checkNeedPrepare() {
    let el = $('#need_prepare');
    let show = el.is(':checked');
    if (show)
        $('.prepare-time-block').fadeIn();
    else {
        $('.prepare-time-block').fadeOut();
        let prepare_hours = $('input[name="recipe_prepare_hours"]');
        let prepare_minutes = $('input[name="recipe_prepare_minutes"]');
        prepare_hours.val('');
        prepare_minutes.val('');
        window.sessionStorage.removeItem(prepare_hours.attr('name'));
        window.sessionStorage.removeItem(prepare_minutes.attr('name'));
    }
}