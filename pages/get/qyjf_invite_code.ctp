<template>
  <div class="page" data-name="invest_doc">
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
    <div class="page-content">
      <div class="block block-strong inset">
        <p>我的邀请码为{{inviteCode}}</p>
        <div class="text-align-center">
          <div id="qrCode" data-url="{{inviteLink}}">
          </div>
        </div>
      </div>
      <div class="block">
        <p>请扫描以上二维码或者复制以下网址</p>
        <p>{{inviteLink}}</p>
      </div>
    </div>
  </div>
</template>
<script>
return {
  on: {
    pageInit: function() {
      let self = this;
      let url = $("#qrCode").data('url');
      let width = $("#qrCode").width();
      new QRCode($("#qrCode").get(0), {
        text:url,
        width:width,
        height:width
      });

    }
  }
}

</script>
