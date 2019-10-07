$(function () {
    $('body').on('click', '.update-translation', function (e) {
        e.preventDefault();
        let button = $(this);
        let textareas = $(this).parents('.translation-item').find('textarea.translation-changed');
        if (textareas.length === 0) {
            showAlert('Empty translate!', false);
            return;
        }
        let data = [];
        $.each(textareas, function () {
            let id_lang = $(this).data('id_lang');
            let id_translation = $(this).data('id_translation');
            let value = $(this).val();
            data.push({id_lang: id_lang, id_translation: id_translation, value: value});
        });
        buttonUpdateStart(button);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: prefix + '/translations/update',
            data: {data: data},
            success: function (data) {
                if (data.status) {
                    showAlert(data.message);
                    buttonUpdateOk(button);
                } else {
                    showAlert(data.message,false);
                    buttonUpdateError(button)
                }
                $('textarea').removeClass('translation-changed');
            },
        })
    });
    /**
     * Add Css-class to changed field
     */
    $('body').on('input', '.translation-item textarea', function () {
        $(this).addClass('translation-changed')
    })
});