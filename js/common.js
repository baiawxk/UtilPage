accounting.settings.currency.symbol = '￥';
Template7.registerHelper('formatMoney', accounting.formatMoney);

function qAlert(msg) {
    return app.dialog.alert(msg, _appTitle);
}

function qConfirm(msg1, msg2) {
    return app.dialog.confirm(msg1, _appTitle, function() {
        app.dialog.alert(msg2, _appTitle);
    });
}

function loadingWrap(promise) {
    if (promise && promise.then) {
        app.preloader.show();
        promise.always(function() {
            app.preloader.hide();
        })
    }
    return promise;
}


