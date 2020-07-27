const Translation = {
    scope: null,
    load: function (...category) {
        let data = {};
        data['category'] = category;
        $.ajax({
            type: 'POST',
            url: '/'+iso_code+'/get-translations',
            dataType: 'json',
            async: false,
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