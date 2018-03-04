<template>
  <div class="page" data-name="tabPage">
    <div class="tabs-swipeable-wrap">
      <div class="tabs">
        <div class="page-content tab tab-active" id="page1">
          <!-- <div class="navbar">
            <div class="navbar-inner">
              <div class="center title">账户</div>
            </div>
          </div> -->
          <div class="block">
            <div class="text-align-left">
              您好，<span id="userName">--</span>
            </div>

<div class="block">
<img src="https://www.w3schools.com/images/w3schools_green.jpg" alt="W3Schools.com">
</div>

          </div>
          <div class="block block-strong inset" style="background-color: #FFD966;color:black;">
            <br>
            <br>
            <div class="text-align-center">
              参考总市值：<span id="totalBal">--</span>
            </div>
            <br>
            <br>
          </div>
          <div class="block">
            <div class="list">
              <ul>
                <li>
                  <div class="item-content">
                    <div class="item-media"><i class="icon icon-f7"></i></div>
                    <div class="item-inner">
                      <div class="item-title">我的账户</div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="item-content">
                    <div class="item-media"><i class="icon icon-f7"></i></div>
                    <div class="item-inner">
                      <div class="item-title">交易记录</div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="item-content">
                    <div class="item-media"><i class="icon icon-f7"></i></div>
                    <div class="item-inner">
                      <div class="item-title">订单</div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <div class="block text-align-center" id="lastLogin">
          </div>
        </div>
        <div class="page-content tab" id="page2">
          <div class="navbar">
            <div class="navbar-inner">
              <div class="center title">交易</div>
            </div>
          </div>
          <div style="width: 100%;height: 100%;">

<!--Trade  Daniel-->
<!--Trade  Daniel-->

            <!--<iframe src="http://tools.fintgroup.com/" frameborder="0" width="100%" height="100%"></iframe>-->






            <div class="block">
                <div class="searchbar-backdrop"></div>
                <form class="searchbar">
                  <div class="searchbar-inner">
                    <div class="searchbar-input-wrap">
                      <input type="search" placeholder="如0001.SZ，平安银行">
                      <i class="searchbar-icon"></i>
                      <span class="input-clear-button"></span>
                    </div>
                    <span class="searchbar-disable-button">Cancel</span>
                  </div>
                </form>
              </div>




             <div class="card data-table">

                <table>

                  <thead>
                    <tr>
                      <th class="label-cell">股票名称</th>
                      <th class="numeric-cell">行权价</th>
                      <th class="numeric-cell">期限</th>
                      <th class="numeric-cell">期权类型</th>
                      <th class="numeric-cell">有效期</th>
                    </tr>
                  </thead>


                  <tbody>
                    <tr>
                      <td class="label-cell">浦发银行（600000）</td>
                      <td class="numeric-cell">100%</td>
                      <td class="numeric-cell">1周</td>
                      <td class="numeric-cell">认购</td>
                      <td class="numeric-cell">2018-06-01</td>
                    </tr>


                  </tbody>
                </table>
            </div>

  <div> <br>
  </div>  



  <!-- purchase scroll bar-->
  <!-- purchase scroll bar-->

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.slidecontainer {
    width: 100%;
}

.slider {
    -webkit-appearance: none;
    width: 100%;
    height: 15px;
    border-radius: 5px;
    background: #FFFFFF;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
}

.slider:hover {
    opacity: 1;
}

.slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #FFFFFF;
    cursor: pointer;
}

.slider::-moz-range-thumb {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #FFFFFF;
    cursor: pointer;
}
</style>
</head>

<body>


 <div class="block">

<div class="block-title">购买金额:</div>
<div class="list simple-list">
  <ul>
    <li>
 
      <div class="item-cell flex-shrink-3">
        <!-- range slider, enable labels -->
        <div class="range-slider range-slider-init color-orange" data-label="true">
          <input type="range" min="500" max="50000" step="100" value="500">
        </div>
      </div>
    
    </li>
  </ul>
