accounting.settings.currency.symbol = '￥';
Template7.registerHelper('formatMoney', accounting.formatMoney);

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

function isLogin() {
    return getJSON(`${_apiHost}/users/need_tel`).then(function(data) {
        var d = $.Deferred();
        if (data == null) d.reject();
        else {
            if (data && data['status'] == false) {
                d.resolve(data);
            } else {
                d.reject(data);
            }
        }
        return d.promise();
    }, function(error) {
        var d = $.Deferred();
        d.reject({ status: false, "msg": "系统繁忙，请稍后重试" });
        return d.promise();
    })
}

function getLoginTimes() {
    var url = `${_apiHost}/users/get_login_times`;
    return getJSON(url);
}

function needUpdateInfo() {
    var url = `${_apiHost}/users/need_update_info`;
    return getJSON(url);
}

function getOrderInfo() {
    var url = `${_apiHost}/users/get_trading_list`;
    return getJSON(url);
}

function sellStock(id) {
    var url = `${_apiHost}/users/sell_fund/${id}`;
    return getJSON(url);
}

function confirmSell(id) {
    console.log("test" + this.router);
    app.dialog.confirm(
        "请确认行权信息", '权盈金服',

        function() {

            self.sellStock(id).then(function(data) {
                if (data != null) {
                    let status = data['status'];
                    let msg = data['msg'];
                    if (status === true) {
                        qAlert('您的行权申请已经提交');
                        //window.location.href = 'new url'; //for external link
                        //window.open(''); // the same as target=_blank
                        console.log(mainView.router);
                        mainView.router.navigate('/tabPage'); // to load internal page
                    } else {
                        qAlert(msg);
                    }
                } else {
                    qAlert('您的行权申请已经提交');
                }
            }, function(data) {
                qAlert('您的行权申请已经提交');
            })
        });
}

function sendSMS(phoneNo) {
    var url = `${_apiHost}/users/send_sms_code/${phoneNo}`;
    return getJSON(url).then(function(data) {
        var d = $.Deferred();
        if (data == null) d.reject();
        else {
            if (data && data['status'] == true) {
                d.resolve(data);
            } else {
                d.reject(data);
            }
        }
        return d.promise();
    }, function(error) {
        console.error('sendSMS', 'error', error);
    })
}

function addCapital(value, remark) {
    var url = `${_apiHost}/users/add_capital/${value}/${remark}`;
    return getJSON(url).then(function(data) {
        var d = $.Deferred();
        if (data == null) d.reject();
        else {
            if (data && data['status'] == true) {
                d.resolve(data);
            } else {
                d.reject(data);
            }
        }
        return d.promise();
    }, function(error) {
        console.error('addCapital', 'error', error);
    })
}

function validSMS(phonePin) {
    var url = `${_apiHost}/users/check_tel/${phonePin}`;
    return getJSON(url).then(function(data) {
        var d = $.Deferred();
        if (data == null) d.reject();
        else {
            if (data && data['status'] == true) {
                d.resolve(data);
            } else {
                d.reject(data);
            }
        }
        return d.promise();
    }, function(error) {
        console.error('validSMS', 'error', error);
    })
}

function getPersonInfo() {
    var url = `${_apiHost}/users/amount_info`;
    return getJSON(url);
}

function parseAPIJSONStr(data) {
    var obj = {};
    if (typeof data === "string") {
        try {
            obj = $.parseJSON(data);
        } catch (e) {
            obj = {};
        }
    } else {
        obj = data;
    }
    return obj;
}

function getBankInfo() {
    var url = `${_apiHost}/users/get_bank_info`;
    return getJSON(url);
}

function qAlert(msg) {
    return app.dialog.alert(msg, _appTitle);
}

function qConfirm(msg1, msg2) {
    return app.dialog.confirm(msg1, _appTitle, function() {
        app.dialog.alert(msg2, _appTitle);
    });
}

function getPayRecord() {
    return getPersonInfo().then(function(data) {
        var d = $.Deferred();
        let msg = data['msg'];
        if (msg != null) {
            msg = JSON.parse(msg);
        }
        let amount_list = msg['amount_list'];
        if (amount_list == null || amount_list.length == 0) {
            d.reject();
        } else {
            d.resolve(amount_list);
        }
        return d.promise();
    });
}

function getRechargeRec() {
    return getPayRecord().then(function(data) {
        let d = $.Deferred();
        if (data != null && data.length > 0) {
            let newData = $.grep(data, function(v, i) {
                let amount = v['amount'];
                let status = v['status']
                switch (status) {
                    case "undone":
                        v['status'] = '待确认';
                        break;
                    case "done":
                        v['status'] = '充值成功';
                        break;
                    default:
                        break;
                }
                return parseInt(amount, 10) > 0;
            });
            d.resolve(newData);
        } else {
            d.reject();
        }
        return d.promise();
    });
}

function getReflectRec() {
    return getPayRecord().then(function(data) {
        let d = $.Deferred();
        if (data != null && data.length > 0) {
            let newData = $.grep(data, function(v, i) {
                let amount = v['amount'];
                let status = v['status'];
                amount = parseInt(amount, 10);
                v['amount'] = v['amount'].replace('-', '');
                switch (status) {
                    case "undone":
                        v['status'] = '待确认';
                        break;
                    case "done":
                        v['status'] = '已确认';
                        break;
                    default:
                        break;
                }
                return amount < 0;
            });
            d.resolve(newData);
        } else {
            d.reject();
        }
        return d.promise();
    });
}

