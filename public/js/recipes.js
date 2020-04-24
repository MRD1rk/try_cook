'use strict';
$(function () {
    // Translation.load('recipes_add', 'global');
    let values = {};
    $('.feature-select').selectize({
        persist: true,
        onChange: function () {
            let input = this.$input.val();
            let name = this.$input.attr('name');
            values[name] = input;
        }
    });
    // restore from sessionStorage
    $.each($('*[data-keep]'), function () {
        let $this = $(this);
        let value = window.sessionStorage.getItem($this.attr('name'));
        if (value) {
            if ($this.attr('type') === 'radio' || $this.attr('type') === 'checkbox') {
                if (value === $this.val()) {
                    $this.prop('checked', true);
                    setTimeout(function () {
                        $this.parents('.filter-item').find('.show-all-filter').click();
                    }, 100);
                }
            } else
                $this.val(value)
        }
    });
    $('body').on('input', '.recipes-add input,textarea', function () {
        let $this = $(this);
        if ($this.attr('type') === 'radio' || $this.attr('type') === 'checkbox') {
            if (!$this.is(':checked')) {
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
        let $this = $(this);
        let id_ingredient = $this.parents('.ingredient-item').data('id_recipe_ingredient');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: current_url + '/delete-recipe-ingredient/' + id_ingredient,
            success: function (data) {
                let block = $this.parents('.ingredient-item');
                block.fadeOut(function () {
                    block.remove();
                });
                showAlert(data.message, data.status);
            }
        });

    });

    /**
     * Add recipe-part block
     */
    $('body').on('click', '.add-recipe-part', function () {
        let parent = $(this).parents('.col-12').siblings('.recipe-part-block');
        $.ajax({
            type: 'POST',
            url: current_url + '/add-recipe-part',
            dataType: 'json',
            success: function (data) {
                let html = data.content;
                let block_number = data.position;
                let block_class = 'recipe-part-item-' + block_number;
                parent.append($(html).hide().fadeIn());
                let selector = '.' + block_class + ' .recipe-part-select';
                initRecipePartSelectize(selector);
                let ingredient_block_class = '.' + block_class + ' .ingredient-item';
                initRecipeIngredientSelectize(ingredient_block_class);
                showAlert(data.message, data.status);
            }
        });
    });

    /**
     * Remove recipe-part
     */
    $('body').on('click', '.remove-recipe-part', function () {
        let block = $(this).parents('.recipe-part-item');
        let id_recipe_part = block.data('id_recipe_part');
        $.ajax({
            type: 'POST',
            url: current_url + '/delete-part/' + id_recipe_part,
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    block.fadeOut(function () {
                        block.remove();
                    })
                }
                showAlert(data.message, data.status);
            }
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
        let input = $(this);
        let file = input.prop('files') && input.prop('files')[0] || null;
        if (!file)
            return true;
        let data = new FormData();
        data.append('preview_img', file);
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
                    parent.find('.add-recipe-preview-img').css('background-image', 'url(' + data.url + '?v=' + Math.random() + ')');
                }
                showAlert(data.message, data.status);
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
                showAlert(data.message, data.status);
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
                showAlert(data.message, data.status);
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
        $.ajax({
            type: 'POST',
            url: current_url + '/upload-step-image',
            processData: false,
            contentType: false,
            data: data,
            success: function (data) {
                showAlert(data.message, data.status);
                if (data.status) {
                    let parent = input.parent('.preview-image-block');
                    parent.removeClass('no-image');
                    parent.find('.add-recipe-preview-img').css('background-image', 'url(' + data.url + '?v=' + Math.random() + ')');
                }
            }

        })
    });

    $('body').on('input', '.weight-input', function () {
        let input = $(this);
        let count = input.val();
        let clean_val = count.replace(/\D+/g, '');
        if (count !== clean_val) {
            input.val(clean_val);
            return;
        }
        if (count.length === 0)
            return;
        clearTimeout(input.data('timer'));
        let parent = input.parents('.ingredient-item');
        let id_recipe_ingredient = parent.data('id_recipe_ingredient');
        let id_ingredient = parent.find('.ingredient-select').val();
        let id_unit = parent.find('.unit-select').val();
        let timer = setTimeout(function () {
            $.ajax({
                type: 'POST',
                url: current_url + '/update-recipe-ingredient/' + id_recipe_ingredient,
                dataType: 'json',
                data: {count: count, id_ingredient: id_ingredient, id_unit: id_unit},
                success: function (data) {
                    showAlert(data.message, data.status);
                }
            })
        }, 1000);
        input.data('timer', timer);

    });
    /**
     * Add ingredients block
     */
    $('body').on('click', '.btn-add-ingredient', function () {
        let parent = $(this).parents('.ingredient-block');
        let id_recipe_part = parent.parents('.recipe-part-item').data('id_recipe_part');
        $.ajax({
            type: 'POST',
            url: current_url + '/add-recipe-ingredient',
            dataType: 'json',
            data: {id_recipe_part: id_recipe_part},
            success: function (data) {
                if (data.status) {
                    parent.children('.row').append(data.content);
                    let block_class = '.ingredient-item-' + data.position;
                    initRecipeIngredientSelectize(block_class);
                }
                showAlert(data.message, data.status);
            }

        });

    });

    initEditor('#recipe_description');
    initRecipePartSelectize('.recipe-part-select');
    initRecipeIngredientSelectize('.ingredient-item')
});

