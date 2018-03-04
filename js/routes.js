let _mainView_routes = [{
    "path": '/main',
    url: './pages/qyjf_tab_page.ctp',
    tabs: [{
        path: '/tab1',
        id: 'tab1',
        componentUrlAlias: './pages/qyjf_tab_index.ctp',
        async: tabIndexAsyncRoute
    }, {
        path: '/tab2',
        id: 'tab2',
        componentUrlAlias: './pages/qyjf_tab_trade.ctp',
        async: tabTradeAsyncRoute
    }, {
        path: '/tab3',
        id: 'tab3',
        componentUrl: './pages/qyjf_tab_stocks.ctp',
    }, {
        path: '/tab4',
        id: 'tab4',
        componentUrlAlias: './pages/qyjf_tab_account.ctp',
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
    componentUrl: './pages/qyjf_check_login.ctp',
}, {
    path: '/login',
    componentUrl: './pages/qyjf_login.ctp',
}, {
    path: '/recharge',
    componentUrlAlias: './pages/qyjf_recharge.ctp',
    async: rechargeAsyncRoute
}, {
    path: '/reflect',
    componentUrlAlias: './pages/qyjf_reflect.ctp',
    async: reflectAsyncRoute
}, {
    path: '/firstLogin',
    componentUrl: './pages/qyjf_first_login.ctp',
}, {
    path: '/fistAddInfo',
    componentUrl: './pages/qyjf_first_add_person_info.ctp',
}, {
    path: '/addBankInfo',
    componentUrlAlias: './pages/qyjf_add_bankinfo.ctp',
    async: addBankInfoAsyncRoute
}, {
    path: '/investDoc',
    componentUrl: './pages/qyjf_invest_doc.ctp',
}, {
    path: '/wecharPay',
    componentUrl: './pages/qyjf_wechatpay.ctp',
}, {
    path: '/bankAcPay',
    componentUrl: './pages/qyjf_bankacpay.ctp',
}, {
    path: '/idConfirm',
    componentUrlAlias: './pages/qyjf_id_confirm.ctp',
    async: idConfirmAsyncRoute
}, {
    path: '/customService',
    componentUrl: './pages/qyjf_custom_service.ctp',
}, {
    path: '/publicService',
    componentUrl: './pages/qyjf_public_service.ctp',
}, {
    path: '/inviteCode',
    componentUrlAlias: './pages/qyjf_invite_code.ctp',
    async: inviteCodeAsyncRoute
}, {
    path: '/trade/:code',
    componentUrlAlias: './pages/qyjf_tab_trade_detail.ctp',
    async: tradeDetailAsyncRoute
}];


function tabIndexAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        userName: "",
        totalMarketValue: "--",
        hasLastLoginInfo: false,
        lastIp: "--",
        lastTime: '--',
        lastChannel: "--",
        photoSrc: '/img/qyjf/testphoto.png'
    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    $.when(fetchTotalMarketValue(), fetchAccountInfo(), fetchWechatPhoto())
        .done(function(data) {
            let userInfo = app.data.userInfo;
            let accountInfo = app.data.accountInfo;
            let loginInfo = app.data.loginInfo;
            let marketAccountInfo = app.data.marketAccountInfo;
            if (userInfo != null) {
                ctx['userName'] = userInfo['name'] || userInfo['nick'];
            }
            if (marketAccountInfo != null) {
                let total = marketAccountInfo['total'];
                ctx['totalMarketValue'] = accounting.formatMoney(total);
            }
            if (loginInfo != null && loginInfo.length > 0) {
                let lastLoign = loginInfo[0];
                ctx['hasLastLoginInfo'] = true;
                ctx['lastIp'] = lastLoign['ip'];
                let symbol = ctx['lastIp'].indexOf('&');
                if (symbol != -1) {
                    ctx['lastIp'] = ctx['lastIp'].substring(0, symbol);
                }
                ctx['lastTime'] = lastLoign['created'];
                ctx['lastChannel'] = lastLoign['msg'];
            }
            if (app.data.wechatPhoto != null) {
                ctx['photoSrc'] = app.data.wechatPhoto;
            }
        })
        .always(function() {
            resolve(routeInfo, customSpec);
            app.preloader.hide();
        })
}

function tabAccountAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        money: "--",
        hasBankCard: false,
        showIdCardFunc: true
    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    $.when(fetchBankInfo(), fetchAccountInfo())
        .done(function(data) {
            let accountInfo = app.data.accountInfo;
            let bankInfo = app.data.bankInfo;
            let userInfo = app.data.userInfo;
            if (accountInfo != null) {
                ctx['money'] = accounting.formatMoney(accountInfo['total']);
            }
            if (bankInfo != null && bankInfo.length > 0) {
                ctx['hasBankCard'] = true;
            }
            if (userInfo['status'] === "2") {
                ctx['showIdCardFunc'] = false;
            }
        })
        .always(function() {
            resolve(routeInfo, customSpec);
            app.preloader.hide();
        })
}

function tabTradeAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {
        isTradeTime: false,
        money: "--",
        quotationList: []
    };
    let routeInfo = { componentUrl: routeTo.route.tab.componentUrlAlias };
    let customSpec = {
        context: ctx
    }
    let fetchAry = [fetchAccountInfo()];
    if (app.data.quotationList == null) fetchAry.push(fetchQuotations());
    $.when.apply(null, fetchAry)
        .done(function(data) {
            let quotationList = app.data.quotationList;
            let accountInfo = app.data.accountInfo;
            if (quotationList != null) {
                ctx['quotationList'] = quotationList;
            }
            if (accountInfo != null) {
                ctx['money'] = accounting.formatMoney(accountInfo['total']);
            }
        })
        .always(function() {
            isServiceTime().then(function() {
                    ctx['isTradeTime'] = true;
                }, function() {
                    ctx['isTradeTime'] = false;
                })
                .always(function() {
                    resolve(routeInfo, customSpec);
                    app.preloader.hide();
                })
        })
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