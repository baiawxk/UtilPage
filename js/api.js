let _apiHost = '2132';
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