function calculateCookTime(hours = 0, minutes = 0) {
    let hour_coefficient = 3600;
    let minute_coefficient = 60;
    return (hours * hour_coefficient) + (minutes * minute_coefficient);

}

function initEditor(selector) {
    tinyMCE.init({
        selector: selector,
        menubar: false,
        branding: false,
        height: 150,
        language: iso_code || 'ru',
        toolbar: "undo redo | removeformat | bold italic | alignleft aligncenter alignright alignjustify"
    });
}

function initRecipePartSelectize(selector) {
    $(selector).selectize({
        persist: true,
        onChange: function (id_part) {
            let id_recipe_part = this.$input.data('id_recipe_part');
            $.ajax({
                type: 'POST',
                url: current_url + '/update-recipe-part',
                dataType: 'json',
                data: {id_part: id_part, id_recipe_part: id_recipe_part},
                success: function (data) {
                }
            })
        }
    });
}

function initRecipeUnitSelectize(unit_selector) {
    $(unit_selector).selectize({
        valueField: 'value',
        plugins: ['restore_on_backspace'],
        labelField: 'title',
        lock: true,
        onChange: function () {
            let parent = this.$input.parents('.ingredient-item');
            let weight_input = parent.find('.weight-input');
            weight_input.attr('disabled', false);
            weight_input.focus();
        }
    });
}

function initRecipeIngredientSelectize(selector) {
    initRecipeUnitSelectize(selector + ' .unit-select');
    $(selector + ' .ingredient-select').selectize({
        valueField: 'id',
        labelField: 'name',
        plugins: ['restore_on_backspace'],
        searchField: 'name',
        options: [],
        create: false,
        onChange: function (id_ingredient) {
            if (!id_ingredient.length) {
                let parent = this.$input.parents('.ingredient-item');
                var selectize = parent.find('.unit-select')[0].selectize;
                selectize.clear();
                selectize.clearOptions();
            }
        },
        render: {
            item: function (value) {
                let select = this.$input;
                let parent = select.parents('.ingredient-item');
                console.log(parent);
                let data = {};
                if (!value.get_unit) {
                    data.units = value.unit_available;
                    $.ajax({
                        type: 'POST',
                        url: '/api/get-units',
                        dataType: 'json',
                        data: data,
                        success: function (data) {
                            var selectize = parent.find('.unit-select')[0].selectize;
                            selectize.clearOptions();
                            for (var i in data.data) {
                                selectize.addOption(data.data[i]);
                            }
                            selectize.refreshOptions()

                        }
                    });
                }
                return '<div data-units="' + value.unit_available + '" data-value="' + value.id + '">' + value.name + '</div>'
            }
        },
        load: function (query, callback) {
            if (!query.length || query.length < 3) return callback();
            let data = {};
            data['query'] = query;
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