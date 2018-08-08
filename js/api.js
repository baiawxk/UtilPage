
function getJSON(url) {
    return $.getJSON(url).then(function(data) {
        console.log('CALL API', url, data);
        var d = $.Deferred();
        data = parseAPIJSONStr(data);
        d.resolve(data);
        return d.promise();
    }, function(error) {
        console.error('CALL API', url, error);
        var d = $.Deferred();
        d.reject({ status: false, "msg": "系统繁忙，请稍后重试" });
        return d.promise();
    })
}

function postJSON(url, data) {
    return $.post(url, { data: data }).then(function(data) {
        console.log('CALL API', url, data);
        var d = $.Deferred();
        data = parseAPIJSONStr(data);
        d.resolve(data);
        return d.promise();
    }, function(error) {
        console.error('CALL API', url, error);
        var d = $.Deferred();
        d.reject({ status: false, "msg": "系统繁忙，请稍后重试" });
        return d.promise();
    })
}
