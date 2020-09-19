'use strict';
$(function () {
    Translation.load('recipes_add', 'global', 'validation');
    // $(window).on('load', function() {
    //     $("#content").animate({opacity: "1"}, 150)
    //     $('.preloader').fadeOut('slow');
    // });
    let values = {};
    let id_recipe = $('#content').data('id_recipe');
    $('.feature-select').selectize({
        persist: true,
        onChange: function () {
            let input = this.$input.val();
            let name = this.$input.attr('name');
            values[name] = input;
        }
    });
    var enablePreloader = false;
    var preloader = $('#preloader');
    $(window).on('load', function () {
        if (enablePreloader) {
            preloader.fadeOut('slow', function () {
                $(this).remove();
            });
            $("#content").animate({opacity: "1"}, 150)
        } else {
            preloader.remove();
            $("#content").css('opacity', 1);
        }
    });
    $('#recipe_title').on('input', changeRecipeTitle);
    // restore from sessionStorage
    $.each($('*[data-keep]'), function () {
        let $this = $(this);
        let value = window.sessionStorage.getItem(id_recipe + '__' + $this.attr('name'));
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
    $('body').on('input', '.recipes-add input:not([type="file"]),textarea', function () {
        let $this = $(this);
        if ($this.attr('type') === 'radio' || $this.attr('type') === 'checkbox') {
            if (!$this.is(':checked')) {
                window.sessionStorage.removeItem(id_recipe + '__' + $this.attr('name'));
                return true;
            }
        }
        window.sessionStorage.setItem(id_recipe + '__' + $this.attr('name'), $this.val());
    });
    $('#recipe_title').recipeValidation({
        errorType: 'recipe_name_empty_error',
        parent: '.recipe-title-block'
    });
    $('.recipe-step-description-block textarea').recipeValidation({
        errorType: 'recipe_step_description_empty_error',
        parent: '.recipe-step-description-block'
    });
    $('.cooking-time-block').recipeValidation({
        rules: ['checkTime'],
        target: 'label',
        event: 'input',
        errorType: 'input_time_error'
    });
    $('#recipe_person_count').recipeValidation({
        rules: ['required', 'number'],
        target: 'label',
        errorType: 'person_count_error',
        minCount: 1,
        maxCount: 16
    });
    $('.filter-item-values.category').recipeValidation({
        rules: ['checked'],
        target: '.filter-item-title label',
        errorType: 'category_checked_error',
        parent: '.filter-item',
        event: 'change'
    })
    $('.filter-item-values.nationality').recipeValidation({
        rules: ['checked'],
        target: '.filter-item-title label',
        errorType: 'nationality_checked_error',
        parent: '.filter-item',
        event: 'change'
    });
    //save recipe event
    $('body').on('click', '#save-recipe', function () {
        let validation = $.fn.recipeValidation('validationAll');
        if (!validation) {
            return false;
        } else {
            let data = getRecipeData();
            $.ajax({
                type: 'POST',
                data: data,
                success: function (data) {
                    showAlert(data.message, data.status);
                    setTimeout(function () {
                        document.location.href = data.url;
                    }, 1500)
                }
            })
        }

    });
    //save to stash recipe
    $('body').on('click', '#save_recipe_to_draft', function () {
        let data = getRecipeData();
        data.draft = 1;
        $.ajax({
            type: 'POST',
            data: data,
            success: function (data) {
                showAlert(data.message, data.status);
                setTimeout(function () {
                    document.location.href = data.url;
                }, 1500)
            }
        });

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
                updateIngredientPosition(data.data)


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
                updatePartPosition(data.data);
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
                    parent.removeClass('not-image');
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
                    parent.removeClass('not-image');
                    parent.find('.add-recipe-preview-img').css('background-image', 'url(' + data.url + '?v=' + Math.random() + ')');
                }
            }

        })
    });

    /**
     * Input and send data about ingredient item
     */
    $('body').on('input change', '.weight-input', function () {
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
        let data = {
            count: count,
            id_ingredient: id_ingredient,
            id_unit: id_unit,
            id_recipe_ingredient: id_recipe_ingredient
        };
        let timer = setTimeout(function () {
            updateRecipeIngredient(data)
        }, 1000);
        input.data('timer', timer);

    });
    /**
     * Add ingredients block
     */
    $('body').on('click', '.btn-add-ingredient', function () {
        let parent = $(this).parents('.ingredient-block');
        let id_recipe_part = parent.parents('.recipe-part-item').data('id_recipe_part');
        parent = parent.find('.ingredient-items');
        $.ajax({
            type: 'POST',
            url: current_url + '/add-recipe-ingredient',
            dataType: 'json',
            data: {id_recipe_part: id_recipe_part},
            success: function (data) {
                if (data.status) {
                    parent.append(data.content);
                    let block_class = '.ingredient-item-' + data.position;
                    initRecipeIngredientSelectize(block_class);
                }
                showAlert(data.message, data.status);
            }

        });

    });
