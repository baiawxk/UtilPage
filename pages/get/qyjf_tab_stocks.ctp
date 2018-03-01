<template>
  <div data-page="index" class="page">
    <!-- /End of Top Navbar-->
    <div class="page-content">
      <div class="toolbar tabbar">
              <div class="toolbar-inner">
                <a href="#tab-1" class="tab-link tab-link-active">已下单</a>
                <a href="#tab-2" class="tab-link">持仓中</a>
			    <a href="#tab-3" class="tab-link">已结算</a>
              </div>
            </div>
		    <div class="tabs">
			  <div class="tab tab-active" id="tab-1">
				
		      </div>
			  
              <div class="tab" id="tab-2">

              </div>
			  
              <div class="tab" id="tab-3">

              </div>
		    </div>
    </div>
  </div>
</template>
<script>
return {
  methods: {
    initOrderInfo: function() {
      console.log('initOrderInfo');
      const self = this;
	  getOrderInfo().then(function(data) {
        let msg = data['msg'];
        if (msg != null) {
          msg = JSON.parse(msg);
        }
		var len = msg.length;
		//console.log(len);
		var stock;
		var stockName = '';
		var stockType1 = '';
		var stockType2 = "<table width='100%'>"
		+"<tr><th width='34%' class='begin'>标的名称</th>"
		+"<th width='33%' class='begin'>到期日</th>"
		//+"<th width='33%' class='begin'>认购金额</th>"
		+"<th width='33%' class='begin'>当前盈亏<br/>(元)</th>"
		//+"<th width='19%' class='begin'>当前盈亏<br/>(%)</th>"
		+"</tr>";
		var stockType3 = "<table width='100%'>"
		+"<tr><th width='34%' class='begin'>标的名称</th>"
		+"<th width='33%' class='begin'>结算日</th>"
		//+"<th width='18%' class='begin'>结算金额</th>"
		+"<th width='18%' class='begin'>实现盈亏<br/>(元)</th>"
		//+"<th width='19%' class='begin'>实现盈亏<br/>(%)</th>
		+"</tr>";;
		
		var curValueInPos = Number(0);
		var curValueClear = Number(0);
		
		var curProfitInPos = Number(0);
		var curProfitClear = Number(0);
		
		var totalCurProfitInPos = Number(0);
		var totalCurProfitClear = Number(0);
		
		var totalAmtInPos = Number(0);
		var totalAmtClear = Number(0);
		
		var today = new Date();
		
		for (var i = 0;i<len;i++){
			stock = msg[i];
			status = stock['status'];			
			if(status=='审核中'){
			//console.log('check review');
			stockType1 = stockType1+"<div class='card'>"		
			+"<div class='card-content'>"
			+"<table width='100%'>"
			+"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称"
			+"</td>"
			+"<td width='50%'>"
			+ stock['stock_name']
			+ "&nbsp;"
			+ stock['fund_code']
			+ "&nbsp;"
			+stock['op_type']
			+"</td><td><td width='20%' rowspan='7' style='text-align:center;vertical-align:middle;'>"
			+"<font size='3' color='red'>处理中</font></td></td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+"初始价格"
			+"</td><td>"
			+ (stock['op_type']=="申购"? "待确定":stock['fund_price'])
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+ "行权价"
			+"</td><td>"
			+ stock['right_price']
			+"%"
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
			+"<td>"
			+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
			+"</td></tr>"
			+(stock['op_type']=="申购"? "":"<tr><td><i class='icon stocks-icon-1'></i>申请卖出时间</td><td>"+stock['sell_time']+"</td></tr>")		
			+"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
			+ stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td></tr>"
			+"</tr><tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
			+ (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
			+"</td></tr>"
			+"<tr><td>"
			+"<i class='icon stocks-icon-1'></i>认购金额"
			+"</td><td>"
			+stock['buy_amount']
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"</div>";	
			}else if(status=='拒绝申购'&&new Date(Date.parse(stock['buy_check_time'].substring(0,stock['buy_check_time'].indexOf(" ")).replace(/-/g,"/")))<today){
			stockType1 = stockType1+"<div class='card'>"		
			+"<div class='card-content'>"
			+"<table width='100%'>"
			+"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称"
			+"</td>"
			+"<td width='50%'>"
			+ stock['stock_name']
			+ "&nbsp;"
			+ stock['fund_code']
			+ "&nbsp;"
			+stock['op_type']
			+"</td><td width='20%' rowspan='7' style='text-align:center;vertical-align:middle;'>"
			+"<font size='3' color='red'>拒绝申购</font></td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+"初始价格"
			+"</td><td>"
			+ (stock['op_type']=="申购"? "待确定":stock['fund_price'])
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+ "行权价"
			+"</td><td>"
			+ stock['right_price']
			+"%"
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
			+"<td>"
			+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
			+"</td></tr>"
			+(stock['op_type']=="申购"? "":"<tr><td><i class='icon stocks-icon-1'></i>申请卖出时间</td><td>"+stock['sell_time']+"</td></tr>")		
			+"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
			+ stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td></tr>"
			+"</tr><tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
			+ (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
			+"</td></tr>"
			+"<tr><td>"
			+"<i class='icon stocks-icon-1'></i>认购金额"
			+"</td><td>"
			+stock['buy_amount']
			+"</td></tr>"
			+"<tr><td colspan='3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;被拒绝申购的订单将于24小时后消失</td></tr>"
			+"</table>"
			+"</div>"
			+"</div>";	
			}
			
			else if(status=='通过'){
			curValueInPos = (Math.max(0,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
			curProfitInPos = (Math.max(-stock['quotation_price']/100,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
			- (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
			totalCurProfitInPos +=curProfitInPos;
			totalAmtInPos = totalAmtInPos+Number(stock['buy_amount']);
			
			
			
			stockType2 = stockType2
			+"<tr><td class='inter'>"
			+stock['stock_name']
			+"<i class='icon down-arrow'></i>"
			+"</td>"
			+"<td class='inter'>"
			+stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td>"
			//+"<td class='inter'>"
			//+stock['buy_amount']
			//+"</td>"
			+"<td class='inter'>"
			+ "<font color='"
			+(curProfitInPos>=0? "red":"green")
			+"'>"
			+curProfitInPos.toFixed(2)
			+"</font>"
			+"</td>"
		    //+"<td class='inter'>"
			//+ "<font color='"
			//+(curProfitInPos>=0? "red":"green")
			//+"'>"
			//+(curProfitInPos/stock['buy_amount']*100).toFixed(2)
			//+"%</font>"		
			//+"</td>"
			+"</tr>"
			+"<tr class='subcategory'><td colspan='5' width = '100%'>"
			+"<div class='card stock-card-footer'>"
			+"<div class='card-content'>"
			+"<table width='100%'>"
			+"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称</td>"
			+"<td width='70%'>"
			+ stock['stock_name']
			+ "&nbsp;"
			+ stock['fund_code']
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+"初始价格"
			+"</td><td>"
			+ stock['fund_price']
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+ "行权价"
			+"</td><td>"
			+ stock['right_price']
			+"%"
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
			+"<td>"
			+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
			+ stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
			+ (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
			+"</td></tr>"
			+"<tr><td>"
			+"<i class='icon stocks-icon-1'></i>认购金额"
			+"</td><td>"
			+stock['buy_amount']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>现市值</td>"
		    +"<td>"
			+curValueInPos
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>现股价</td>"
            +"<td>"
			+stock['buyOnePrice']
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"<div class='card-footer'><table width='100%'>"
			+"<tr><td width = '95%'>"
			+"当前盈亏: <font color='"
			+(curProfitInPos>=0? "red":"green")
			+"'>"
			+ (curProfitInPos/stock['buy_amount']*100).toFixed(2)
			+"%"
			+(curProfitInPos>=0? "↑":"↓")
			+"</font></td><td rowspan='2' style='text-align:right;vertical-align:middle;'>"
			+"<button class='button button-fill "
			//+"color-red"
			+(curProfitInPos>=0? "color-red":"color-green")
			+" open-confirm' style='color:white' onclick=\"confirmSell("
			+ stock['id']
			+")\">行权</button>"
		    +"</td></tr>"
		    +"<tr><td width = '95%'>"
		    +"股价变动: <font color='"
			+((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "red":"green")
			+"'>"
			+((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']*100).toFixed(2)
			+"% "
			+((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "↑":"↓")
			+"</font>"
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"</div>"
			+"</td></tr>";	
			}
			else if(status=='拒绝赎回'){
			curValueInPos = (Math.max(0,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
			curProfitInPos = (Math.max(-stock['quotation_price']/100,(stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
			- (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
			totalCurProfitInPos +=curProfitInPos;
			totalAmtInPos = totalAmtInPos+Number(stock['buy_amount']);
			
			
			
			stockType2 = stockType2
			+"<tr><td class='inter'>"
			+stock['stock_name']
			+"(赎回申请被拒绝)"
			+"<i class='icon down-arrow'></i>"
			+"</td>"
			+"<td class='inter'>"
			+stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			
			+"</td>"
			//+"<td class='inter'>"
			//+stock['buy_amount']
			//+"</td>"
			+"<td class='inter'>"
			+ "<font color='"
			+(curProfitInPos>=0? "red":"green")
			+"'>"
			+curProfitInPos.toFixed(2)
			+"</font>"
			+"</td>"
		    //+"<td class='inter'>"
			//+ "<font color='"
			//+(curProfitInPos>=0? "red":"green")
			//+"'>"
			//+(curProfitInPos/stock['buy_amount']*100).toFixed(2)
			//+"%</font>"		
			//+"</td>"
			+"</tr>"
			+"<tr class='subcategory'><td colspan='5' width = '100%'>"
			+"<div class='card stock-card-footer'>"
			+"<div class='card-content'>"
			+"<table width='100%'>"
			+"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称</td>"
			+"<td width='70%'>"
			+ stock['stock_name']
			+ "&nbsp;"
			+ stock['fund_code']
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+"初始价格"
			+"</td><td>"
			+ stock['fund_price']
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>"
			+ "行权价"
			+"</td><td>"
			+ stock['right_price']
			+"%"
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
			+"<td>"
			+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
			+ stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
			+ (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
			+"</td></tr>"
			+"<tr><td>"
			+"<i class='icon stocks-icon-1'></i>认购金额"
			+"</td><td>"
			+stock['buy_amount']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>现市值</td>"
		    +"<td>"
			+curValueInPos
			+"</td></tr><tr><td><i class='icon stocks-icon-1'></i>现股价</td>"
            +"<td>"
			+stock['buyOnePrice']
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"<div class='card-footer'><table width='100%'>"
			+"<tr><td width = '95%'>"
			+"当前盈亏: <font color='"
			+(curProfitInPos>=0? "red":"green")
			+"'>"
			+ (curProfitInPos/stock['buy_amount']*100).toFixed(2)
			+"%"
			+(curProfitInPos>=0? "↑":"↓")
			+"</font></td><td rowspan='2' style='text-align:right;vertical-align:middle;'>"
			+"<button class='button button-fill "
			//+"color-red"
			+(curProfitInPos>=0? "color-red":"color-green")
			+" open-confirm' style='color:white' onclick=\"confirmSell("
			+ stock['id']
			+")\">行权</button>"
		    +"</td></tr>"
		    +"<tr><td width = '95%'>"
		    +"股价变动: <font color='"
			+((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "red":"green")
			+"'>"
			+((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']*100).toFixed(2)
			+"% "
			+((stock['buyOnePrice']-stock['fund_price'])/stock['fund_price']>0? "↑":"↓")
			+"</font>"
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"</div>"
			+"</td></tr>";	
			}
			
			
			
			else if(status=='结算'){
			curValueClear = (Math.max(0,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
			curProfitClear = (Math.max(-stock['quotation_price']/100,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
			- (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
			totalCurProfitClear +=curProfitClear;;
			totalAmtClear = totalAmtClear+Number(stock['buy_amount']);
			
			
			var currentMkValue = (Math.max(0,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-(stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100)).toFixed(2);
			var totalProfit = (Math.max(-stock['quotation_price']/100,(stock['fund_price2']-stock['fund_price'])/stock['fund_price']-stock['quotation_price']/100
			- (stock['right_price']/100-100/100))* (stock['buy_amount']/stock['quotation_price']*100));
			var stockDiff = (stock['fund_price2']-stock['fund_price'])/stock['fund_price'];
			stockType3 = stockType3
			+"<tr><td class='inter'>"
			+stock['stock_name']
			+"&nbsp;"
			+"<i class='icon down-arrow'></i>"
			+"</td>"
			+"<td class='inter'>"
			+stock['sell_time'].substring(0,stock['sell_time'].indexOf(" "))
			+"</td>"
			/*+"<td class='inter'>"
			+stock['buy_amount']
			+"</td>"*/
			+"<td class='inter'>"
			+ "<font color='"
			+(curProfitClear>=0? "red":"green")
			+"'>"
			+curProfitClear.toFixed(2)
			+"</font>"
			+"</td>"
		    /*+"<td class='inter'>"
			+ "<font color='"
			+(curProfitClear>=0? "red":"green")
			+"'>"
			+(curProfitClear/stock['buy_amount']*100).toFixed(2)
			+"%</font>"		
			+"</td>*/
			+"</tr>"
			+"<tr class='subcategory'><td colspan='5' width = '100%'>"
			
			
			+"<div class='card'>"
			+"<div class='card-content'>"
			+"<table width='100%'>"
			+"<tr><td width='30%'><i class='icon stocks-icon-1'></i>标的名称</td><td width='70%'>"
			+ stock['stock_name']
			+ "&nbsp;"
			+ stock['fund_code']
			+"</td></tr><tr><td>"
			+"<i class='icon stocks-icon-1'></i>初始价格"
			+"</td><td>"
			+ stock['fund_price']
			+"</td></tr><tr><td>"
			+ "<i class='icon stocks-icon-1'></i>行权价"
			+"</td><td>"
			+ "100%"
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>买入日期</td>"
			+"<td>"
			+stock['buy_time'].substring(0,stock['buy_time'].indexOf(" "))
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>到期日</td><td>"
			+ stock['deadline'].substring(0,stock['deadline'].indexOf(" "))
			+"</td></tr>"
			+"</tr><tr><td><i class='icon stocks-icon-1'></i>名义本金</td><td>"
			+ (stock['buy_amount']/stock['quotation_price']*100).toFixed(2)
			+"</td></tr>"
			+"<tr><td>"
			+"</tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>认购金额"
			+"</td><td>"
			+stock['buy_amount']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>结算时间</td>"
			+"<td>"
			+stock['sell_time']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>结算价格</td>"
			+"<td>"
			+ stock['fund_price2']
			+"</td></tr>"
			+"<tr><td><i class='icon stocks-icon-1'></i>结算市值</td>"
			+"<td>"
			+currentMkValue
			+"</td></tr>"
			+"</table>"
			+"</div>"
			+"<div class='card-footer'><table width='100%'>"
			+"<tr><td width = '70%'>"
			+"结算盈亏: <font color='"
			+(totalProfit>0? "red":"green")
			+"'>"
			+((totalProfit/stock['buy_amount'])*100).toFixed(2)
			+"%"
			+(totalProfit>0? "↑":"↓")
			+"</font></td><td width = '30%' rowspan='2' style='text-align:right;vertical-align:middle;'>"
			+"交易号<br/>"
			+stock['id']
			//+ 10000
		    +"</td></tr>"
		    +"<tr><td>"
		    +"结算股价变动: <font color='"
			+ (stockDiff>=0?"red":"green")
			+"'>"
			+ (stockDiff*100).toFixed(2)
			+"% "
			+(stockDiff>=0?"↑":"↓")
			+"</font>"
			+"</table>"
			+"</div>"
			+"</div>"
			+"</td></tr>";;	
			
			
			
			}
			
		}
		
		stockType2 = stockType2
		+"<tr><td class='inter' colspan = '2'>"
		+"总盈亏"
		+"</td>"
		//+"<td class='inter'>"
		//+Number(totalAmtInPos)
		//+"</td>"
		+"<td class='inter'>"
		//+totalCurProfitInPos
		+ "<font color='"
		+(totalCurProfitInPos>=0? "red":"green")
		+"'>"
		+totalCurProfitInPos.toFixed(2)
		+"</font>"
		+"</td>"
		/*+"<td class='inter'>"
		+ "<font color='"
		+((totalCurProfitInPos/totalAmtInPos)>=0? "red":"green")
		+"'>"
		+((totalCurProfitInPos/totalAmtInPos)*100).toFixed(2)
		+"%</font>"
		+"</td>"*/
		+"</tr>"
		+"<tr><td colspan='5'>"
		+"<font size='2'><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***点击个股名称或相应持仓记录可查阅详细记录"
		+"</font>"
		+"</td></tr>"
		+"</table>";
		
		stockType3 = stockType3
		+"<tr><td class='inter' colspan = '2'>"
		+"总盈亏"
		+"</td>"
		/*+"<td class='inter'>"
		+Number(totalAmtClear)
		+"</td>"*/
		+"<td class='inter'>"
		+ "<font color='"
		+(totalCurProfitClear>=0? "red":"green")
		+"'>"
		+totalCurProfitClear.toFixed(2)
		+"</font>"
		+"</td>"
		/*+"<td class='inter'>"
		+ "<font color='"
		+((totalCurProfitClear/totalAmtClear)>=0? "red":"green")
		+"'>"
		+((totalCurProfitClear/totalAmtClear)*100).toFixed(2)
		+"%</font>"
		+"</td>"*/
		+"</tr>"
		+"<tr><td colspan='5'>"
		+"<font size='2'><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;***点击个股名称或相应持仓记录可查阅详细记录"
		+"</font>"
		+"</td></tr>"
		+"</table>";
		
		$("#tab-1").append(stockType1);
	    $("#tab-2").append(stockType2);
		$("#tab-3").append(stockType3);
		
		$('tr:not(.subcategory)').click(function(){
		$(this).nextUntil('tr:not(.subcategory)').toggle()
		});
      }, function(error) {
        console.log('fali', error);
      })
	  console.log("end of");
    },
  },
  on: {
    tabInit: function() {
    	// setActiveTabLink(2);
       console.log('stocks');
	   
	   this.initOrderInfo();

    }
  }
}

</script>
