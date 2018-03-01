<template>
  <div data-page="tradeDetail" class="page">
    <div class="navbar">
      <div class="navbar-inner">
        <div class="left">
        </div>
        <div class="title sliding"><img src="/img/qyjf/brucezhao10000qyjf02.png" height="29" width="102"></div>
        <div class="right">
        </div>
      </div>
    </div>
    <div class="page-content">
      <div class="card data-table">
        <table>
          <thead>
            <tr>
              <th class="label-cell">选择</th>
              <!-- <th class="label-cell">股票名称</th> -->
              <th class="numeric-cell">行权价</th>
              <th class="numeric-cell">期限</th>
              <th class="numeric-cell">期权费率</th>
            </tr>
          </thead>
          <tbody>
            {{#each detailAry}}
            <tr>
              <td class="label-cell">
                <label class="item-radio item-content">
                  <input type="radio" name="stockIdRadio" {{#if @first}}checked{{/if}} />
                  <i class="icon icon-radio" @click=switchStock({{id}}) data-id="{{id}}"></i>
                </label>
              </td>
              <!-- <td class="label-cell">{{name}}({{code}})</td> -->
              <td class="numeric-cell">{{right_price}}%</td>
              <td class="numeric-cell">{{last_time}}</td>
              <td class="numeric-cell">{{price}}%</td>
            </tr>
            {{/each}}
          </tbody>
        </table>
      </div>
      <div class="block">
        <div id="price-filter" class="range-slider color-green" data-label="true" data-min="500" data-max="50000" data-step="500"></div>
      </div>
      <div class="block">
        <div class="list">
          <ul>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">认购金额</div>
                <div class="item-input-wrap">
                  <input type="number" name="inputMoney" id="inputMoney" @keyup=inputMoneyHandle>
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="block">
        <div class="row">
          <div class1="col-50">
            股票名称: &nbsp <strong><span>{{currentStock.name}} ({{currentStock.code}})</span></strong>
          </div>
        </div>
        <div class="row">
          <div class1="col-50">
            股票价格: &nbsp <strong><span>{{formatMoney price}}</span></strong>
          </div>
        </div>
        <!-- <div class="row">
          <div class1="col-50">
            可用余额: &nbsp <strong><span>{{formatMoney money}}</span></strong>
          </div>
        </div> -->
        <!-- <div class="row">
          <div class1="col-50">
            认购金额: &nbsp <strong><span class="price-value">--</span></strong>
          </div>
        </div> -->
        <div class="row">
          <div class1="col-50">
            名义本金: &nbsp <strong><span class="book-value">--</span></strong>
          </div>
        </div>
        <div class="row">
          <div class1="col-50">
            成交方式：
            <input type="radio" name="ordertype" checked="checked"> 市价成交
          </div>
        </div>
        <div class="row">
          <div class1="col-50">
            期权类型：
            <input type="radio" name="optiontype" checked="checked"> 美式期权
          </div>
        </div>
      </div>
      <div class="block">
        <div class="row">
          <a href="#" class="col button button-fill" @click="confirm_order"> 认购</a>
          <a class="col button popup-open1" @click=showCalc href="#" data-popup1=".popup-about">收益测算</a>
        </div>
        <div class="popup popup-about">
          <div class="block">
            <p><a class="link popup-close" href="#">返回</a></p>
            <h4>收益测算</h4>
            <div class="row">
              <div class1="col-50">
                购买金额: &nbsp <strong><span class="price-value">$500</span></strong>
                <br>
              </div>
            </div>
            <div class="card data-table" id="ratetable">
            </div>
          </div>
        </div>
      </div>
      <div class="block">
        <div class="col-sm-3"></div>
        <div class="col-sm-3"><a class="link popover-open" href="#" data-popover=".popover-about">实例说明和交易须知</a></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="popover popover-about">
          <div class="popover-inner">
            <div class="block">
              <p>实例说明和交易须知</p>
              <p>如平安银行期权费为3%，投资者于周日认购10万名义本金并投资3000元作为期权费（3%乘以100000），行权价为100%，期限为一周，星期一首个交易日开盘价为10元。如周五收盘平安银行收盘价为12元（即涨幅20%），投资者回报为100000*20% - 3000 = 17000元，相当于本金翻了6.7倍；如周五平安银行收盘价为8元（即跌幅20%），投资者最大亏损为3000元期权费投入。
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="block">
        <div class="text-align-center">
          当前可用余额：{{formatMoney money}}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    showCalc: function() {
      let self = this;
      let el = self.$el;
      let t = self.updateCalcTemplate();
      el.find('#ratetable').html(t);
      app.popup.open(".popup-about");
    },
    updateCalcTemplate: function() {
      let self = this;
      let calcAry = [-0.1, 0, 0.025, 0.05, 0.075, 0.1, 0.15, 0.2, 0.25, 0.3];
      let code = self.code;
      let detail = self.currentStock;
      let buyFee = detail['price'];
      let currentMoney = self.buy;
      let normalMoney = currentMoney / (buyFee * 0.01);
      let trTemplate = "";
      for (let i = 0; i < calcAry.length; i++) {
        let pValue = calcAry[i];
        let pValueLabel = (pValue * 100) + "%";
        let pay1 = -currentMoney;
        let pay2 = normalMoney * pValue - currentMoney;
        let finalPay = Math.max(pay1, pay2);
        let finalPayPercent = finalPay / currentMoney * 100
        let finalPayLabel = accounting.formatMoney(finalPay);
        let finalPayPercentLabel = accounting.formatNumber(finalPayPercent, 2) + "%";
        trTemplate += `
        <tr>
          <td class="label-cell">${pValueLabel}</td>
          <td class="numeric-cell">${finalPayLabel}</td>
          <td class="numeric-cell">${finalPayPercentLabel}</td>
        </tr>
        `;
      }
      let template = `
    <table>
      <thead>
        <tr>
          <th class="label-cell">到期日涨跌幅</th>
          <th class="numeric-cell">盈亏</th>
          <th class="numeric-cell">盈亏%</th>
        </tr>
      </thead>
      <tbody>
        ${trTemplate}
      </tbody>
    </table>
      `;
      return template;
    },
    getExpandValue: function(buy) {
      let self = this;
      let stock = self.currentStock;
      let buyFee = stock.price;
      buy = parseFloat(buy);
      buyFee = parseFloat(buyFee);
      let expandValue = buy / (buyFee * 0.01);
      return expandValue;
    },
    update: function() {
      let self = this;
      let el = self.$el;
      let buyEl = el.find('.price-value');
      let expandEl = el.find('.book-value');
      buyEl.text(accounting.formatMoney(self.buy))
      expandEl.text(accounting.formatMoney(self.expandValue));
    },
    switchStock: function(id) {
      console.log(id);
      let self = this;
      let detailAry = self.detailAry;
      for (let i = 0; i < detailAry.length; i++) {
        let detail = detailAry[i];
        let dId = detail.id;
        if (dId == id) {
          self.currentStock = detail;
          break;
        }
      }
      self.init();
    },
    init: function() {
      let self = this;
      let stock = self.currentStock;
      let step = stock.step;
      self.buy = step;
      self.expandValue = self.getExpandValue(self.buy);
      self.slider.min = step;
      self.slider.step = step;
      self.slider.setValue(step);
      self.update();
    },
    changeBuy: function(value) {
      let self = this;
      value = parseFloat(value);
      if (value > 50000) value = 50000;
      let stock = self.currentStock;
      self.buy = value;
      self.expandValue = self.getExpandValue(self.buy);
      self.update();
    },
    inputMoneyHandle: function(e) {
      let self = this;
      let input = $(e.target);
      let value = input.val();
      if (value > 50000) {
        value = 50000;
      } else if (value < 500) {
        value = 500;
      }
      self.changeBuy(value);
    },
    isServiceTime: function() {
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
    },
    buyStock: function(code, num, id) {
      if (arguments.length != 3) return;
      return this.invokeBuyStock(code, num, id);
    },
    invokeBuyStock: function(code, num, id) {
      let url = `${_apiHost}/users/buy_fund/${code}/${num}/${id}`;
      return getJSON(url);
    },
    confirm_order: function() {
      let self = this;
      let stock = self.currentStock;
      let confirmMsg1 = '';
      let confirmMsg2 = '';
      let buyPrice = '---';
      let buy = self.buy || "500";
      let expandValue = self.expandValue || "500";
      let buyFmt = accounting.formatMoney(buy);
      let expandValueFmt = accounting.formatMoney(expandValue);
      loadingWrap(self.isServiceTime())
        .then(function() {
          confirmMsg1 = '股票收益型互换交易确认书1（待提供）我已阅读并同意以上条款';
          confirmMsg2 = '请确认以下认购信息:<br>';
        }, function() {
          confirmMsg1 = '股票收益型互换交易确认书2（待提供）我已阅读并同意以上条款';
          confirmMsg2 = '请确认以下预约认购信息:<br>';
        })
        .always(function() {
          loadingWrap(stockQuote(self.code))
            .done(function(data) {
              if (data != null) {
                let status = data['status'];
                let msg = JSON.parse(data['msg']);
                if (status === true) {
                  buyPrice = msg['buyOnePri'];
                  let buyPriceFmt = accounting.formatMoney(buyPrice);
                  app.dialog.confirm(confirmMsg1, '权盈金服', function() {
                    app.dialog.confirm(
                      `${confirmMsg2}
                  标的代码: ${stock.name} (${stock.code}) <br> 
                  到期日: ${stock.deadline} <br> 
                  认购金额:${buyFmt} <br> 
                  名义本金:${expandValueFmt}<br>
                   期权费: ${stock.price}% <br>
                   参考买入价 ${buyPriceFmt} <br>
                   参考行权价:${stock.right_price}% <br>
                   <br>注：具体价格以成交价为准`, '权盈金服',
                      function() {
                        self.buyStock(stock.code, buy, stock.id).then(function(data) {
                          if (data != null) {
                            let status = data['status'];
                            let msg = data['msg'];
                            if (status === true) {
                              qAlert('您的订单已提交');
                            } else {
                              qAlert(msg);
                            }
                          } else {
                            qAlert('下单失败');
                          }
                        }, function(data) {
                          qAlert('下单失败');
                        })
                      });
                  });
                }
              }
            })
            .fail(function(data) {
              let msg = data['msg'] || '系统繁忙，请稍后重试';
              qAlert('msg');
            })
        })
    },
  },
  on: {
    pageInit: function() {
      let self = this;
      let el = self.$el;
      console.log(self, self.buy);
      self.slider = app.range.create({
        el: "#price-filter",
        on: {
          change: function(t, value) {
            self.changeBuy(value);
            el.find("#inputMoney").val(value);
          }
        }
      });
      self.init();
    }
  }
}

</script>