//Ingredient item sortable
    $('.ingredient-items').sortable({
        handle: '.draggable',
        axis: 'y',
        placeholder: 'sortable-placeholder',
        start: function (event, ui) {
            let handler = ui.helper.find('.draggable').first();
            handler.addClass('active');
            ui.item.data('start-pos', ui.item.index() + 1);
            ui.placeholder.height((ui.item.height() - 10));
            // ui.placeholder.css('height', '35px');
            ui.placeholder.css('width', '95%');
            $(this).sortable('refreshPositions');

        },
        stop: function (event, ui) {
            let handler = ui.item.find('.draggable').first();
            handler.removeClass('active');
        },
        update: function (event, ui) {
            let element = ui.item;
            let id_recipe_ingredient = element.data('id_recipe_ingredient');
            let position = element.data('position');
            $.ajax({
                type: 'POST',
                url: current_url + '/update-recipe-ingredient-position/' + id_recipe_ingredient,
                data: {position: position},
                success: function (data) {
                    showAlert(data.message, data.status);
                }
            })

        },
        change: function (e, ui) {
            var seq,
                startPos = ui.item.data('start-pos'),
                correction;
            correction = startPos <= ui.placeholder.index() ? 0 : 1;

            ui.item.parent().find('.ingredient-item').each(function (idx, el) {
                var $this = $(el),
                    $index = $this.index();
                if (($index + 1 >= startPos && correction === 0) || ($index + 1 <= startPos && correction === 1)) {
                    $index = $index + correction;
                    $this.attr('data-position', $index);
                }
            });
            seq = ui.item.parent().find('.sortable-placeholder').index() + correction;
            ui.item.data('position', seq);
            ui.item.attr('data-position', seq);
        }
    });
    $('.ingredient-items').disableSelection();
//Part item sortable
    $('.recipe-part-block').sortable({
        handle: '.draggable',
        axis: 'y',
        placeholder: 'sortable-placeholder',
        start: function (event, ui) {
            let handler = ui.helper.find('.draggable').first();
            handler.addClass('active');
            ui.item.data('start-pos', ui.item.index() + 1);
            ui.placeholder.height((ui.item.height() - 10));
            ui.placeholder.css('width', '95%');
            $(this).sortable('refreshPositions');

        },
        stop: function (event, ui) {
            let handler = ui.item.find('.draggable').first();
            handler.removeClass('active');
        },
        update: function (event, ui) {
            let element = ui.item;
            let id_recipe_part = element.data('id_recipe_part');
            let position = element.data('position');
            $.ajax({
                type: 'POST',
                url: current_url + '/update-recipe-part-position/' + id_recipe_part,
                data: {position: position},
                success: function (data) {
                    showAlert(data.message, data.status);
                }
            })

        },
        change: function (e, ui) {
            var seq,
                startPos = ui.item.data('start-pos'),
                correction;
            correction = startPos <= ui.placeholder.index() ? 0 : 1;

            ui.item.parent().find('.recipe-part-item').each(function (idx, el) {
                var $this = $(el),
                    $index = $this.index();
                if (($index + 1 >= startPos && correction === 0) || ($index + 1 <= startPos && correction === 1)) {
                    $index = $index + correction;
                    $this.attr('data-position', $index);
                }
            });
            seq = ui.item.parent().find('.sortable-placeholder').index() + correction;
            ui.item.data('position', seq);
            ui.item.attr('data-position', seq);
        }
    });
    $('.recipe-part-block').disableSelection();

    initEditor('#recipe_description');
    initRecipePartSelectize('.recipe-part-select');
    initRecipeIngredientSelectize('.ingredient-item')
});

function calculateCookTime(hours = 0, minutes = 0) {
    let hour_coefficient = 60;
    let minute_coefficient = 1;
    return (hours * hour_coefficient) + (minutes * minute_coefficient);

}

function initEditor(selector) {
    tinyMCE.init({
        selector: selector,
        required: true,
        menubar: false,
        inline:true,
        setup: function (ed) {
            ed.on('init', function (e) {
                $(selector).recipeValidation({
                    'rules' : ['requiredContenteditable'],
                    'target':'label',
                    'errorType' : 'recipe_description_empty_error'
                });
            })
        },
        autosave_ask_before_unload: false,
        autosave_restore_when_empty: true,
        plugins: ['autosave'],
        branding: false,
        resize: false,
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
        onChange: function (id) {
            /**
             * @todo clean weight input, when changing ingredient column
             * @type {jQuery}
             */
            let parent = this.$input.parents('.ingredient-item');
            let weight_input = parent.find('.weight-input');
            if (id == 6) {
                let id_recipe_ingredient = parent.data('id_recipe_ingredient');
                let id_ingredient = parent.find('.ingredient-select').val();
                let id_unit = parent.find('.unit-select').val();
                let data = {
                    count: 0,
                    id_ingredient: id_ingredient,
                    id_unit: id_unit,
                    id_recipe_ingredient: id_recipe_ingredient
                };
                updateRecipeIngredient(data);
                weight_input.attr('disabled', true);
                weight_input.val('')
            } else {
                weight_input.attr('disabled', false);
                weight_input.focus();
            }
        }
    });
}

