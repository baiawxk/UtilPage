<template>
  <div class="page">
    <!-- page-content has additional login-screen content -->
    <div class="page-content">
      <div class="navbar">
        <div class="navbar-inner sliding">
          <div class="left">
            <a href="#" class="link back">
              <i class="icon icon-back"></i>
              <span class="ios-only">返回</span>
            </a>
          </div>
        </div>
      </div>
      <div class="list">
        <ul>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">充值金额</div>
              <div class="item-input-wrap">
                <input type="number" name="money" id="money" placeholder="">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="list inset1">
        <ul>
          <li>
            <a href="#" class="item-link list-button" @click="wechatRecharge">二维码转账(10000元以下)</a>
          </li>
          <li>
            <a href="#" class="item-link list-button" @click="bankAcRecharge">银行账户转账</a>
          </li>
        </ul>
      </div>
      <div class="block">
        <p>充值步骤：</p>
        <ol>
          <li>输入金额，提交充值申请(请尽量转非整数金额，如1000.43)</li>
          <li>工作日9:00 - 17:30内，系统将于1个小时内确认</li>
          <li>非工作日时间，系统将于随后一个工作日早上10:00前确认</li>
        </ol>
      </div>
      {{#if hasRechargeRec}}
      <div class="block-title">
        充值记录
      </div>
      <div class="data-table card">
        <table id="recharge_rec">
          <thead>
            <tr>
              <th class="text-align-center">申请金额</th>
              <th class="text-align-center">申请时间</th>
              <th class="text-align-center">状态</th>
              <th class="text-align-center">备注</th>
            </tr>
          </thead>
          <tbody>
            {{#each rechargeRec}}
            <tr>
              <td class="text-align-center">{{formatMoney amount}}</td>
              <td class="text-align-center">{{created}}</td>
              <td class="text-align-center">{{statusLabel}}</td>
              <td class="text-align-center">{{remark}}</td>
            </tr>
            {{/each}}
          </tbody>
        </table>
      </div>
      {{/if}}
    </div>
  </div>
  <style scoped>
  #recharge_rec td {
    padding: 2px;
  }

  </style>
</template>
<script>
return {
  methods: {
    wechatRecharge: function() {
      this.recharge(1);
    },
    bankAcRecharge: function() {
      this.recharge(2);
    },
    recharge: function(type) {
      const self = this;
      let money = self.$el.find('#money').val();
      let num = parseInt(money, 10);
      if ($.trim(money) === "") {
        qAlert('请输入充值金额');
        return;
      }
      if (num <= 0) {
        qAlert('请输入合法的数值');
        return;
      } else {
        addCapital(num,type==1?'二维码':'银行卡').then(function(data) {
          var status = data['status'];
          var msg = data['msg'];
          if (status === true) {
            fetchAccountInfo();
            if (type == 1) {
              qAlert('充值申请成功。工作日9:00 - 17:30内，系统将于1个小时内确认,非工作日时间，系统将于随后一个工作日早上10:00前确认。即将转至微信转账版面。').on('close', function() {
                mainView.router.navigate('/wecharPay');
              })
            } else {
              qAlert('充值申请成功。工作日9:00 - 17:30内，系统将于1个小时内确认,非工作日时间，系统将于随后一个工作日早上10:00前确认。即将转至银行转账版面。').on('close', function() {
                mainView.router.navigate('/bankAcPay');
              })
            }

          } else
            qAlert('充值申请失败:' + msg);
        }, function(data) {
          var status = data['status'];
          var msg = data['msg'];
          qAlert('充值申请失败');
        })
      }
    },
    initRechargeRec: function() {
      // getRechargeRec()
    }
  },
  on: {
    pageInit: function() {
      // this.initRechargeRec();
    }
  }
}

</script>
