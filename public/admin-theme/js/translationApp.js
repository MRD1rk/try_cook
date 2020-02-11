var Translation = {
    scope: null,
    load: function (category) {
        let data = {};
        data['category'] = category;
        $.ajax({
            type: 'POST',
            url: prefix+'/get-translations',
            dataType: 'json',
            async: true,
            data: data,
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