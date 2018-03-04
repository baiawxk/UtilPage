<template>
  <div data-page="index" class="page">
    <div class="page-content">
      <div class="list inset">
        <ul>
          <li><a href="/recharge" class="list-button item-link">充值</a></li>
          <li><a href="/reflect" class="list-button item-link">提现</a></li>
          <li><a href="/customService" class="list-button item-link">联系客服</a></li>
          <li><a href="/inviteCode" class="list-button item-link">我的邀请码</a></li>
          {{#if showIdCardFunc}}
          <li><a href="/idConfirm" class="list-button item-link">实名认证</a></li>
          {{/if}}
          <li><a href="/addBankInfo" class="list-button item-link">添加/编辑银行卡</a></li>
        </ul>
      </div>
      <div class="block">
        <div class="text-align-center">
          当前可用余额：{{money}}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    updateMoney: function() {
      const self = this;
      const el = self.$el;
      getPersonInfo().then(function(data) {
        let msg = data['msg'];
        if (msg != null) {
          msg = JSON.parse(msg);
        }
        let amount = msg['amount'];
        let name = "";
        if (amount != null) {
          let total = amount['total'];
          el.find('#money').text(total);
        }
      }, function(error) {
        console.log('fali', error);
      })
    }
  },
  on: {
    pageInit: function() {
      // setActiveTabLink(3);
      // this.updateMoney();
    }
  }
}

</script>