function tabIndexAsyncRoute(routeTo, routeFrom, resolve, reject) {
    var router = this;
    var app = router.app;
    app.preloader.show();
    let ctx = {};
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
    let ctx = {};
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

function stockQuote(code) {
    let url = `${_apiHost}/app/get_detail_by_code/${code}`;
    return getJSON(url);
}

function fetchInviteCode() {
    let d = $.Deferred();
    getInviteCode().then(function(data) {
            let msg = data['msg'];
            if (msg != null) {
                app.data.inviteCode = data['msg'];
            }
        })
        .always(d.resolve)
    return d.promise();
}

function getInviteCode() {
    let url = `${_apiHost}/users/get_inv_code`;
    return getJSON(url);
}

function setActiveTabLink(index) {
    let _index = index || 0;
    $('.view-main .main-tab-link')
        .removeClass('tab-link-active')
        .eq(_index)
        .addClass('tab-link-active');
}

function fetchAccountInfo() {
    return getPersonInfo().then(function(data) {
        let d = $.Deferred();
        let msg = data['msg'];
        try {
            if (msg != null) {
                msg = JSON.parse(msg);
                app.data.userInfo = msg['user_info'];
                app.data.loginInfo = msg['logs'];
                app.data.accountInfo = msg['amount'];
                let amountList = msg['amount_list'];
                if (amountList != null && amountList.length > 0) {
                    amountList = amountList.reverse();
                    let amountList1 = _.cloneDeep(amountList);
                    let amountList2 = _.cloneDeep(amountList);
                    app.data.reflectList = $.grep(amountList1, function(v, i) {
                        let amount = v['amount'];
                        let status = v['status'];
                        amount = parseInt(amount, 10);
                        if (amount < 0) {
                            v['amount'] = v['amount'].replace('-', '');
                            switch (status) {
                                case "undone":
                                    v['statusLabel'] = '待确认';
                                    break;
                                case "done":
                                    v['statusLabel'] = '提现成功';
                                    break;
                                case "reject":
                                    v['statusLabel'] = '提现失败';
                                    break;
                                default:
                                    v['statusLabel'] = v['status'];
                                    break;
                            }
                        }
                        if (v['remark'] == null) {
                            v['remark'] = '----';
                        }
                        return amount < 0;
                    });
                    app.data.rechargeList = $.grep(amountList2, function(v, i) {
                        let amount = v['amount'];
                        let status = v['status'];
                        amount = parseInt(amount, 10);
                        if (amount > 0) {
                            switch (status) {
                                case "undone":
                                    v['statusLabel'] = '待确认';
                                    break;
                                case "done":
                                    v['statusLabel'] = '充值成功';
                                    break;
                                case "reject":
                                    v['statusLabel'] = '充值失败';
                                    break;
                                default:
                                    v['statusLabel'] = v['status'];
                                    break;
                            }
                        }
                        if (v['remark'] == null) {
                            v['remark'] = '----';
                        }
                        return amount > 0;
                    });
                }
            }
        } catch (e) {
            console.error('===fetchAccountInfo===', e);
        } finally {
            d.resolve();
        }
        return d.promise();
    }, function(error) {
        console.error('fali', error);
    })
}

function fetchBankInfo() {
    let d = $.Deferred();
    getBankInfo().then(function(data) {
            let msg = data['msg'];
            if (msg != null) {
                app.data.bankInfo = data['msg'];
            }
        })
        .always(d.resolve)
    return d.promise();
}

function fetchTotalMarketValue() {
    let d = $.Deferred();
    getJSON(`${_apiHost}/users/get_total_market_value`).then(function(data) {
            let msg = data['msg'];
            if (msg != null) {
                app.data.marketAccountInfo = msg;
            }
        })
        .always(d.resolve)
    return d.promise();
}

function fetchQuotations() {
    let d = $.Deferred();
    getJSON(`${_apiHost}/users/get_quotations`).then(function(data) {
            let msg = data['msg'];
            if (msg != null) {
                app.data.quotationList = data['msg'];
            }
        })
        .always(d.resolve)
    return d.promise();
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

function loadingWrap(promise) {
    if (promise && promise.then) {
        app.preloader.show();
        promise.always(function() {
            app.preloader.hide();
        })
    }
    return promise;
}

function fetchWechatPhoto() {
    let d = $.Deferred();
    if (app.data.wechatPhoto != null) {
        d.resolve();
    } else {
        getJSON(`${_apiHost}/users/get_wechat_photo`).then(function(data) {
                let status = data['status'];
                if (status === true) {
                    let msg = data['msg'];
                    if (msg != null) {
                        app.data.wechatPhoto = data['msg'];
                    }
                }

            })
            .always(d.resolve)
    }
    return d.promise();
}

function isServiceTime() {
    let url = `${_apiHost}/users/trading_time`;
    return getJSON(url).then(function(data) {
        let d = $.Deferred();
        if (data != null && data['status'] === true) {
            let msg = data['msg'];
            if (msg === true) {
                d.resolve();
            } else {
                d.reject();
            }
        } else {
            d.reject();
        }
        return d.promise();
    })
}