function initRecipeIngredientSelectize(selector) {
    initRecipeUnitSelectize(selector + ' .unit-select');
    let error = false;
    $(selector + ' .ingredient-select').selectize({
        valueField: 'id',
        labelField: 'name',
        plugins: ['restore_on_backspace'],
        searchField: 'name',
        options: [],
        create: false,
        onChange: function (id_ingredient) {
            console.log('changed');
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
                let data = {};
                if (!value.saved) {
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
                return '<div data-error="' + select.data('error') + '" data-units="' + value.unit_available + '" data-value="' + value.id + '">' + value.name + '</div>'
            }
        },
        load: function (query, callback) {
            let except = [];
            let block = this.$input.parents('.ingredient-item');
            let selects = block.siblings('.ingredient-item').find('select.ingredient-select');
            selects.each(function () {
                except.push(parseInt($(this).val()))
            });
            if (!query.length || query.length < 3) return callback();
            let data = {};
            data['query'] = query;
            data['except'] = except;
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

/**
 * Check if need open block with need prepare time params
 */
function checkNeedPrepare() {
    let el = $('#need_prepare');
    let show = el.is(':checked');
    let block = $('.prepare-time-block');
    if (show) {
        block.fadeIn();
        block.recipeValidation({
            rules: ['checkTime'],
            target: 'label',
            event: 'input',
            errorType: 'input_time_error',
        });
    } else {
        block.fadeOut();
        block.recipeValidation('destroy')
        let prepare_hours = $('input[name="recipe_prepare_hours"]');
        let prepare_minutes = $('input[name="recipe_prepare_minutes"]');
        prepare_hours.val('');
        prepare_minutes.val('');

        window.sessionStorage.removeItem(prepare_hours.attr('name'));
        window.sessionStorage.removeItem(prepare_minutes.attr('name'));
    }
}

/**
 * Function for update data-position for ingredient-item
 * @param data
 */
function updateIngredientPosition(data) {
    for (let id_ingredient in data) {
        let element = $('[data-id_recipe_ingredient=' + id_ingredient + ']');
        element.removeClass('ingredient-item-' + element.data('position'))
        element.data('position', data[id_ingredient])
        element.attr('data-position', data[id_ingredient])
        element.addClass('ingredient-item-' + element.data('position'))
    }
}

/**
 * Function for update data-position for part-item
 * @param data
 */
function updatePartPosition(data) {
    for (let id_part in data) {
        let element = $('[data-id_recipe_part=' + id_part + ']');
        element.removeClass('recipe-part-item-' + element.data('position'))
        element.data('position', data[id_part])
        element.attr('data-position', data[id_part])
        element.addClass('recipe-part-item-' + element.data('position'))
    }
}

function updateRecipeIngredient(data) {
    let id_recipe_ingredient = data.id_recipe_ingredient;
    delete data.id_recipe_ingredient
    $.ajax({
        type: 'POST',
        url: current_url + '/update-recipe-ingredient/' + id_recipe_ingredient,
        dataType: 'json',
        data: data,
        success: function (data) {
            showAlert(data.message, data.status);
        }
    })
}

function changeRecipeTitle() {
    let value = $(this).val();
    if (value)
        $('.tc-title').text(value);
}

function getRecipeData() {
//recipe-data
    let recipe_title = $('#recipe_title').val();
    let difficulty_feature = 9;
    let recipe_description = tinyMCE.activeEditor.getContent({format: 'text'});
    let recipe_cooking_hours = $('#recipe_cooking_hours').val();
    let difficulty = $('input[name="features[' + difficulty_feature + ']"]').val()
    let recipe_cooking_minutes = $('#recipe_cooking_minutes').val();
    let recipe_cooking_time = calculateCookTime(recipe_cooking_hours, recipe_cooking_minutes);
    let default_person_count = $('#recipe_person_count').val().length  ? $('#recipe_person_count').val() : 1;
    let recipe_prepare_hours = $('#recipe_prepare_hours').val();
    let recipe_prepare_minutes = $('#recipe_prepare_minutes').val();
    let recipe_prepare_time = calculateCookTime(recipe_prepare_hours, recipe_prepare_minutes);
    let features = $('.filters-items input').not('[name="id_category"]');
    let id_category = $('input[name="id_category"]:checked').val();
    let step_description_elements = $('.recipe-step-description-block textarea');
    let steps = {};
    let feature_values = {};
    features.each(function () {
        let item = $(this);
        if (item.is(':checked')) {
            let key = item.data('id_feature');
            feature_values[key] = item.val();
        }
    });
    step_description_elements.each(function () {
        let item = $(this);
        let description = item.val();
        let parent = item.parents('.step-item');
        let id_step = parent.data('id_step');
        let position = parent.data('position');
        steps[id_step] = {
            position: position,
            description: description
        }
    });
    let recipe = {
        default_person_count: default_person_count,
        cooking_time: recipe_cooking_time,
        prepare_time: recipe_prepare_time,
        difficulty: difficulty,
    };
    let recipe_lang = {
        title: recipe_title,
        description: recipe_description
    }
    return {
        recipe: recipe,
        id_category: id_category ?? null,
        recipe_lang: recipe_lang,
        features: feature_values,
        steps: steps
    };
}