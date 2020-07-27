'use strict';
(function ($) {

    var defaults = {
        rules: ['required'],
        target: '',
        event: 'change input',
        errorType: '',
        parent: 'div.form-group'
    };
    var invalidStorage = [];
    var methods = {
        init: function (options) {
            let $this = $(this);
            let init = $this.data('validation');
            if (init)
                return this;
            else {
                var params = $.extend({}, defaults, options);
                let data = {
                    id:Math.random().toString(36).substr(2, 9),
                    params:params
                }
                $this.data('validation', data);
                methods.trigger($this, params);
                return this.on(params.event, function () {
                    methods.trigger($this, params);
                    methods.doValidation();
                })
            }
        },
        required: function (content) {
            let value = null;
            if (content.prop('tagName') === 'INPUT') {
                value = content.val();
            } else {
                let inputs = content.find('input')
                inputs.each(function () {
                    $(this).val($(this).val().replace(/[^\d]/, ''));
                    value = !$(this).val().length;
                });
            }
            return {
                result: value.length === 0,
                element: content
            };
        },
        number: function (content) {
            function checkValue(value) {
                let error = false;
                value = value.replace(/[^\d]/, '');
                error = value.length === 0;
                let params = content.data('validation').params
                if (params.minCount && params.maxCount) {
                    error = !(value >= params.minCount && value <= params.maxCount)
                }
                if (error)
                    value = '';
                return {result:error,value:value};
            }
            let result = false;
            if (content.prop('tagName') === 'INPUT') {
                let value = checkValue(content.val());
                content.val(value.value)
                result = value.result;
            } else {
                let inputs = content.find('input')
                inputs.each(function () {
                    let value = checkValue($(this).val());
                    $(this).val(value.value);
                    result = value.result;
                });
            }
            return {
                result: result,
                element: content
            }
        },
        checked: function (content) {
            let result = false;
            let inputs = content.find('input');
            inputs.each(function (item) {
                result = $(item).is(':checked')
            })
            return {
                result: result,
                element: content
            }
        },
        checkTime: function (content) {
            let inputs = content.find('input');
            let result = false;
            let hours = $(inputs[0]);
            let minunes = $(inputs[1]);
            if (!(/^([1-2]{1}[0-3]{0,1}?$)/).test(hours.val()))
                hours.val('')
            if (!(/^([1-5]{0,1}[0-9]{0,1}?$)/).test(minunes.val()))
                minunes.val('')
            let value1 = hours.val(hours.val().replace(/[^\d]/, '')).val();
            let value2 = minunes.val(minunes.val().replace(/[^\d]/, '')).val();
            result = (value1 >= 1 && value1 < 24) || (value2 >= 1 && value2 < 60);
            return {
                result: !result,
                element: content
            }
        },
        showError: function (target, message) {
            let parent = target.parent;
            parent.removeClass('field-has-error');
            parent.find(target.target).prev('.error-container').remove();
            parent.addClass('field-has-error');
            parent.find(target.target).before('<div class="error-container"><i class="error-icon fa fa-exclamation-circle" aria-hidden="true"></i><div class="error-message">' + message + '</div></div>');
        },
        hideError: function (target) {
            let parent = target.parent;
            parent.removeClass('field-has-error');
            parent.find(target.target).prev('.error-container').remove();
        },
        getTarget: function (item) {
            let options = item.data('validation') ? item.data('validation').params : [];
            let target = item;
            let parent = item.parents(options.parent);
            if (options.target) {
                target = $(parent).find(options.target);
            }
            return {target: target, parent: parent};
        },
        destroy: function () {

            return this.each(function () {
                var $this = $(this);
                methods.hideError(methods.getTarget($this));
                invalidStorage.filter(function (item) {
                    return item.id !== $this.data('validation').id;
                });
                $this.removeData('validation');

            })

        },
        trigger: function ($this, params) {
            let rules = params.rules.map(function (value) {
                return {type: value, message: Translation.get(params.errorType)};
            });
            rules.forEach(function (item) {
                let method = item.type;
                let result = methods[method]($this);
                let id = $this.data('validation').id;
                let object = {
                    id: id,
                    target: methods.getTarget(result.element, params),
                    message: item.message
                };

                if (result.result) {
                    invalidStorage[id] = object;
                    $this.data('validation').hasError = true;
                } else {
                    delete invalidStorage[id];
                    methods.hideError(object.target)
                    $this.data('validation').hasError = false;
                }
            });
        },
        doValidation: function () {
            for (let key in invalidStorage) {
                let item = invalidStorage[key];
                methods.showError(item.target, item.message);
            }
            return Object.keys(invalidStorage).length === 0;
        }
    };

    $.fn.myValidation = function (method) {

        // логика вызова метода
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод с именем ' + method + ' не существует для jQuery.tooltip');
        }
    };

})(jQuery);