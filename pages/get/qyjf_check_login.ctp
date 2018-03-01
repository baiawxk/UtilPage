<template>
    <div class="page" data-name="check_login">
    <div class="page-content">
    </div>
  </div>
</template>
<script>
return {
  on: {
    pageInit: function() {
        isLogin().then(function() {
          mainView.router.navigate('/tabPage');
        },function() {
          // mainView.router.navigate('/tabPage');
          mainView.router.navigate('/login');
        })
    }
  }
}

</script>
