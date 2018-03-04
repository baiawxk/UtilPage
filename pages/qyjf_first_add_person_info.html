<template>
  <div class="page no-toolbar " data-name="first_login">
    <div class="page-content">
      <div class="block">
         <div class="text-align-left">
          请补全以下信息: 
         </div>
      </div>
      <div class="list">
        <ul>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">姓名</div>
              <div class="item-input-wrap">
                <input type="text" name="name" id="name" placeholder="">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">电子邮件</div>
              <div class="item-input-wrap">
                <input type="email" name="email" id="email" placeholder="">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
          <li class="item-content item-input">
            <div class="item-inner">
              <div class="item-title item-label">邀请码</div>
              <div class="item-input-wrap">
                <input type="number" name="inviteCode" id="inviteCode" placeholder="">
                <span class="input-clear-button"></span>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="block">
        <div class="row">
          <button class="col button" @click="reset">重设</button>
          <button class="col button button-fill" @click="confirm">确认</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    reset: function() {
      const self = this;
      self.$el.find('#name').val('');
      self.$el.find('#email').val('');
    },
    confirm: function() {
      let self = this;
      let name = self.$el.find('#name').val();
      let email = self.$el.find('#email').val();
      if ($.trim(name) === "") {
        qAlert('请输入姓名');
        return;
      }
      if ($.trim(email) === "") {
        qAlert('请输入邮箱');
        return;
      }
      self.saveInfo()
        .done(function() {
          qAlert('资料更新成功').on('close', function() {
            mainView.router.navigate('/publicService');
          })
        })
        .fail(function(data) {
          let msg = data['msg'];
          qAlert(msg);
        })
    },
    saveInfo: function() {
      let d = $.Deferred();
      const self = this;
      let name = self.$el.find('#name').val();
      let email = self.$el.find('#email').val();
      let inviteCode = self.$el.find('#inviteCode').val();

      self.saveInviteCode(inviteCode)
        .then(function() {
          return self.saveName(name);
        })
        .then(function() {
          return self.saveEmail(email);
        })
        .then(d.resolve, d.reject);
      return d.promise();
    },
    rejectHandle:function(data) {
      let d = $.Deferred();
      let status = data['status'];
      if(status===false)
      {
        d.reject(data);
      }
      else
      {
        d.resolve(data);
      }
      return d.promise();
    },
    saveInviteCode: function(inviteCode) {
      let self = this;
      if (inviteCode != null && $.trim(inviteCode)!=="") {
        let url = `${_apiHost}/users/save_inv_code/${inviteCode}`;
        return getJSON(url).then(self.rejectHandle)
      } else {
        var d = $.Deferred();
        d.resolve();
        return d.promise();
      }
    },
    saveName: function(name) {
      let self = this;
      let url = `${_apiHost}/users/save_name/${name}`
      return getJSON(url).then(self.rejectHandle)
    },
    saveEmail: function(email) {
      let self = this;
      let url = `${_apiHost}/users/save_email/${email}`;
      return getJSON(url).then(self.rejectHandle)
    },
    checkIfHasInviteCode: function() {
      let self = this;
      let el = self.$el;
      let inviteCode = localStorage.getItem('inviteCode');
      if (inviteCode != null) {
        let inviteCodeInput = el.find('#inviteCode');
        inviteCodeInput.val(inviteCode);
      }
    }
  },
  on: {
    pageInit: function() {
      let self = this;
      self.checkIfHasInviteCode();
    }
  }
}

</script>
