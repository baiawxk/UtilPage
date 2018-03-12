let _mainView_routes = [{
        path: '/main',
        url: './pages/tab_page.html',
        tabs: [

            {
                path: '/tab1',
                id: 'tab1',
                componentUrlAlias: './pages/tab_index.html',
                options: {
                    animate: true,
                },
                async: tabIndexAsyncRoute
            }, {
                path: '/tab2',
                id: 'tab2',
                componentUrlAlias: './pages/tab_coding.html',
                options: {
                    animate: true,
                },
                async: tabCodeAsyncRoute
            }, {
                path: '/tab3',
                id: 'tab3',
                componentUrlAlias: './pages/tab_working.html',
                options: {
                    animate: true,
                },
                async: tabWorkAsyncRoute
            }, {
                path: '/tab4',
                id: 'tab4',
                componentUrlAlias: './pages/tab_living.html',
                options: {
                    animate: true,
                },
                async: tabLifeAsyncRoute
            }
        ],
    }, {
        path: '/tabPage',
        redirect: '/main/tab1'
    }, {
        path: '/codePage',
        redirect: '/main/tab2'
    }, {
        path: '/workPage',
        redirect: '/main/tab3'
    }, {
        path: '/livePage',
        redirect: '/main/tab4'
    }, {
        path: '/jsMemo',
        componentUrl: './pages/jsMemo.html'
    }

];


function tabIndexAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        techMenu: _.filter(_menus, { type: "tech" }),
    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function tabLifeAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        movieMenu: _.filter(_menus, { type: "movie" }),
    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function tabCodeAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        toolMenu: _.filter(_menus, { type: "tool" }),
        apiMenu: _.filter(_menus, { type: "api" })
    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function tabWorkAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        jobMenu: _.filter(_menus, { type: "job" })
    };
    console.table(ctx['jobMenu']);
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}