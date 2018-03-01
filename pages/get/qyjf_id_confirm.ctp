<template>
  <div class="page" data-name="idConfirm">
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
      <form id="addBankInfoForm" action="/users/save_bank_info" method="POST">
        <div class="list">
          <ul>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">姓名</div>
                <div class="item-input-wrap">
                  <input type="text" name="name" id="name" value="" placeholder="">
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
            <li class="item-content item-input">
              <div class="item-inner">
                <div class="item-title item-label">身份证</div>
                <div class="item-input-wrap">
                  <input type="text" name="idCard" id="idCard" placeholder="">
                  <span class="input-clear-button"></span>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="list">
          <ul>
            <li>
              <a href="#" class="item-link list-button" @click="confirm">确认提交审核</a>
            </li>
          </ul>
        </div>
        <div class="block">
          <p>备注：</p>
          <ol>
            <li>为确保您的个人权益，请提供与您银行信息一致的真实姓名</li>
            <li>工作日9:00 - 17:30内，系统将于1个小时内确认</li>
            <li>非工作日时间，系统将于随后一个工作日早上10:00前确认</li>
          </ol>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    invokeSavePersonIdInfo: function(name, id) {
      let url = `${_apiHost}/users/save_personal_code/${id}/${name}`;
      return getJSON(url);
    },
    idConfirm: function(name, id) {
      return this.invokeSavePersonIdInfo(name, id);
    },
    confirm: function() {
      const self = this;
      let name = self.$el.find('#name').val();
      let idCard = self.$el.find('#idCard').val();
      if ($.trim(name) === "") {
        qAlert('请输入姓名');
        return;
      }
      if ($.trim(idCard) === "") {
        qAlert('请输入身份证');
        return;
      }
      this.idConfirm(name, idCard).then(function(data) {
        let status = data['status'];
        let msg = data['msg'];
        if (status === true) {
          qAlert('实名认证申请已经提交。工作日9:00 - 17:30内，系统将于1个小时内确认,非工作日时间，系统将于随后一个工作日早上10:00前确认。').on('close', function() {
            fetchAccountInfo().always(function() {
              mainView.router.navigate('/AccountIndex');
            })
          })
        } else {
          qAlert(msg);
        }
      }, function(data) {
        let msg = data['msg'];
        qAlert(msg);
        console.log('addBankInfo fail', arguments);
      })
    }
  },
  on: {
    pageInit: function() {}
  }
}

</script>
