let _mainView_routes = [{
    path: '/main',
    url: './pages/tab_page.html',
    tabs: [{
        path: '/tab1',
        id: 'tab1',
        componentUrlAlias: './pages/tab_index.html',
        options: {
            animate: false,
        },
        async: tabIndexAsyncRoute
    }, {
        path: '/tab2',
        id: 'tab2',
        componentUrlAlias: './pages/tab_coding.html',
        options: {
            animate: false,
        },
        async: tabTradeAsyncRoute
    }, {
        path: '/tab3',
        id: 'tab3',
        componentUrl: './pages/tab_working.html',
        options: {
            animate: false,
        },
    }, {
        path: '/tab4',
        id: 'tab4',
        componentUrlAlias: './pages/tab_living.html',
        options: {
            animate: false,
        },
        async: tabAccountAsyncRoute
    }],
}, {
    path: '/tabPage',
    redirect: '/main/tab1'
}, {
    path: '/tradeIndex',
    redirect: '/main/tab2'
}, {
    path: '/StockIndex',
    redirect: '/main/tab3'
}, {
    path: '/AccountIndex',
    redirect: '/main/tab4'
}, {
    path: '/checkLogin',
    componentUrl: './pages/check_login.html',
}, {
    path: '/login',
    componentUrl: './pages/login.html',
}, {
    path: '/recharge',
    componentUrlAlias: './pages/recharge.html',
    async: rechargeAsyncRoute
}, {
    path: '/reflect',
    componentUrlAlias: './pages/reflect.html',
    async: reflectAsyncRoute
}, {
    path: '/firstLogin',
    componentUrl: './pages/first_login.html',
}, {
    path: '/fistAddInfo',
    componentUrl: './pages/first_add_person_info.html',
}, {
    path: '/addBankInfo',
    componentUrlAlias: './pages/add_bankinfo.html',
    async: addBankInfoAsyncRoute
}, {
    path: '/investDoc',
    componentUrl: './pages/invest_doc.html',
}, {
    path: '/wecharPay',
    componentUrl: './pages/wechatpay.html',
}, {
    path: '/bankAcPay',
    componentUrl: './pages/bankacpay.html',
}, {
    path: '/idConfirm',
    componentUrlAlias: './pages/id_confirm.html',
    async: idConfirmAsyncRoute
}, {
    path: '/customService',
    componentUrl: './pages/custom_service.html',
}, {
    path: '/publicService',
    componentUrl: './pages/public_service.html',
}, {
    path: '/inviteCode',
    componentUrlAlias: './pages/invite_code.html',
    async: inviteCodeAsyncRoute
}, {
    path: '/trade/:code',
    componentUrlAlias: './pages/tab_trade_detail.html',
    async: tradeDetailAsyncRoute
}];


function tabIndexAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {

    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function tabAccountAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {

    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function tabTradeAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {

    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function rechargeAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    //check idCard
    if (isIdCardConfirming()) {
        reject();
        qAlert('实名认证审核中');
        return;
    }
    if (!isIdCardConfirm()) {
        reject();
        qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
            router.navigate('/idConfirm', { history: false });
        })
        return;
    }
    app.preloader.show();
    let ctx = {
        hasRechargeRec: false,
        rechargeRec: []
    };
    let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    let rechargeList = app.data.rechargeList;
    ctx['hasRechargeRec'] = (rechargeList != null && rechargeList.length > 0);
    ctx['rechargeRec'] = rechargeList;
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function reflectAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    let app = router.app;
    //check idCard
    if (isIdCardConfirming()) {
        reject();
        qAlert('实名认证审核中');
        return;
    }
    if (!isIdCardConfirm()) {
        reject();
        qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
            router.navigate('/idConfirm', { history: false });
        })
        return;
    }
    //check bankCard
    if (app.data.bankInfo == null || app.data.bankInfo.length == 0) {
        reject();
        qAlert('您尚未绑定银行卡，请先进行绑定。').on('close', function() {
            router.navigate('/addBankInfo', { history: false });
        })
        return;
    }
    app.preloader.show();
    let ctx = {
        hasRechargeRec: false,
        hasBankCard: false,
        bankCard: {},
        rechargeRec: []
    };
    let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    let reflectList = app.data.reflectList;
    let bankInfo = app.data.bankInfo;
    ctx['hasRechargeRec'] = (reflectList != null && reflectList.length > 0);
    ctx['rechargeRec'] = reflectList;
    if (bankInfo != null && bankInfo.length > 0) {
        ctx['hasBankCard'] = true;
        ctx['bankCard'] = bankInfo[bankInfo.length - 1]['Bank'];
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function addBankInfoAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    //check idCard
    if (isIdCardConfirming()) {
        reject();
        qAlert('实名认证审核中');
        return;
    }
    if (!isIdCardConfirm()) {
        reject();
        qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
            router.navigate('/idConfirm', { history: false });
        })
        return;
    }
    app.preloader.show();
    let ctx = {
        money: "--",
        hasIdCard: false,
        hasBankCard: false,
        hasBankAccountName: false,
        name: '',
        idCard: "",
        bankCard: {}
    };
    let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    let bankInfo = app.data.bankInfo;
    let userInfo = app.data.userInfo;
    let accountInfo = app.data.accountInfo;
    if (bankInfo != null && bankInfo.length > 0) {
        ctx['hasBankCard'] = true;
        ctx['bankCard'] = bankInfo[bankInfo.length - 1]['Bank'];
    }
    if (userInfo != null) {
        if (userInfo['personal_code'] != null) {
            ctx['hasIdCard'] = true;
            ctx['idCard'] = userInfo['personal_code'];
            if (userInfo['name'] != null && $.trim(userInfo['name'] !== "")) {
                ctx['hasBankAccountName'] = true;
                ctx['name'] = userInfo['name'];
            }
        }
    }
    if (accountInfo != null) {
        ctx['money'] = accounting.formatMoney(accountInfo['total']);
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function idConfirmAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    //check idCard
    if (isIdCardConfirming()) {
        reject();
        qAlert('实名认证审核中');
        return;
    }
    app.preloader.show();
    let ctx = {
        name: ''
    };
    let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    let userInfo = app.data.userInfo;
    if (userInfo != null && $.trim(userInfo['name']) !== "") {
        ctx['name'] = userInfo['name'];
    }
    resolve(routeInfo, customSpec);
    app.preloader.hide();
}

function inviteCodeAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    //check idCard
    if (isIdCardConfirming()) {
        reject();
        qAlert('实名认证审核中');
        return;
    }
    if (!isIdCardConfirm()) {
        reject();
        qAlert('您尚未进行实名认证，请先进行认证。').on('close', function() {
            router.navigate('/idConfirm', { history: false });
        })
        return;
    }

    app.preloader.show();
    let ctx = {
        inviteCode: "---",
        inviteLink: location.origin,
    };
    let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    if (app.data.inviteCode == null) {
        $.when(fetchInviteCode())
            .done(function() {
                ctx['inviteCode'] = app.data.inviteCode;
                ctx['inviteLink'] = `${location.origin}?inviteCode=${app.data.inviteCode}`;
            })
            .always(function() {
                resolve(routeInfo, customSpec);
                app.preloader.hide();
            })
    } else {
        ctx['inviteCode'] = app.data.inviteCode;
        ctx['inviteLink'] = `${location.origin}?inviteCode=${app.data.inviteCode}`;
        resolve(routeInfo, customSpec);
        app.preloader.hide();
    }
}

function tradeDetailAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        code: "----",
        detailAry: [],
        currentStock: null,
        price: '----',
        money: '----'
    };
    ctx['code'] = routeTo['params']['code'];
    ctx['detailAry'] = app.data.quotationList[ctx['code']];
    ctx['currentStock'] = ctx['detailAry'][0];
    let routeInfo = { componentUrl: routeTo.route.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    let accountInfo = app.data.accountInfo;
    if (accountInfo != null) {
        ctx['money'] = accounting.formatMoney(accountInfo['total']);
    }
    stockQuote(ctx['code'])
        .done(function(data) {
            let status = data['status'];
            let msg = JSON.parse(data['msg']);
            if (status === true) {
                ctx['price'] = msg['buyOnePri'];
            }
        })
        .always(function(arguments) {
            resolve(routeInfo, customSpec);
            app.preloader.hide();
        })
}

function isIdCardConfirm() {
    let isConfirm = false;
    if (app.data != null && app.data.userInfo != null) {
        let status = app.data.userInfo['status'];
        isConfirm = (status === "2");
    }
    return isConfirm;
}

function isIdCardConfirming() {
    let isConfirm = false;
    if (app.data != null && app.data.userInfo != null) {
        let status = app.data.userInfo['status'];
        isConfirm = (status === "1");
    }
    return isConfirm;
}