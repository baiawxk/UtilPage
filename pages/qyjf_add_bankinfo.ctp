<template>
  <div class="page no-toolbar1 no-navbar" data-name="addBankInfo">
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
      <div class="block">
        <div class="text-align-left">
          当前可用余额：{{money}}
        </div>
      </div>
      <form id="addBankInfoForm" action="/users/save_bank_info" method="POST">
        <div class="list">
          <ul>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">开户姓名</div>
                <div class="item-input-wrap">
                  {{#if hasBankAccountName}}
                  <input type="text" class="disabled" value="{{name}}" name="name" id="name" placeholder="">
                  {{else}}
                  <input type="text" name="name" id="name" placeholder="">
                  <span class="input-clear-button"></span>
                  {{/if}}
                </div>
              </div>
            </li>
           <!--  <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">身份证</div>
                <div class="item-input-wrap">
                  {{#if hasIdCard}}
                  <input type="text" class="disabled" name="name" value="{{idCard}}" id="name" placeholder="">
                  {{else}}
                  <input type="text" name="name" id="name" placeholder="">
                  <span class="input-clear-button"></span>
                  {{/if}}
                </div>
              </div>
            </li> -->
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">银行名称</div>
                <div class="item-input-wrap">
                  <input type="text" name="bankName" value1="{{bankCard.bank_name}}" id="bankName" placeholder="" >
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">支行名称</div>
                <div class="item-input-wrap">
                  <input type="text" name="branchName" value1="{{bankCard.sub_bank}}" id="branchName" placeholder="" >
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">银行卡号</div>
                <div class="item-input-wrap">
                  <input type="text" name="bankNo" value1="{{bankCard.num}}" id="bankNo" placeholder="" >
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="list">
          <ul>
            <li>
              <a href="#" class="item-link list-button" @click="confirm">确认修改并提交</a>
            </li>
          </ul>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    confirm: function() {
      const self = this;
      let name = self.$el.find('#name').val();
      let bankName = self.$el.find('#bankName').val();
      let branchName = self.$el.find('#branchName').val();
      let bankNo = self.$el.find('#bankNo').val();
      if ($.trim(name) === "") {
        qAlert('请输入开户姓名');
        return;
      }
      if ($.trim(bankName) === "") {
        qAlert('请输入银行名称');
        return;
      }
      if ($.trim(branchName) === "") {
        qAlert('请输入支行名称');
        return;
      }
      if ($.trim(bankNo) === "") {
        qAlert('请输入银行卡号');
        return;
      }
      var param = {};
      param['name'] = name;
      param['bank_name'] = bankName;
      param['sub_bank'] = branchName;
      param['num'] = bankNo;
      postJSON(`${_apiHost}/users/save_bank_info`, param).then(function(data) {
        let status = data['status'];
        let msg = data['msg'];
        if (status === true) {
          qAlert('添加成功').on('close', function() {
            mainView.router.navigate('/AccountIndex');
          })
        } else {
          qAlert(msg);
        }
      }, function(data) {
        let msg = data['msg'];
        qAlert(msg);
        console.error('addBankInfo fail', arguments);
      })
    },
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
      // this.updateMoney();
    }
  }
}

</script>