</div>


</div>


</body>
</html>



  <!-- purchase scroll bar end-->
  <!-- purchase scroll bar end-->


           <div class="block">

                  <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"><a href="#"  class="col button button-fill" @click="confirmterms"> &nbsp &nbsp 购买 &nbsp &nbsp </a></div>
                    <div class="col-sm-3"><a href="#"  class="col button button-fill" @click="login2"> 收益计算</a></div>

                    <div class="col-sm-3"> </div>
                  </div>
          </div>



          <div class="block">

                    <div class="col-sm-3"></div>
                    
                    <div class="col-sm-3"><a class="link popover-open" href="#" data-popover=".popover-about">实例说明及交易须知</a></div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3"></div>


    <div class="popover popover-about">
    <div class="popover-inner">
      <div class="block">
        <p>实例说明及交易须知</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ac diam ac quam euismod porta vel a nunc. Quisque sodales scelerisque est, at porta justo cursus ac.</p>
      </div>
    </div>
  </div>
  
          </div>



 <div class="card data-table" style="display: none;" id="ratetable">

            <table>

                <thead>
                  <tr>
                    <th class="label-cell">到期日涨跌幅</th>
                    <th class="numeric-cell">盈亏</th>
                    <th class="numeric-cell">盈亏%</th>
                  
                  </tr>
                </thead>


                <tbody>
                  <tr>
                    <td class="label-cell">-10%</td>
                    <td class="numeric-cell">-500</td>
                    <td class="numeric-cell">-100%</td>

                  </tr>
                  <tr>
                    <td class="label-cell">+10%</td>
                    <td class="numeric-cell">750</td>
                    <td class="numeric-cell">+150%</td>
                 
                  </tr>
     
                </tbody>
              </table>

 </div>



