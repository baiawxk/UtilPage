<!DOCTYPE html>
<!-- saved from url=(0053)http://framework7.taobao.org/examples/tab-bar/#view-2 -->
<html class="pixel-ratio-2 retina android android-6 android-6-0 watch-active-state">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <title>权盈金服</title>
  <!-- Path to Framework7 Library CSS-->
  <!-- <link rel="stylesheet" href="/css/qyjf/framework7.ios.min.css"> -->
  <!-- <link rel="stylesheet" href="/css/qyjf/framework7.ios.colors.min.css"> -->
  <link rel="stylesheet" href="/css/qyjf/framework7.min.css">
  <!-- Path to your custom app styles-->
  <link rel="stylesheet" href="/css/qyjf/my-app.css">
</head>

<body>
  <div id="app" class1="theme-white">
    <div class="panel panel-left panel-cover">
      <div class="view panel-view"></div>
    </div>
    <div class="views">
      <div class="login-screen">
        <div class="view view-init" data-url="/login">
        </div>
      </div>
      <div class="view view-main" data-name="main">
      </div>
    </div>
    <div class="popup">
      <div class="view popup-view"></div>
    </div>
  </div>
  <!-- Path to Framework7 Library JS-->
  <script type="text/javascript" src="/js/qyjf/framework7.min.js"></script>
  <script type="text/javascript" src="/js/qyjf/jquery.min.js"></script>
  <script type="text/javascript" src="/js/qyjf/lodash.min.js"></script>
  <script type="text/javascript" src="/js/qyjf/accounting.min.js"></script>
  <script type="text/javascript" src="/js/qyjf/qrcode.min.js"></script>
  <script type="text/javascript" src="/js/qyjf/common.js?v=14"></script>
  <script>
  // Initialize your app
  var app = new Framework7({
    root: '#app',
    theme: "ios",
    view: {
      iosDynamicNavbar: false,
    },
    routes: [{
        path: '/main',
        url: '/pages/get/qyjf_tab_page',
        tabs: [{
            path: '/tab1',
            id: 'tab1',
            componentUrlAlias: '/pages/get/qyjf_tab_index',
            async: tabIndexAsyncRoute
          },
          {
            path: '/tab2',
            id: 'tab2',
            componentUrlAlias: '/pages/get/qyjf_tab_trade',
            async: tabTradeAsyncRoute
          },
          {
            path: '/tab3',
            id: 'tab3',
            componentUrl: '/pages/get/qyjf_tab_stocks',
          },
          {
            path: '/tab4',
            id: 'tab4',
            componentUrlAlias: '/pages/get/qyjf_tab_account',
            async: tabAccountAsyncRoute
          }
        ],
      },
      {
        path: '/tabPage',
        redirect: '/main/tab1'
      },
      {
        path: '/tradeIndex',
        redirect: '/main/tab2'
      },
      {
        path: '/StockIndex',
        redirect: '/main/tab3'
      },
      {
        path: '/AccountIndex',
        redirect: '/main/tab4'
      },
      {
        path: '/checkLogin',
        componentUrl: '/pages/get/qyjf_check_login',
      },
      {
        path: '/login',
        componentUrl: '/pages/get/qyjf_login',
      },
      {
        path: '/recharge',
        componentUrlAlias: '/pages/get/qyjf_recharge',
        async: rechargeAsyncRoute
      },
      {
        path: '/reflect',
        componentUrlAlias: '/pages/get/qyjf_reflect',
        async: reflectAsyncRoute
      },
      {
        path: '/firstLogin',
        componentUrl: '/pages/get/qyjf_first_login',
      },
      {
        path: '/fistAddInfo',
        componentUrl: '/pages/get/qyjf_first_add_person_info',
      },
      {
        path: '/addBankInfo',
        componentUrlAlias: '/pages/get/qyjf_add_bankinfo',
        async: addBankInfoAsyncRoute
      },
      {
        path: '/investDoc',
        componentUrl: '/pages/get/qyjf_invest_doc',
      },
      {
        path: '/wecharPay',
        componentUrl: '/pages/get/qyjf_wechatpay',
      },
      {
        path: '/bankAcPay',
        componentUrl: '/pages/get/qyjf_bankacpay',
      },
      {
        path: '/idConfirm',
        componentUrlAlias: '/pages/get/qyjf_id_confirm',
        async: idConfirmAsyncRoute
      },
      {
        path: '/customService',
        componentUrl: '/pages/get/qyjf_custom_service',
      },
      {
        path: '/publicService',
        componentUrl: '/pages/get/qyjf_public_service',
      },
      {
        path: '/inviteCode',
        componentUrlAlias: '/pages/get/qyjf_invite_code',
        async: inviteCodeAsyncRoute
      },
      {
        path: '/trade/:code',
        componentUrlAlias: '/pages/get/qyjf_tab_trade_detail',
        async: tradeDetailAsyncRoute
      }
    ],
  });

  // Export selectors engine
  var $$ = Dom7;

  saveInviteCode();
  fixAosHeight();
  var mainView = app.views.create('.view-main');
  mainView.router.on('routerAjaxError',function() {
    qAlert('网络繁忙，请稍后重试');
  })
  isLogin()
    .then(needUpdateInfo)
    .then(function(data) {
      let status = data['status'];
      if (status === false) {
        mainView.router.navigate('/firstLogin');
      } else {
        mainView.router.navigate('/tabPage', { animate: false });
      }
    }, function() {
      app.loginScreen.open('.login-screen');
    })

  function saveInviteCode() {
    let query = app.utils.parseUrlQuery(location.href);
    let inviteCode = query['inviteCode'];
    if (inviteCode != null) {
      localStorage.setItem('inviteCode', inviteCode);
    }
  }

  function fixAosHeight() {
    let tempH = $(document.body).height();
    let tempW = $(document.body).width();
    let max, min = null;
    if (tempH > tempW) {
      max = tempH;
      min = tempW;
    } else {
      max = tempW;
      min = tempH;
    }
    $(window).on('resize', function() {
      let h = window.screen.height;
      let w = window.screen.width;
      if (h > w) {
        $(document.body).height(max);
      } else {
        $(document.body).height(min);
      }
    })
  }

  </script>
</body>

</html>
