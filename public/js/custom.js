function getToken() {
    let token = $('meta[name=token]');
    if (token.length === 0)
        return {};
    let tokenKey = token.attr('title');
    let tokenValue = token.attr('content');
    let data = {};
    data[tokenKey] = tokenValue;
    return data;
}