<!--Trade  Daniel-->
<!--Trade  Daniel-->





          </div>
        </div>
        <div class="page-content tab" id="page3">
          <div class="navbar">
            <div class="navbar-inner">
              <div class="center title">持仓</div>
            </div>
          </div>
          <div style="width: 100%;height: 100%;">
			<div class="toolbar tabbar">
              <div class="toolbar-inner">
                <a href="#tab-1" class="tab-link tab-link-active">已下单</a>
                <a href="#tab-2" class="tab-link">持仓中</a>
			    <a href="#tab-3" class="tab-link">已结算</a>
              </div>
            </div>
		    <div class="tabs">
			  <div class="tab tab-active" id="tab-1">
				<div class="card">
				  <div class="card-content">
					<table>
					  <tr>
					    <td>标的名称</td>
						<td>权盈金服</td>
				      </tr>
					  <tr>
					    <td>行权价</td>
						<td>100%</td>
				      </tr>
					  <tr>
					    <td>到期日</td>
						<td>2018-03-01</td>
				      </tr>
					  <tr>
					    <td>金额</td>
						<td>1500</td>
				      </tr>
                    </table>
				  </div>
				</div>
				
			    <div class="card">
				  <div class="card-content">
				    <table>
					  <tr>
					    <td>标的名称</td>
						<td>深发展</td>
				      </tr>
					  <tr>
					    <td>行权价</td>
						<td>100%</td>
				      </tr>
					  <tr>
					    <td>到期日</td>
						<td>2018-03-01</td>
				      </tr>
					  <tr>
					    <td>金额</td>
						<td>2000</td>
				      </tr>
                    </table>
				  </div>
				 </div>
		      </div>
              <div class="tab" id="tab-2">
                <div class="card">
				  <div class="card-content">
					<table>
					  <tr>
					    <td>标的名称</td>
						<td>权盈金服</td>
				      </tr>
					  <tr>
					    <td>行权价</td>
						<td>100%</td>
				      </tr>
					  <tr>
					    <td>到期日</td>
						<td>2018-01-01</td>
				      </tr>
					  <tr>
					    <td>金额</td>
						<td>500</td>
				      </tr>
                    </table>
				  </div>
				  <div class="card-footer"><p style="color:red;">+666.01</p><p>平仓</p></div>
				</div>
				
			    <div class="card">
				  <div class="card-content">
				    <table>
					  <tr>
					    <td>标的名称</td>
						<td>深发展</td>
				      </tr>
					  <tr>
					    <td>行权价</td>
						<td>100%</td>
				      </tr>
					  <tr>
					    <td>到期日</td>
						<td>2018-03-01</td>
				      </tr>
					  <tr>
					    <td>金额</td>
						<td>2000</td>
				      </tr>
                    </table>
				  </div>
				  <div class="card-footer"><p style="color:green;">-466.01</p><p>平仓</p></div>
				 </div>
              </div>
              <div class="tab" id="tab-3">
                <div class="card">
				  <div class="card-content">
					<table>
					  <tr>
					    <td>标的名称</td>
						<td>权盈金服</td>
				      </tr>
					  <tr>
					    <td>行权价</td>
						<td>100%</td>
				      </tr>
					  <tr>
					    <td>到期日</td>
						<td>2018-01-01</td>
				      </tr>
					  <tr>
					    <td>金额</td>
						<td>500</td>
				      </tr>
                    </table>
				  </div>
				  <div class="card-footer"><p style="color:red;">+666.01</p><p>交易号10002</p></div>
				</div>
				
			    <div class="card">
				  <div class="card-content">
				    <table>
					  <tr>
					    <td>标的名称</td>
						<td>深发展</td>
				      </tr>
					  <tr>
					    <td>行权价</td>
						<td>100%</td>
				      </tr>
					  <tr>
					    <td>到期日</td>
						<td>2018-03-01</td>
				      </tr>
					  <tr>
					    <td>金额</td>
						<td>2000</td>
				      </tr>
                    </table>
				  </div>
				  <div class="card-footer"><p style="color:green;">-466.01</p><p>交易号10001</p></div>
				 </div>
              </div>
		    </div>
		  </div>
        </div>
      </div>
    </div>
    <div class="toolbar tabbar tabbar-labels">
      <div class="toolbar-inner">
        <a href="#page1" class="tab-link tab-link-active"> <i class="icon tabbar-demo-icon-3"></i><span class="tabbar-label">个人</span></a>
        <a href="#page2" class="tab-link"> <i class="icon tabbar-demo-icon-1"></i><span class="tabbar-label">交易</span></a>
        <a href="#page3" class="tab-link"> <i class="icon tabbar-demo-icon-2"></i><span class="tabbar-label">持仓</span></a>
        <a href="#page4" class="tab-link"> <i class="icon tabbar-demo-icon-4"></i><span class="tabbar-label">账户</span></a>
      </div>
    </div>
  </div>
</template>






<script>


return {
  methods: {confirmterms:function() {
 
        qAlert("请确认");
        return ;
      
    },
    initPersonInfo: function() {
      console.log('initPersonInfo');
      const self = this;
      getPersonInfo().then(function(data) {
        let msg = data['msg'];
        if (msg != null) {
          msg = JSON.parse(msg);
        }
        let amount = msg['amount'];
        let name = "";
        if (amount != null) {

        }
        let user_info = msg['user_info'];
        if (user_info != null) {
          name = user_info['name'];
          if (name != null) {
            self.$el.find('#userName').text(name);
          }
        }
        return;
        const logs = data['logs'];
        let lastStr = "";
        self.$el.find('#totalBal').text(count_a);
        if (logs != null && logs.length > 0) {
          const last = logs[0];
          lastStr = `最近登陆：${last.ip} ${last.msg}`;
        }
        self.$el.find('#lastLogin').text(lastStr);
        console.log('done', name, user, count_a, logs, lastStr);
      }, function(error) {
        console.log('fali', error);
      })
    }
  },
  on: {
    pageInit: function() {
      console.log('tabPage');
      this.initPersonInfo();
    }
  }
}

</script>








