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
              <div class="item-title item-label">提现金额</div>
              <div class="item-input-wrap">
                <input type="number" name="money" id="money" placeholder="">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">当前银行卡</div>
              <div class="item-input-wrap">
                <p>{{bankCard.num}}</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="block">
        <p>提现步骤：</p>
        <ol>
          <li>输入金额，提交提现申请</li>
          <li>工作日9:00 - 17:30内，系统将于1个小时内确认</li>
          <li>非工作日时间，系统将于随后一个工作日早上10:00前确认</li>
		  <li>入金后若无交易直接提现，将收取5%的手续费</li>
      <li>确认后，金额会于3个工作日内转回您指定的银行卡</li>
        </ol>
      </div>
      <div class="list">
        <ul>
          <li>
            <a href="#" class="item-link list-button" @click="reflect">申请提现</a>
          </li>
        </ul>
      </div>
      {{#if hasRechargeRec}}
      <div class="block-title">
        提现记录
      </div>
      <div class="data-table card">
        <table id="reflect_rec">
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
    #reflect_rec td{
      padding: 2px;
    }
  </style>
</template>
<script>
return {
  methods: {
    reflect: function() {
      const self = this;
      let money = self.$el.find('#money').val();
      let num = parseInt(money, 10);
      if ($.trim(money) === "") {
        qAlert('请输入提现金额');
        return;
      }
      if (num <= 0) {
        qAlert('请输入合法的数值');
        return;
      } else {
        addCapital(-num,'----').then(function(data) {
          var status = data['status'];
          var msg = data['msg'];
          if (status === true) {
            fetchAccountInfo();
            qAlert('申请提现成功').on('close', function() {
              mainView.router.navigate('/AccountIndex');
            })
          } else
            qAlert('申请提现失败:' + msg);
        }, function(data) {
          var status = data['status'];
          var msg = data['msg'];
          qAlert('申请提现失败:' + msg);
        })
      }
    }
  },
  on: {
    pageInit: function() {
      // getBankInfo().then(function() {
      //   console.log('getBankInfo success', arguments);
      // }, function() {
      //   console.log('getBankInfo fail', arguments);
      // })
    }
  }
}

</script>
