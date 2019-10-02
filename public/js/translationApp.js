var Translation = {
    scope: null,
    load: function (category) {
        $.ajax({
            type: 'POST',
            url: '/'+iso_code+'/get-translations',
            dataType: 'json',
            async: false,
            data: {category: category},
            success: function (data) {
                Translation.scope = data.data;
            }
        })
    },
    get: function (key) {
        if (!(key in Translation.scope))
            return key;
        return Translation.scope[key];
    }
};