// Initialize your app
var app = new Framework7({
    root: '#app',
    // theme: "ios",
    view: {
        iosDynamicNavbar: false,
    },
    routes: _mainView_routes
});

// Export selectors engine
var $$ = Dom7;

// fixAosHeight();
var mainView = app.views.create('.view-main',{
    url:'/tabPage'
});
mainView.router.on('routerAjaxError', function() {
    qAlert('网络繁忙，请稍后重试');
});

function fixAosHeight() {
    let tempH = $(document.body).height();
    let tempW = $(document.body).width();
    let max, min = null;
    if (tempH > tempW) {
        max = tempH;
        min = tempW;
    } else {
        max = tempW;
        min = tempH;
    }
    $(window).on('resize', function() {
        let h = window.screen.height;
        let w = window.screen.width;
        if (h > w) {
            $(document.body).height(max);
        } else {
            $(document.body).height(min);
        }
    })
}