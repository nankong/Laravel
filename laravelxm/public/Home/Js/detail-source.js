/**
 * 商品操作
 * Last Update:2012-12-28
 */
ec.pkg("ec.product");
ec.load("ajax");
ec.load("ec.box" , {loadType : "lazy"});
ec.load("cloud-zoom" , function(){
	setTimeout(function () {$("#product-img").CloudZoom();}, 200);
});

 

ec.load("jquery.fixed",function () {
	$(function () {
		$("#pro-tab-all").fixed();
	}); 
});
	

ec.product.prefix = "/product";
ec.remark = {};
ec.remark.prefix = domainRemark + "/remark";

(function(){
	var _preSku = null,
		_skuMap = {},
		//SKU属性显示方式  1图片,2文本
		_skuShowType = {},
		//SKU ID与属性名的映射关系
		//_skuAttrNameMap = {},
		//SKU属性ID与SKU的映射关系
		_skuAttrId2SkuMap = {},
		//SKU属性名ID
		_skuAttrTypeID = [],
		//SKU属性名
		_skuAttrName = [],
		//SKU属性值
		_skuAttrVallue = {},
		//SKU属性值对应的id
		_skuAttrType2ValueIds = {} ,
		//选中的SKU属性
		_selectAttrMap = {},
		_timer,
		_proGallerysMouseOver = function(){
			var thix = $(this);

			thix.parent().parent().addClass("current").siblings().removeClass("current");

			clearTimeout(_timer);
			_timer = setTimeout(function(){
				var img = thix.attr("src");

				$("#product-img").attr("href" , img.replace("55_55" , "800_800")).find("img").attr("src" , img.replace("55_55" , "428_428"));

				//重新设置放大镜
				$("#product-img").CloudZoom();
			},150);
		},
		_updateSelect  = function () {
			
			var selectPara="您选择了<b>";
			$("#pro-skus").find('.selected').each(function(){    
						selectPara+=$(this).children().children("a").attr("title")+"/";
						});			
			//获取用户选中的延保商品名称
			var temp1=new String($("#extendProtected:has('.selected')>div.sku").text());
			//获取用户选中的意外保商品名称
			var temp2=new String($("#accidentProtected:has('.selected')>div.sku").text());

			var ist1=temp1.indexOf("¥");
			var ist2=temp2.indexOf("¥");
			if(ist1>0){
				temp1=temp1.substr(0,ist1);
				selectPara+=temp1+"/";	
			}
			if(ist2>0){
				temp2=temp2.substr(0,ist2);
				selectPara+=temp2+"/";	
			}
			
			selectPara=selectPara.substring(0,selectPara.length-1) ;
			
			selectPara+="</b>"; 
			$("#pro-select-sku").html(selectPara);
				
			};
		//更新当前SKU的页面的信息
		_updateSkuInfo = function(){
			
			var sku = ec.product.getSku(),
				skuPromWord;
			
			if(!sku || _preSku == sku)return;
			ec.product.setSkuId = _preSku = sku;
		
			sku = _skuMap[sku];
			
			ec.product.setType(sku.type);
			//价格
			if (sku.priceMode != 2){sku.price = parseFloat(sku.price).toFixed(2);}
			
			//如果两个价格相等 则显示华为价和现价 否则只有 华为价
			if(parseInt(sku.originPrice)!=parseInt(sku.price)&&(sku.priceMode != 2)){
				$("#pro-price-old").html('<label>华&nbsp;为&nbsp;&nbsp;价：</label>&yen;&nbsp;'+sku.originPrice);
				$("#pro-price-old").show();
				if(sku.price > 0)
					$("#pro-price").html('<label>现&nbsp;价：</label><b>&yen;&nbsp;'+  sku.price + '</b>');		
			}
			else {				
				$("#pro-price-old").hide();	
				if(sku.price > 0)
					$("#pro-price").html('<label>华&nbsp;为&nbsp;&nbsp;价：</label><b>&yen;&nbsp;'+  sku.price + '</b>');
			}
			//价格显示方式，1：正常显示；2：暂不报价
			if(sku.priceMode == 2||sku.price <= 0)
			{
				$("#pro-price").html('<label>华&nbsp;为&nbsp;&nbsp;价：</label><b>暂无报价</b>');
			} 
			
			
			//广告语
			if ($.trim(sku.skuPromWord).length > 0) {
				if($.trim(sku.skuPromWordLink).length > 0) {
					skuPromWord = '<a href="'+sku.skuPromWordLink+'" target="_blank">'+sku.skuPromWord+'</a>';
				}
				$("#skuPromWord").html((skuPromWord || sku.skuPromWord));
				$('#pro-slogan-area').show();
			} else {
				$('#pro-slogan-area').hide();
			}
			
		 

			//商品编码
			$("#pro-sku-code").html(sku.code);

			//渲染标题
			$("#pro-name").html(sku.name);
			$("#bread-pro-name").html(sku.name);

			//渲染库存区域
			ec.product.execute("renderInventory" , [ec.product.inventory.haveInventory(sku.id)]);

			//套图 start
			$("#product-img").attr("href" , ec.mediaPath + sku.photoPath+"800_800_"+sku.photoName).find("img")
				.attr("src" ,ec.mediaPath + sku.photoPath+"428_428_"+sku.photoName);
			//重新设置放大镜
			$("#product-img").CloudZoom();

			var html = [];
			html.push('<li class="current"><a href="javascript:;"><img src="'+ec.mediaPath+sku.photoPath+'55_55_'+sku.photoName+'"/></a></li>');
			if(sku.imgName)
			{
				for(var i = 0 ; i < sku.imgName.length ; i ++)
				{
					html.push('<li><a href="javascript:;"><img src="'+ec.mediaPath+sku.photoPath+'/group/55_55_'+sku.imgName[i]+'"/></a></li>');
				}
				ec.product.imgSlider.reset();
			}
			//套图 end
			
			 
			

			html = $(html.join(""));
			html.find("img").mouseover(_proGallerysMouseOver);
			$("#pro-gallerys").empty().html(html);

			
			//此处促销信息,团购信息和赠品信息合并 显示逻辑修改 chenzhongxian
			//促销消息
			html = [];
			var bShowPromotions=false;
			if(!sku.promotionLst || sku.promotionLst.length == 0)
			{
				$("#pro-promotions-list").html("");
				$("#pro-promotions-list").hide();
			}else{
				for(var i = 0 ; i < sku.promotionLst.length ; i ++)
				{
					html.push('<li>'+sku.promotionLst[i].ruleDescription+'</li>');
				}
				$("#pro-promotions-list").html(html.join(""));
				bShowPromotions=true;
				$("#pro-promotions-list").show();
			}
			//团购信息
			if(sku.groupType == '2')
			{
				bShowPromotions=true;
				html.push('<li id="promotionGroupTips">本商品有其他团购优惠活动，<a href="/group/detail-' + sku.groupId + '" title="去看看" target="_blank">去看看</a></li>');
				$("#pro-promotions-list").html(html.join(""));
				$("#pro-promotions-list").show();
			}			
			//赠品
			html = [];
			if(!sku.giftList || sku.giftList.length == 0)
			{
				$("#pro-gift-list").html("");
				$("#pro-gift-list").hide();
			}else{
				for(var i = 0 ; i < sku.giftList.length ; i ++)
				{
					html.push('<li><span>赠送&nbsp</span> <a  href="/product/'+sku.giftList[i].giftId+'.html#'+sku.giftList[i].giftSkuId+'" target="_blank">'+sku.giftList[i].giftName+'</a></li>');
				}
				$("#pro-gift-list").html(html.join(""));
				$("#pro-gift-list").show();
				bShowPromotions=true;
			}
			if(bShowPromotions)
				$("#pro-promotions-area").show();
			else 
				$("#pro-promotions-area").hide();
			
			
			
			//如果本主商品绑定了 服务商品（延保，意外保）
			if(sku.prolongLst.length > 0){
				var lst;	
				html = [];
				//定义延保服务的名字数组
				var  ExtendedProtectName=[];
				//定义延保服务的Id数组
				var ExtendedProtectId=[];
				//定义延保服务的个数
				var ExtendedProtectNum=0;
				//定义意外保的名字数组
				var  accidentProtectName=[];
				//定义意外保的Id数组
				var  accidentProtectId=[];
				//定义意外保的个数
				var accidentProtectsNum=0;
				//定义页面中延保商品选项长度
				var entendOptionSize=0;
				//定义页面中意外保商品选项长度
				var accidentOptionSize=0;
				//var accidentOptionWidth=$("#accidentProtected").find("div:eq(0)").css("width");
				
				for(var i=0; i< sku.prolongLst.length; i+=1){
					lst = sku.prolongLst[i];
					//如果该商品绑定了延保服务
					if(lst.serviceType==1){
						ExtendedProtectName[ExtendedProtectNum]=lst.name;
						ExtendedProtectId[ExtendedProtectNum]=lst.id;
						ExtendedProtectNum+=1;
					}
					//如果该商品绑定了意外保服务
					if(lst.serviceType==2){
						accidentProtectName[accidentProtectsNum]=lst.name;
						accidentProtectId[accidentProtectsNum]=lst.id;
						accidentProtectsNum+=1;
					}
				}	
				//删除延保服务文本框高选样式
				$("#extendProtected").removeClass("selected");
				//删除意外保服务文本框高选样式
				$("#accidentProtected").removeClass("selected");
				//清空延保商品下拉列表
				$("#extendProtected").find("ul").empty();
				//清空意外保商品下拉列表
				$("#accidentProtected").find("ul").empty();
				
				//如果延保服务个数大于0
				if(ExtendedProtectNum>0){
					//显示延保商品模块
					$("#extendProtected").show();
					//将延保服务的文本框内容设置为第一个延保商品名称
					$("#extendProtected>div.sku>a").html(ExtendedProtectName[0]);
					var ExtendedOption="";
					for(var i=0;i<ExtendedProtectNum;i++){
						//定义延保选项内容
						ExtendedOption=$('<li><div class="sku" title="'+ExtendedProtectId[i]+'" ><a href="javascript:;" title="延保服务" >'+ExtendedProtectName[i]+'</a></div></li>');
						//将延保选项内容加到下拉列表中
						ExtendedOption.appendTo($("#extendProtected").find("ul"));
						//获取延保名字的最大长度
						if(ExtendedProtectName[i].length>entendOptionSize){
							entendOptionSize=ExtendedProtectName[i].length;
						}
					}
					//设置所有延保选项的宽度
					if(entendOptionSize>0){
						//设置延保选项文本框的宽度
						$("#extendProtected").find("div:eq(0)").css("width",((entendOptionSize-6)*12+64)+"px");
						//设置延保下拉选项宽度
						$("#extendProtected>ul").find("div").attr("style","width:"+((entendOptionSize-6)*12+64)+"px");
					}
				}else{
					//隐藏延保服务商品模块
					$("#extendProtected").hide();
				}
				//如果意外保服务个数大于0
                if(accidentProtectsNum>0){
                	
                	//显示意外保商品模块
                	$("#accidentProtected").show();
                	//将意外保服务的文本框内容设置为第一个意外保商品名称
                	$("#accidentProtected>div.sku>a").html(accidentProtectName[0]);
                	var accidentOption="";
					for(var i=0;i<accidentProtectsNum;i++){
						//定义意外保选项内容
						accidentOption=$('<li><div class="sku"  title="'+accidentProtectId[i]+'"><a href="javascript:;" title="意外保服务" >'+accidentProtectName[i]+'</a></div></li>');
						//将意外保选项内容加到下拉列表中
						accidentOption.appendTo($("#accidentProtected").find("ul"));
						//获取意外保名字的最大长度
						if(accidentProtectName[i].length>accidentOptionSize){
							accidentOptionSize=accidentProtectName[i].length;
						}
					}
					//设置所有意外保选项的宽度
					if(accidentOptionSize>0){
						//设置意外保选项文本框的宽度
						$("#accidentProtected").find("div:eq(0)").css("width",((accidentOptionSize-6)*12+64)+"px");
						//设置意外保下拉选项宽度
						$("#accidentProtected>ul").find("div").attr("style","width:"+((accidentOptionSize-6)*12+64)+"px");
					}
				}else{
					//隐藏意外保服务商品模块
					$("#accidentProtected").hide();
				}
				
			   //单击延保类型  意外保类型事件
			    $("#extendProtected div.sku,#accidentProtected div.sku").click(function () {	
			    	//用户选择去除掉当前服务商品
			    	if($(this).parent().hasClass("selected")){
			    		//删除文本框的高选样式
			    		$(this).parent().removeClass("selected");
			    		//删除当前文本框下拉列表中的高选样式
			    		$(this).next("ul").find("li").removeClass("selected");
			    	}
			    	
			      //如果用户单击延保服务商品
			      if($(this).parent().parent().parent().is("#extendProtected") ){
			    	  //将当前延保服务选项加上高选样式
			    	  var currentExtendLi=$(this).parent();
			    	  currentExtendLi.addClass("selected");
			    	  //将其他延保服务选项去掉高选样式
			    	  $(this).parent().siblings("li").not(currentExtendLi).removeClass("selected");
			    	  //将延保服务的文本框内容替换为当前选择的延保商品名称
				      $("#extendProtected>div.sku").html($(this).html());
				      //将文本框内容加上下拉箭头
				      $("#extendProtected>div.sku").append("<i></i><s></s>");
				      //将延保服务的文本框加上高选样式
				      $("#extendProtected").addClass("selected");
			      }
			      //如果用户单击意外保服务商品
			      if($(this).parent().parent().parent().is("#accidentProtected") ){
			    	  //将当前意外保服务选项加上高选样式
			    	  var currentAccidentLi=$(this).parent();
			    	  currentAccidentLi.addClass("selected");
			    	  //将其他意外保服务选项去掉高选样式
			    	  $(this).parent().siblings("li").not(currentAccidentLi).removeClass("selected");
			    	  //将意外保服务的文本框内容替换为当前选择的意外保商品名称
				      $("#accidentProtected>div.sku").html($(this).html());
				      //将文本框内容加上下拉箭头
				      $("#accidentProtected>div.sku").append("<i></i><s></s>");
				      //将意外保服务的文本框加上高选样式
				      $("#accidentProtected").addClass("selected");
			      }
					_updateSelect();
				});		
			    $('.pro-ew-area').show();
			} else {
				//隐藏购物服务模块
				$('.pro-ew-area').hide();
			}
			
			_updateSelect();
			// 合约机
			ec.product.initContract(sku);
		
			//赠送积分
			$("#integral").html(sku.integral);

			//捆绑和组合套装
			ec.product.renderGroup(_preSku);
			//切换商品介绍信息
			ec.product.tabSkuInfo(_preSku);
		};
	//切换显示当前选中的sku商品的相关信息
	ec.product.tabSkuInfo = function (skuId) {
		$('#pro-tab-feature-content-'+ skuId 
			+ ', #pro-tab-parameter-content-'+ skuId
			+ ', #pro-tab-package-content-'+ skuId 
			+ ', #pro-tab-service-content-'+ skuId).show().siblings().hide();
		$("#comb-pro-area").find(".selected").each(function(){
			$(this).removeClass("selected");
		});
		var count = parseInt($("#comb-count").html() ,10) && 0;
		var sku =ec.product.getSkuInfo(skuId);
		var price = parseFloat(sku.price);
		$("#comb-price").html(price.toFixed(2));
		$("#combList-list-"+skuId).show().siblings().hide();
		if(!($("#combList-list-"+skuId).children().eq(0).hasClass("current")))
		{
			$("#combList-list-"+skuId).children().eq(0).addClass("current").siblings().removeClass("current");
		}
		
	};
	ec.product.addSkuAttr = function(skuId , attrTypeId , attrName , attrId , attrValue)
	{

		/**
		 * SKU ID与属性值ID的关系
		 * ex : 10 = [41 , 44]
		 */
		 var sku = _skuMap[skuId];
		if(!sku)
		{
			_skuMap[skuId] = {attrIds : [attrId] };
		}else{
			sku.attrIds.push(attrId);
		}


		/**
		 * 属性值ID与SKU ID的关系
		 * ex : 41 = 10 
		 */
		_skuAttrId2SkuMap[attrId] = skuId;

		
		/**
		 * SKU属性与属性值的关系
		 * ex : 尺寸 = [S , XL]
		 */
		 var attrV = _skuAttrVallue[attrName];
		if(!attrV){
			_skuAttrName.push(attrName);
			_skuAttrTypeID.push(attrTypeId);
			_skuAttrVallue[attrName] = [attrValue];
		}else if(attrV.indexOf(attrValue) == -1){
				attrV.push(attrValue);
		}

		/**
		 * SKU属性名ID的不同的ID
		 * ex : attrTypeId = [41 , 42]
		 */
		 var ids = _skuAttrType2ValueIds[attrTypeId + "-" + attrValue];
		if(!ids)
		{
			_skuAttrType2ValueIds[attrTypeId + "-" + attrValue] = [attrId];
		}else{
			ids.push(attrId);
		}
		//log(_skuMap);

	};

	/**
	 * 设置SKU其他属性
	 */
	ec.product.setSku = function(skuId , options){
		options = options || {};
		options.id = skuId;
		$.extend((_skuMap[skuId] || (_skuMap[skuId] = {}) ) , options);
	};
	
	//获取选中的SKU
	ec.product.getSku = function(){
		var sku;
		//log(_selectAttrMap);
		$.each(_selectAttrMap , function(){
				if(!sku){
					sku = this;
					return;
				}

				var _t = this ,  newSku = [];
				//
				for(var i = 0 ; i < sku.length ; i ++)
				{
					for(var j = 0 ; j < _t.length ; j ++)
					{
						if(sku[i] == _t[j])
						{
							newSku.push(sku[i]);
						}
					}
				}
				sku = newSku;
		});
		//log("SKU",sku);
		if(!sku || sku.length ==0 || sku.length > 1)
		{
			return (_preSku || ec.product.defaultSku);
		}

		return sku[0];
	};

	ec.product.getSkuInfo = function(skuId){
		return _skuMap[skuId];
	};

	//设置SKU显示方式
	ec.product.setSkuShowType = function(attrTypeId , showType){
		_skuShowType[attrTypeId] = showType;
	};


	//根据SkuId选中属性
	ec.product.selectBySku = function(skuId){
		var sku = _skuMap[skuId];
		if(!sku || !sku.attrIds)
		{				
			//logger.warn("no sku attribute.");
			//判断有li没有则 调用_updateSkuInfo 如果有 就不调用 
		//	if($("#pro-skus").find("li").size()==0){
			//	_updateSkuInfo();
		//	}	
			return;
		}
		$("#pro-skus").find(".attr" + sku.attrIds.join(",.attr")).children(".sku").trigger("click");
	};

	ec.ready(function(){
		//_preSku = ec.product.defaultSku;

		//构造显示SKU属性
		var html = [] , attrTypeId , attrName , attrValueIds , showText;
		
		for(var i = 0 ; i < _skuAttrName.length ; i++)
		{
			attrTypeId = _skuAttrTypeID[i];
			showText = (_skuShowType[attrTypeId] == "2");
			//属性类型, ex:颜色
			attrName = _skuAttrName[i];
			
			html.push('<dl class="clearfix '+(showText ? "pro-sku-text" : "pro-sku-img")+'"><dt>选择'+attrName+'：</dt><dd><ol>');
			//属性值文字, ex:红色, 绿色
			var values = _skuAttrVallue[attrName];	
			for(var j = 0 ; j < values.length ; j++)
			{		
				//属性值的ids , ex: [16 , 17]
				attrValueIds = _skuAttrType2ValueIds[attrTypeId + "-" +values[j]];
				html.push('<li class="tac pointer attr'+attrValueIds.join(" attr")+'" data-attrName="'+attrName+'" data-attrId="'+attrValueIds.join(",")+'"><div class="sku"> <a title="'+values[j]+'">');
				if(showText)
				{
					html.push(values[j]);
					html.push('</a><s></s>');
				}else{
					//ex: sku = skuMap[ arrrId2skuId[attrId] ]
					var sku = _skuMap[_skuAttrId2SkuMap[attrValueIds[0]]];
					html.push('<img src="'+ec.mediaPath + sku.photoPath+"40_40_"+sku.photoName+'" alt="'+values[j]+'"/>');
					html.push('</a><s></s>'+values[j]);
				}
				html.push('</div></li>');
			}
			html.push('</ol></dd></dl>');
		}
		var skuObj = $(html.join(""));
		
		skuObj.find(".sku").click(function(){
			var thix =$(this).parent();
			//已禁用的不能点击			
			if(thix.hasClass("disabled"))return false;
			
			var attrIds = thix.attr("data-attrId").split(",") ,
				attrName = thix.attr("data-attrName"),
				skuIds = [];
			
			for(var i = 0 ;i < attrIds.length ; i ++)
			{
				skuIds.push(_skuAttrId2SkuMap[attrIds[i]]);
			}
			

			//设置选中的属性值
			_selectAttrMap[attrName] = skuIds;

			attrIds = [];
			
			 
			for(var i = 0 ;i < skuIds.length ; i ++)
			{
				var tmp = _skuMap[skuIds[i]].attrIds
				for(var j = 0 ; j < tmp.length; j++)attrIds.push(tmp[j]);
			}
			

			thix.addClass("selected").siblings().removeClass("selected disabled");
			
			
			skuObj.not(thix.parents("dl"))
				.find("li").removeClass("disabled")
				.not($(".attr"+attrIds.join(",.attr"))).removeClass("selected").addClass("disabled");
			
			
			var sku = ec.product.getSku();
			sku = _skuMap[sku];
			
			_updateSelect();
		
 
			_updateSkuInfo();
		});
		
		//如果热销榜单为0 则不显示 
		if($('.hot-area').find("li").size()==0)
			{ 
			$('.hot-area').hide();
 
			$("#pro-seg-hot").hide();
			}		
		
		$("#pro-skus").html(skuObj);
		
		//选中默认的SKU属性

		ec.product.selectBySku(ec.product.setSkuId || ec.product.defaultSku);

		//套图切换
		$("#pro-gallerys").find("img").mouseover(_proGallerysMouseOver);
	});
})();

ec.product.disableAddCartButtons = function()
{
	$('#pro-operation a.button-add-cart').each(function()
	{
		$(this).removeClass("button-style-1").addClass("button-style-disabled-1");
		this.backup = this.onclick;
		this.onclick = '';
	});
	
	$('a.button-add-cart-2, a.button-add-cart-3').each(function()
	{
		$(this).removeClass("button-style-1").addClass("button-style-disabled-1");
		this.backup = this.onclick;
		this.onclick = '';
	});
};

ec.product.enableAddCartButtons = function()
{
	$('#pro-operation a.button-add-cart').each(function()
	{
		$(this).removeClass("button-style-disabled-1").addClass("button-style-1")
			.css('background-position-y', '8px');
		this.onclick = this.backup;
		this.backup = '';
	});
	
	$('a.button-add-cart-2, a.button-add-cart-3').each(function()
	{
		$(this).removeClass("button-style-disabled-1").addClass("button-style-1");
		this.onclick = this.backup;
		this.backup = '';
	});
};

//加入购物车
ec.product.addCart = function(){
//	var $this = $('#pro-operation a.button-add-cart');
//	if ($this.length > 0)
//	{
//		$this.removeClass("button-style-1").addClass("button-style-disabled-1")
//			.css('background-position-y', '-38px');
//		$this[0].onclick = '';
//	}
	ec.product.disableAddCartButtons();
	
	//定义添加到购物车的ajax的参数
	var paras;
	//定义所有商品（单品+服务商品）的SkuId数组
	var allSkuIds=[];
	//定义服务商品对应的单品的skuId数组
	var extendSkuId=[];
	//定义所有商品的类型（单品加上延保商品或者意外保商品的商品类型）
    var types=[];
    //定义所有商品的数量（单品加上延保商品或者意外保商品）
    var quantities=[];
	//将单品的skuId赋值给allSkuIds数组的第一个元素
	allSkuIds[0]=ec.product.getSku();
	//因为所有商品中，第一个商品是单品，不是服务商品，所以置空。
	extendSkuId[0]="";
	//获取页面中选中的服务商品的skuId，并构成参数数组
	var $extendList = $("ul>li.selected>div.sku");
        for(var i=0;i<$extendList.length;i++){
        	allSkuIds[i+1]=$($extendList[i]).attr("title");
         }
    //types的第一个元素为主商品的商品类型
    types[0]=1;
    //quantities的第一个元素为单品的数量
    quantities[0]=$("#pro-quantity").val();
    //判断用户是否选择了延保商品
    if($("#extendProtected").hasClass("selected")){
    	//如果选择了延保商品，则types的第二个元素为延保商品类型
    	types[1]=6;
    	//如果选择了延保商品，则quantities的第二个元素为对应的延保商品的数量
    	quantities[1]=$("#pro-quantity").val();
    	//如果选择了延保商品，extendSkuId数组的第二个元素为对应的单品的skuId
    	extendSkuId[1]=ec.product.getSku();
    	//判断用户是否选择了意外保商品
    	 if($("#accidentProtected").hasClass("selected")){
    		 //如果用户选择了延保商品，并且又选择了意外保商品,则types的第三个元素为意外保商品类型
    	    	types[2]=7;
    	     //如果用户选择了延保商品，并且又选择了意外保商品,则quantities的第三个元素为意外保商品的数量
    	    	quantities[2]=$("#pro-quantity").val();
    	     //如果用户选择了延保商品，并且又选择了意外保商品,则extendSkuId数组的第三个元素为对应的单品的skuId
    	    	extendSkuId[2]=ec.product.getSku();
    	    }
    }else{
   	 if($("#accidentProtected").hasClass("selected")){
   	      //如果用户没有选择延保商品，只是选择了意外保商品，则types的第二个元素为意外保商品类型
   	      types[1]=7;
   	     //如果用户没有选择延保商品，只是选择了意外保商品，则quantities的第二个元素为意外保商品数量
   	     quantities[1]=$("#pro-quantity").val();
   	      //如果用户没有选择延保商品，只是选择了意外保商品，则extendSkuId数组的第二个元素为对应的单品的skuId
   	       extendSkuId[1]=ec.product.getSku();
   	    }
    }
        
	paras = { 
		skuIds : allSkuIds,
		extendSkuIds : extendSkuId,
		quantity : quantities,
		type : types
	};
	
	ec.cart.add(paras, {
		successFunction : function(json){
			ec.cart.getCartBaseInfo(json.cart, function(json)
			{
				$("#cart-tips").show();
				$("#cart-total, #header-cart-total").html(json.cartInfo.totalNumber);
				$("#cart-price").html(json.cartInfo.totalPrice.toFixed(2));
			});
			//ec.track(["/product/buyType" , "cart"]);
			//ec.track(["/cart/add" , ec.product.id , skuId]);
			ec.product.enableAddCartButtons();
		},
		errorFunction : function(json){
			//alert(json.msg);
			$("#popup-tips-msg").html(json.msg);
			$("#popup-tips").show();
			ec.product.enableAddCartButtons();
		}
	});
};

//加入购物车 - 登录
ec.product.addCartWithLogin = function(){
	ec.account.afterLogin(ec.product.addCart);
};

//购买组合套装
ec.product.buyBundle = function(bundleId){
	ec.product.disableAddCartButtons();

	//ec.product.buy("bundle",bundleId);
	var paras = { 
			skuIds : [bundleId],
			quantity : [1],
			type : [2]
			
	};

	ec.cart.add(paras, {
		successFunction : function(json){
			ec.product.enableAddCartButtons();
			$("#order-shoppingCart-form").submit();
		},
		errorFunction : function(json){
			ec.product.enableAddCartButtons();
			alert(json.msg);
		}
	});
};

ec.product.buyComb = function(){

	var id = ec.product.getSku(),
		skuIds = [id],
		quantity = [1],
		type=[1],
		isPriority = $("#isPriority").val();
	$('[id="comb-pro-'+id+'"]').find("input[name=skuId]:checked").each(function(){
		skuIds.push(this.value);
		quantity.push(1);
		type.push(1);
	});
	var paras = { 
			skuIds : skuIds,
			quantity : quantity,
			type : type
			
	};
	
	if(isPriority == 1) {
		return ec.product.buy("sku",skuIds);
	}
	
	ec.product.disableAddCartButtons();
	
	//ec.product.buy("sku",skuIds);
	ec.cart.add(paras, {
		successFunction : function(json){
			ec.product.enableAddCartButtons();
			$("#order-shoppingCart-form").submit();
		},
		errorFunction : function(json){
			ec.product.enableAddCartButtons();
			alert(json.msg);
		}
	});
};

//立即购买
ec.product.buy = function(type , id){
	//BI上报
	_paq.push(['trackLink','立即购买', 'link', ' ']);
	ec.code.addAnalytics({hicloud:true});
	
	ec.account.afterLogin(function(){

		//ec.track(["/product/buyType" , "direct"]);

		var input = "";
		if(type == "sku")
		{
			id = id || ec.product.getSku();
			if(!ec.util.isArray(id))
			{
				id = [id];
			}
			var sbs = [];
			var types = [];
			var qtys = [];
			var ess = [];
			var quantity = $("#pro-quantity").val();
			for(var i = 0 ; i < id.length ; i ++)
			{
				sbs.push(id[i]);
				types.push(1);
				qtys.push(quantity);
				ess.push("");
			}
			input = '<input name="sbs" type="text" value="'+sbs.join(',')+'">';
			input += '<input name="types" type="text" value="' + types.join(',') + '">';
			input += '<input name="qtys" type="text" value="' + qtys.join(',') + '">';
			input += '<input name="ess" type="text" value="' + ess.join(',') + '">';
		}else{
			input = '<input name="sbs" type="text" value="'+id+'">';
			input += '<input name="types" type="text" value="2">';
			input += '<input name="qtys" type="text" value="1">';
			input += '<input name="ess" type="text" value="">';
		}
		var form = gid("order-confirm-form");
		form.innerHTML = input;
		form.action =$("#order-confirm-form").attr("action");
		form.method = "post";
		setTimeout(function () {form.submit();}, 500);
	});
};

//到货通知
ec.product.arrival = function(){
	ec.account.afterLogin(function(){
		var box = new ec.box($("#product-arrival-html").val() , {
			boxid : "product-arriva-box",
			title : "到货通知",
			width : 580,
			focus : "input[name=email]",
			showButton : false,
			onok : function(box){
				var email = box.find("#email").val();

				if(!email)
				{
					alert("请输入email！");
					return;
				}
				if(!ec.util.isEmail(email))
				{
					alert("请输入正确的email！");
					return;
				}

				new ec.ajax().submit({
					url : "/product/arrivalMail.json",
					data : {
						email : email,
						skuId : ec.product.getSku()
					},
					timeout : 10000,
					timeoutFunction : function() {
						alert("操作超时，请重试！");
					},
					beforeSendFunction : ec.ui.loading.show,
					afterSendFunction : ec.ui.loading.hide,
					successFunction : function(json){
						if(!json.success)
						{
							ec.showError(json);
							return;
						}
						alert("设置成功！");
						box.close();
					}

				});


			}
		});
		box.open();
		box.find("#email").focus();
	});
};

//关注此商品
ec.product.attention = function () {
	var box = new ec.box($("#product-attention-html").val() , {
			boxid : "product-attention-box",
			title : "关注商品",
			width : 580,
			focus : "input[name=email]",
			showButton : false,
			onok : function(box){
				var email = box.find("input[name=email]").val(),
					mobile = box.find("input[name=mobile]").val(),
					regMobile = /^0?(13|14|15|17|18)[0-9]{9}$/;


				if(!email)
				{
					alert("请输入email！");
					return;
				}
				if(!ec.util.isEmail(email))
				{
					alert("请输入正确的email！");
					return;
				}

				if(!mobile)
				{
					alert("请输入手机号码！");
					return;
				}
				if(!regMobile.test(mobile))
				{
					alert("请输入正确的手机号码！");
					return;
				}

				new ec.ajax().submit({
					url : "/product/saveAttention.json",
					data : {
						email : email,
						phone : mobile,
						skuId : ec.product.getSku()
					},
					timeout : 10000,
					timeoutFunction : function() {
						alert("操作超时，请重试！");
					},
					beforeSendFunction : ec.ui.loading.show,
					afterSendFunction : ec.ui.loading.hide,
					successFunction : function(json){
						if(!json.success)
						{
							ec.showError(json);
							return;
						}
						alert("设置成功！");
						box.close();
					}

				});


			}
		});
		box.open();
		box.find("input[name=email]").focus();
};
//验证是否允许购买延保服务
ec.product.checkExtend = function () {
	var skuId = ec.product.getSku();
		val = $.trim($('#extend-text').val()),
		$succussMsg = $('#extend-msg-succuss'),
		$errorMsg = $('#extend-msg-error'),
		msgText = '<span class="fcn">*</span>&nbsp;',
		link = '';
	if(val.length > 5) {
		new ec.ajax().get({
			url : '/tcs/query.json?_t='+ (new Date()).getTime()+'&skuId='+ skuId +'&imei='+ val,
			timeout : 10000,
			timeoutFunction : function(){
				$("#pro-extend-result-id").removeClass("hide");
				$errorMsg.html(msgText + '操作超时，请重试！').show();
				$succussMsg.hide();
			},
			beforeSendFunction : function(){
				ec.ui.loading.show({modal : false});
			},
			afterSendFunction  : ec.ui.loading.hide,
			successFunction : function(json){
				
				if(!json.success) {
					if(json.otherPrdId) link = '&nbsp;&nbsp;<a href="/product/'+ json.otherPrdId +'.html#'+ json.otherSkuId+',0">前去购买>></a>';
					$("#pro-extend-result-id").removeClass("hide");
					$errorMsg.html(msgText + json.msg + link).show();
					$succussMsg.hide();
					$('#button-extend').attr('class', 'button-style-disabled-1 button-go-extend-checkout-disabled');
					return;
				}
				$("#pro-extend-result-id").removeClass("hide");
				$succussMsg.html(msgText + json.msg).show();
				$errorMsg.hide();
				$('#button-extend').attr('class', 'button-style-1 button-go-extend-checkout');
			}
		});
	} else {
		$succussMsg.hide();
		$("#pro-extend-result-id").removeClass("hide");
		$errorMsg.html(msgText + '请输入正确的IMEI/SN/MEID信息').show();
		$('#button-extend').attr('class', 'button-style-disabled-1 button-go-extend-checkout-disabled');
	}
	return false;
};
//购买延保订单
ec.product.extendBuyNow = function () {
	//BI上报
	_paq.push(['trackLink','延保商品 - 立即购买', 'link', ' ']);
	ec.code.addAnalytics({hicloud:true});
	$('#extend-text').val('');
	$('#extend-msg-succuss,#extend-msg-error').hide();
	$('#button-extend')[0].className = "button-style-disabled-1 button-go-extend-checkout-disabled";
	$('#popup-extend').show();
};
//购买延保订单
ec.product.extendBuy = function (obj) {
	//BI上报
	_paq.push(['trackLink','延保商品 - 提交订单', 'link', ' ']);
	ec.code.addAnalytics({hicloud:true});

	var imei = $.trim($('#extend-text').val());
	if(obj.className != 'button-style-1 button-go-extend-checkout' || !imei) return;
	
	ec.account.afterLogin(function(){

		var id = ec.product.getSku(),
			input = "",
			form = gid("order-confirm-form");

		if(!ec.util.isArray(id)){
			id = [id];
		}
		for(var i = 0 ; i < id.length ; i ++) {
			input += '<input name="skuIds" type="text" value="'+id[i]+'">';
		}
		input += '<input name="imei" type="text" value="'+ imei +'">';
		form.innerHTML = input;
		setTimeout(function () {form.submit();}, 500);
	});
};




//合约机
ec.product.initContract = function(sku)
{
	// 合约机
	if(sku.contractList.length > 0){
		// 合约机
		var lst,_contractListObj;
		
		html = [];
		for(var i=0; i< sku.contractList.length; i+=1){
			lst = sku.contractList[i];
			html.push('<li data-id="'+ lst.id +'"> <div class="sku"><a title="'+ lst.name +'" href="javascript:;">'+ lst.name +'</a><s></s></div ></li>');
			
		}
		_contractListObj = $('<ol>' + html.join("")+ '</ol>');				
		
		$('.sku', _contractListObj).click(function () {	
			$(this).parent().toggleClass('selected').siblings().removeClass('selected');
		});
		
		$('#contractList-ol').html(_contractListObj);
		$('#contractLst').show();

		$("#contractLst .sku").unbind("click").click(function(){
			$(this).parent().toggleClass('selected').siblings().removeClass('selected');
		
			var $quantityObj = $('#pro-quantity-area'),
				$liSelected = $("#contractLst li.selected"),
				$btn = $('#pro-operation'),
				$contractForm = $('#contractForm'),
				_sku, _haveInventory;
			
			
			ec.product.addCartBtn = ec.product.addCartBtn || $btn.html();
			_sku = ec.product.getSku();
			_haveInventory = ec.product.inventory.haveInventory(_sku);

			if($liSelected.length > 0 && _haveInventory) {
				$quantityObj.hide();
				$btn.html($('<a title="立即购买" class="button-buy button-style-1" href="javascript:;"><span>立即购买</span></a>').click(function () {
					//BI统计
					_paq.push(['trackLink','合约机-立即购买', 'link', ' ']);
					ec.code.addAnalytics({hicloud:true});
					setTimeout(function () {
						var url = $contractForm.attr('action');
						$contractForm.attr('action', url.replace('{id}', $liSelected.attr('data-id'))).submit();
					}, 200);
								
				})).css('visibility', 'visible');
              
			} else {
				ec.product.execute("renderInventory", [_haveInventory]);
				//$btn.html(ec.product.addCartBtn).css('visibility', 'hidden');
				$quantityObj.show();
			}
		});
		//默认选中第一个
		$("#contractLst .sku").eq(0).click();
	} else {
		$('#contractLst').hide();
	}
};
//跳转到评论tab
ec.product.jmptoRemark = function(){
	$('#pro-tab-evaluate').click();
	ec.ui.scrollTo("#pro-tab-evaluate");	
};

//增加处理checkbox样式的代码，对隐藏的checkbox表单操作，并计算当前选择的套餐价格
ec.product.combClick = function(ths){		
	if($(ths).hasClass("selected")==false)
	{
		$(ths).addClass("selected");
		$(ths).children("input").attr("checked",true);
	}
	else 
	{
		$(ths).removeClass("selected");
		$(ths).children("input").attr("checked",false);
	}
	var thix = $(ths).children("input");
	count = parseInt($("#comb-count").html() ,10) || 0,
	price = parseFloat($("#comb-price").html()) || 0;
	
	if(thix.attr("checked")==true)
	{
		price += parseFloat(thix.attr("data-price"));
		count++;
	}
	else
	{
		price -= parseFloat(thix.attr("data-price"));
		count--;
	}
	$("#comb-price").html(price.toFixed(2));
	$("#comb-count").html(count);
};

(function(){
	var _index = 0,
		_length;
	
	ec.ready(function(){
		_length = $("#pro-gallerys").css("left" , "0").children().length;
	});

	ec.product.imgSlider = {
		prev : function(){
			if(_index == 0)return;
			_index--;
			 $("#pro-gallerys").animate({
				 "left" : _index * -84
			 } ,100);
		},
		next : function(){
			if(_index+5 >= _length)return;
			_index++;

			 $("#pro-gallerys").animate({
				 "left" : _index * -84
			 } ,100);
		},
		reset : function(){
			 _length = $("#pro-gallerys").css("left" , "0").children().length;
		}
	};
})();

(function(_ep){

	var _bundleId,
		_renderComb = function(skuId){
			var comb = $("#comb-pro-"+skuId);


			//计算价格
			var sku = _ep.getSkuInfo(skuId),
				//price = sku.skuPrice; //优惠价
				price = parseFloat(sku.price);

			comb.find("input[name=skuId]:checked").each(function(){
				price += parseFloat(this.getAttribute("data-price"));
			});
			
			$("#comb-price").html(price.toFixed(2));
		};

	//渲染页面的组合套装和捆绑
	_ep.renderGroup = function(skuId){
		
		var _showId = [] ,
		
		bundle = $("#bundle-list-"+skuId),
		comb = $("#comb-pro-"+skuId);

		//该sku有套装
		if(bundle.length > 0)
		{
			_showId.push("#tab-bundle");
			bundle.show().siblings().hide();
			_ep.renderBundle(skuId);
		}

		//该sku有推荐商品
		if(comb.length > 0)
		{
			_showId.push("#tab-comb");
			$("#comb-"+skuId).show().siblings().hide();
			comb.show().siblings().hide();
			_renderComb(skuId);
		}

		$("#tab-bundle,#tab-comb").hide();
		if(_showId.length == 0)
		{
			$("#group-area").hide();
			return;
		}

		if(_showId.length > 1)
		{
			_showId.push("#tab-split")
		}

		_showId.push("#group-area");
		$(_showId.join(",")).show();

	};

	_ep.renderBundle = function(skuId){
		var bundleList = $("#bundle-list-"+skuId);
		this.showBundle(bundleList.children("li.current").attr("data-id"));
	};

	_ep.showBundle = function(bundleId){
		$("#bundle-pro-"+bundleId+",#bundle-price-"+bundleId).show().siblings().hide();
		_bundleId = bundleId;

		var bundle = $("#bundle-pro-"+bundleId);
	};


})(ec.product);


//配置
(function(){

	var _type;
	_options = {};
	_options["default"] = {};
	
	_options["normal"] = {
		//渲染操作区
		renderInventory : function(haveQuantity){
			var getSku = ec.product.getSkuInfo(ec.product.getSku() || ec.product.defaultSku),
				$proMsg = $("#pro-msg"),
				$buyBtns = $("#pro-quantity-area,#pro-operation"),
				$buyBtnMod = $("#pro-operation"),
				isPriority = $("#isPriority").val();;
			

			$("#tab-addcart-button").hide();
			$("#tab-notice-button").hide();

			if(ec.product.status == 3) {//下架商品
				$proMsg.show(); 		
				$("#pro-msg-title").html("该商品已下架");
				$buyBtnMod.css("visibility" , "hidden");
				return;
			}
			
			if(ec.product.status == 5) {//该商品不在此销售前端销售
				$proMsg.show(); 		
				$("#pro-msg-title").html("该商品不在此销售前端销售");
				$buyBtnMod.css("visibility" , "hidden");
				return;
			}
 
			//提示内容, 有则显示，无则隐藏
			if(getSku.tipsContent.length > 1) {
				$proMsg.show();
				$("#pro-msg-title").html(getSku.tipsContent);
			} else {
				$proMsg.hide();
			}

			//价格显示方式，1：正常显示；2：暂不报价
			if(getSku.priceMode == 2) {
				$("#pro-price").html('华&nbsp;&nbsp;为&nbsp;&nbsp;价：<b>暂无报价</b>');
			} 
			
			if(isPriority == 1) {
				$buyBtnMod.html('<a href="javascript:;" class="button-buy button-style-1" title="立即购买" onclick="ec.product.buy(\'sku\');return false;"><span>立即购买</span></a>');
				$("#pro-quantity-area").hide();
				$buyBtnMod.css("visibility" , "visible");
				$("#order-confirm-form").attr("action", "/order/priorityConfirm");
				return;
			}
				
			/*
				按钮显示方式
			 
				1：正常加入购物车；
				2：DBank下单(立即购买)；
				3：新品下单(预留,暂时没用)；
				4：关注商品；
				5：无按钮; 
				6:延保商品(立即购买)
			*/
			switch(parseInt(getSku.buttonMode, 10)) {
				case 5 :
					$buyBtnMod.css("visibility" , "hidden");
					$("#pro-quantity-area").hide();	
					return;
				case 4 :
					$buyBtnMod.html('<a href="javascript:;" class="button-interest button-style-2" title="关注此商品" onclick="ec.product.attention()"><span>关注此商品</span></a>');
					 $("#pro-quantity-area").show();
					$buyBtnMod.css("visibility" , "visible");				
					return;
				case 2 :
					$buyBtnMod.html('<a href="javascript:;" class="button-buy button-style-1" title="立即购买" onclick="ec.product.buy(\'sku\');return false;"><span>立即购买</span></a>');
					$("#pro-quantity-area").show();
					$buyBtnMod.css("visibility" , "visible");
					return;
				case 6 :
					$buyBtnMod.html('<a href="javascript:;" class="button-buy button-style-1" title="立即购买" onclick="ec.product.extendBuyNow();return false;"><span>立即购买</span></a>');
					$("#pro-quantity-area").show();
					$buyBtnMod.css("visibility" , "visible");
					return;
				default :
					break;

			}
			
			

			if(haveQuantity) { //是否有库存			
				$("#pro-quantity-area").show();
				$buyBtnMod.css("visibility" , "visible");
				//$proMsg.hide();
				if(getSku.groupType == '1'){
					$buyBtnMod.html('<a href="javascript:;" onclick="ec.product.addCart()" class="button-group-2 button-style-1" title="立即团购"><span>立即团购</span></a>');
				}else{		
					$buyBtnMod.html('<a href="javascript:;" onclick="ec.product.addCart()" class="button-add-cart button-style-1" title="加入购物车"><span>加入购物车</span></a>');
					$("#tab-addcart-button").show();
				}
			}else{			
				//$proMsg.hide();
				$("#pro-quantity-area").hide();
				$buyBtnMod.css("visibility" , "visible");
				
				$buyBtnMod.html('<a href="javascript:;" class="button-notice-arrival button-style-2" title="到货通知" onclick="ec.product.arrival()"><span>到货通知</span></a>');
				$("#tab-notice-button").show();	
			}
			
			if(getSku.buttonMode == 7 && getSku.gotoUrl.length > 0) {
				$buyBtnMod.append('<a target="_blank" href="'+getSku.gotoUrl+'" class="button-style-2 button-appointment" title="参加活动"><span>参加活动</span></a>');
			}
		
		}
	};

	//实物预约购买
	_options["reservation"] = {
		renderInventory : function(haveQuantity){
			
			$("#pro-msg").hide();
			if(haveQuantity) {
				$("#pro-quantity-area").show();
				$("#pro-operation").html('<a href="javascript:;"  onclick="ec.product.addCartWithLogin()" class="button-book-2  button-style-1" title="预约购买"><span>预约购买</span></a>');
			}else{
				$("#pro-quantity-area").hide();
				//$("#pro-operation").html('<a href="javascript:;" class="button-sellOut" title="卖光了"><span>卖光了</span></a>');
				$("#pro-operation").html('<a href="javascript:;" class="button-notice-arrival button-style-2" title="到货通知" onclick="ec.product.arrival()"><span>到货通知</span></a>');
				
			}
		}
	};

	_options["queue"] = {
		renderInventory : function(haveQuantity){
			if(haveQuantity)
			{
				$("#sale-buy-btn").show();
				$("#sale-sell-out").hide();
			}else{
				$("#sale-buy-btn").hide();
				$("#sale-sell-out").show();
			}
		}
	};

	_options["seckill"] = {
		renderInventory : function(haveQuantity){
			if(haveQuantity)
			{
				$("#sale-buy-btn").show();
				$("#sale-sell-out").hide();
			}else{
				$("#sale-buy-btn").hide();
				$("#sale-sell-out").show();
			}
		}
	};

	ec.product.execute = function(command , args){
		var opt = _options[_type],
			fun = opt[command] || _options["default"][command];

		if(fun)fun.apply(ec.product , args);
	};

	ec.product.setType = function(type){
		_type = type;
		switch(type)
		{
			case "normal":
			case "reservation":
				ec.product.isSale = false;
				break;
			default :
				ec.product.isSale = true;
		}
		//是否促销
		ec.product.prefix = ec.product.isSale ? "/sale" : "/product"
		//$.extend(ec.product , _options[type]);
	};
})();



ec.ready(function(){

	var product = ec.product;

	var loadEvaluate = false;
	var bFirstLoadEvaluate  = false;

	//用户评价列表
	var _loadEvaluate = function(page) {
		var typeid=$("#pro-evaluate-click-type").children('.current').attr("id");		
		if(typeid=="pro-evaluate-click-high")
			page.type=0;
		else if(typeid=="pro-evaluate-click-mid")
			page.type=1;
		else if(typeid=="pro-evaluate-click-low")
			page.type=2;
		else 
			page.type=-1;
		
		var strType,rquest;
		 if(page.type>=0)
			 { 
			 strType=new String(page.type);
			 rquest="&remarkLevel="+strType;
			 
			 }
		 else rquest="";
		 
		new ec.ajax().get({
			//url : ec.product.prefix + "/queryEvaluate.json?pid="+ec.product.id+"&pageNumber=" + page.pageNumber+rquest,
			url : ec.remark.prefix + "/queryEvaluate.json?pid="+ec.product.id
				+"&pageNumber=" + page.pageNumber+rquest + "&t=" + new Date().getTime(),
			dataType : "jsonp",
			successFunction : function(json){
				if(!json.success){
					return;
				}
				
				if(bFirstLoadEvaluate==true)
					ec.ui.scrollTo("#pro-tab-evaluate");
				
				bFirstLoadEvaluate=true;
				
				loadEvaluate = true;
				var html = [],
					p,
					v ;
				
				
				for ( var i = 0; i < json.remarkList.length; i++) {
					p = json.remarkList[i];
					
					var grade = p.gradeCode == null ? 0 : p.gradeCode;
					
					html.push('<div class="pro-comment-item clearfix">');//pro-comment-item start
					
					//用户信息
					html.push('<div class="pro-comment-user"><p class="pro-comment-user-img"><img src="/images/echannel/misc/defaultface_user_small.png" alt="');
					html.push(ec.util.escapeHtml(p.custName));
					html.push('"/></p><p class="pro-comment-user-name">');
					html.push(ec.util.escapeHtml(p.custName));
					html.push('</p>');
					html.push('<s class="pro-comment-user-tag"><i class="icon-vip-level-' + grade + '"></i></s>');
					html.push('</div>');
					
					html.push('<div class="pro-user-comment-main">');//pro-user-comment-main start
					
					html.push('<div class="pro-user-comment">');//pro-user-comment start
					
					html.push('<div class="h clearfix">');// h clearfix start
		
					html.push('<div class="pro-user-comment-score">');
					html.push('<span class="pro-star"><span class="starRating-area"><s style="width:'+ (p.score * 20)+'%"></s></span></span><em><b>'+p.score+'&nbsp;分</b>&nbsp;&nbsp;'+p.remarkLevel+'</em>');
					html.push('</div>');

					//评价印象
					html.push('<div class="pro-user-comment-impress">');
					html.push('<ul>');
					for ( var j = 0; j < p.labelList.length; j++) {						
						html.push('<li>'+p.labelList[j]+'</li>');
						}
					html.push('</ul>');
					html.push('</div>');
					
					//评价时间	
					html.push('<div class="pro-user-comment-time">');
					html.push(p.createDate);		
					html.push('</div>');
					
					html.push('</div>'); //h clearfix end
					
					//用户评议内容
					html.push('<div class="b">');
					html.push((ec.util.escapeHtml(p.content) || ""));
					html.push('</div>');
					html.push('</div>');

					 
					for ( var j = 0; j < p.msgReplyList.length; j++) {
						v = p.msgReplyList[j];					
						
						html.push('<div class="pro-admin-reply">');
						html.push('<dl class="clearfix">');
						html.push('<dt>'+ (ec.util.escapeHtml(v.replyerName) || "") +'回复：</dt>');						
						html.push('<dd>'+(ec.util.escapeHtml(v.replyContent) || "")+'</dd>'); 
						html.push('</dl>'); 
						html.push('</div>'); 
						
					}
					
					html.push('<div class="arrow"></div>');
					
					html.push('</div>');//pro-user-comment end 
					
					html.push('</div>');//pro-user-comment-main end 
					html.push('</div>');//pro-comment-item end 
				}

				
				// 无评论的时候隐藏掉外面的虚线框
				var proMsgList = $("#pro-msg-list");
				proMsgList.html(html.join(""));
				if (json.remarkList.length == 0) {
					proMsgList.hide();
				} else {
					proMsgList.show();
				}
				
				if(json.page.totalPage >1)			
				{
					$("#pro-msg-pager").show();
					$("#pro-msg-pagerup").show();
					$("#pro-msg-pager").pager({
						pageNumber : json.page.pageNumber,
						pageCount : json.page.totalPage,
						recordCount : json.page.totalRow,
						qpageSize:5, 
						text:{ 
							first:"|&lt;", 
							pre:"&lt", 
							next:"&gt;", 
							last:"&gt;|"
						}, 
						item:["first","pre","qpage","next","last","quickPager"],//显示样式 
						callBack: _loadEvaluate 
					});
					
					$("#pro-msg-pagerup").pager({
						pageNumber : json.page.pageNumber,
						pageCount : json.page.totalPage,
						recordCount : json.page.totalRow,
						qpageSize:5, 
						text:{ 
							first:"|&lt;", 
							pre:"&lt", 
							next:"&gt;", 
							last:"&gt;|"
						}, 
						item:["first","pre","qpage","next","last","quickPager"],//显示样式 
						callBack: _loadEvaluate
					});
				}
				else {
					$("#pro-msg-pager").hide();
					$("#pro-msg-pagerup").hide();
				}
			}
		});
	};
	
	var _loadEvaluateScore = function() {
		new ec.ajax().get({
			//url : ec.product.prefix + "/queryEvaluateScore.json?pid="+ec.product.id,
			url : ec.remark.prefix + "/queryEvaluateScore.json?pid="+ec.product.id + "&t=" + new Date().getTime(),
			dataType : "jsonp",
			successFunction : function(json){
				if(!json.success){
					return;
				}
				
				//显示评价数量 并计算总数
				var numberAll=0;
				for(var i=0;i<3;i++ ){
					var p=json.remarkLevelList[i];
					if(p) {
						var number='('+(p.times||('0'))+')';
						var times=('('+p.percent+'%)')||"";
						var percent=('width:'+p.percent+'%'||"");
						
						var eva,evb,evc;
						if(i==0){
							eva=$("#pro-evaluate-number-high");
							evb=$("#pro-score-percent-high");
							evc=$("#pro-score-draw-high");
							
							$("#pro-evaluate-avgSorce").html(p.percent);									
						}
						else if(i==1){ 
							eva=$("#pro-evaluate-number-mid");
							evb=$("#pro-score-percent-mid");
							evc=$("#pro-score-draw-mid");
						}
						else if(i==2){
							eva=$("#pro-evaluate-number-low");
							evb=$("#pro-score-percent-low");
							evc=$("#pro-score-draw-low");
						}
						numberAll+=parseInt((p.times||('0')));
						eva.html(number);
						evb.html(times);
						evc.attr("style",percent);
					}
					else{
						eva.html('(0)');	
						evb.html('(0%)');	
						evc.attr("style",'(width:0%)'); 
					}
				}
				
				var str=new String(numberAll);
				$("#pro-evaluate-number-all").html('('+str+')');
				
				//表头评论统计数据加载
				if(json.remarkLabelList){ 
					var html0 = [];
					html0.push('<dl>');
					html0.push('<dt>买家印象：</dt>');
					for(var i=0;i<json.remarkLabelList.length;i++){
						var p=json.remarkLabelList[i];	
						var q=p.times>0?('<em>('+(p.times||"")+')</em>'):"";
							html0.push('<dd>'+(p.labelName||"")+q+'</dd>');
					}
					html0.push('</dl>');
					$("#pro-score-impress").html(html0.join(""));
				}

				//var html = [] , p , map = {};
				//for (var i = 0; i < json.remarkPerNumLst.length; i++) {
				//	p = json.remarkPerNumLst[i];
				//	map[p.score] = p.personNum;
				//}
				//for (var i = 5; i >0; i--) {
				//	p = map[i] || 0;
				//	html.push('<li><span class="pro-star vam"><img alt="' + i + '星" ');
				//	html.push('src="/images/echannel/star/star' + i + '.png" /></span><em>' + p);
				//	html.push('</em></li>');
				//}
                //
				//$("#pro-score-detailed").html(html.join(""));
				//$("#pro-score-average").html(json.avgScore);
				//$("#pro-score-rating").html('<s style="width:' + (json.avgScore * 20) + '%"></s>');
			}
		});
	};
	
	//显示当前sku相关信息
	ec.product.tabSkuInfo(ec.product.setSkuId || ec.product.defaultSku);
	//异步获取规格参数
	var loadParameter = false;
	ec.product.getParameter = function (skuId) {
		if(loadParameter) return;
		
		new ec.ajax().get({
			url : ec.product.prefix + "/querySkuParameter.json?sid="+ skuId,
			successFunction : function(json){
				if(!json.success){
					return;
				}

				loadParameter  = true;
				var html = [],p;
				
				html.push("<div id='pro-tab-parameter-content-"+ skuId +"'><table border='0' cellpadding='0' cellspacing='0'><tbody>");
				var html0 = [];
				for ( var i = 0; i < json.specArgument.length; i++) {
					p = json.specArgument[i];
					var html1 = [];
					if((p.parentId==null || p.parentId=="") && (p.value==null || p.value=="")){
						html1.push("<tr><th colspan='2'><h3>" + p.name + "</h3></th></tr>");
						
						var pid = p.id;
						var html2 = [];
						for ( var j = 0; j < json.specArgument.length; j++) {
							var p2 = json.specArgument[j];
							if(p2.parentId!=null && p2.parentId!="" && p2.value!=null && p2.value!="" && p2.parentId == pid){
								html2.push("<tr><td class='p-name'>" + p2.name + "</td><td class='p-desc'>" + p2.value + "</td></tr>");
							}
						}
						if(html2.length>0){
							html0.push(html1.join(""));
							html0.push(html2.join(""));
						}
					}
					
					
				}
				
				if(html0.length>0){
					html.push(html0.join(""));
				}
				
				html.push("</tbody></table></div>");

				$("#pro-tab-parameter-content").append(html.join(""));
				$('#pro-tab-parameter-content-'+ (ec.product.setSkuId||skuId)).show().siblings().hide();

			}
		});
	};
	
	var _loadEvaluateSorce = function(){
		//用户评价得分
		if(loadEvaluate)
			return;

		_loadEvaluateScore();
		//用户评价列表
		_loadEvaluate({pageNumber : 1,type:-1});
		$("#pro-tab-evaluate-content").show();
	}

			var _window = $(window), _doc = document.compatMode == 'CSS1Compat' ? document.documentElement
					: document.body, _scrollTopSrart = 0, _scrollTopEnd = 0, _clientHeight, _timer,
			// 绑定事件
			_bindEvent = function() {

				var scrollEvent = function() {
					clearTimeout(_timer);
					_timer = setTimeout(function() {

						_scrollTopSrart = _window.scrollTop();
						_scrollTopEnd = _scrollTopSrart + _clientHeight;
						var img = $("#remarkLoading");
						var top = img.offset().top, pos = top + img.height();
						if (top >= _scrollTopSrart && top <= _scrollTopEnd) {
							_loadEvaluateSorce();
						}
					}, 100);
				},

				resizeEvent = function(event) {
					_clientHeight = _doc.clientHeight;
				};

				_window.bind("scroll", scrollEvent);
				_window.bind("resize", resizeEvent);

				_clientHeight = _doc.clientHeight;

				_scrollTopSrart = _window.scrollTop();
				_scrollTopEnd = _scrollTopSrart + _clientHeight;
			};
		
		var product = ec.product;
		// 不在页面打开就执行，滚动到页面最后才调用
		//_loadEvaluateSorce();
		_bindEvent();

		ec.ui.number("#pro-quantity", {
			max:999, 
			min:1,
			minusBtn : '<a href="javascript:;" class="icon-minus-2 vam" title="减"><span>-</span></a>',
			plusBtn : '<a href="javascript:;" class="icon-plus-2 vam" title="加"><span>+</span></a>'
		});

		//点击 全部评论 好评 中评 差评 进行分类帅选
		$("#pro-evaluate-click-all , #pro-evaluate-click-high , #pro-evaluate-click-mid , #pro-evaluate-click-low").click(function(){
			var thix = $(this) ,
			id = this.id ;
			thix.addClass("current").siblings().removeClass("current");
			switch(id)
			{
				case "pro-evaluate-click-all":
					_loadEvaluate({pageNumber : 1,type:-1});
					break;
				case "pro-evaluate-click-high":
					_loadEvaluate({pageNumber : 1,type:0});
					break;
				case "pro-evaluate-click-mid":
					_loadEvaluate({pageNumber : 1,type:1});
					break;
				case "pro-evaluate-click-low":
					_loadEvaluate({pageNumber : 1,type:2});
					break;
			}
		});
		
		//延保、意外保鼠标悬停事件
		$("#extendProtected,#accidentProtected").hover(function(){
			$(this).addClass("hover");
		},function(){
			$(this).removeClass("hover");
		});

	$("#pro-tab-feature , #pro-tab-parameter , #pro-tab-package , #pro-tab-service , #pro-tab-software , #pro-tab-evaluate").click(function(){
		
		var thix = $(this) ,
			id = this.id ;
		
		switch(id)
		{
			case "pro-tab-feature":
			case "pro-tab-package":
			case "pro-tab-service":
				break;
			case "pro-tab-parameter":
				//获取规格参数列表
				var skuList = thix.attr('data-skulist').split(',');
				for(var i=0; i<skuList.length; i+=1){
					if(skuList[i] > 0)
					ec.product.getParameter(skuList[i]);
				}
				break;

			case "pro-tab-evaluate":
			{
				//用户评价得分
				if(loadEvaluate)break;
				
				_loadEvaluateScore();
				//用户评价列表
				_loadEvaluate({pageNumber : 1});
				break;
			}
			case "pro-tab-software" : 
			{
				var iframe =  gid("pro_software_iframe");
				iframe.src=iframe.getAttribute("data-src");
				break;
			}
			//case end
		}
		thix.addClass("current").siblings().removeClass("current");
		$("#" + id +"-content").show().siblings().hide();
		ec.ui.scrollTo("#" + id +"-content");
		$("#pro-tab-evaluate-content").show();
	});

	//加载最近浏览历史
	product.history.load(function(list){
		if(list.length == 0)
		{
			return;
		}

		var html = [] , p;
		for(var i = 0 ; i < list.length ; i++)
		{
			p = list[i];
			p.price = (p.priceMode == 2) ? '<em>暂无报价</em>' : '<b>&yen;'+p.price+'</b>';
			html.push('<li><div>');
            html.push('<p class="p-img"><a href="/product/'+p.id+'.html#'+ p.skuId +'" title="'+p.briefName+'"><img src="'+ec.mediaPath+p.photoPath+'60_60_'+p.photoName+'" alt="'+p.briefName+'"/></a></p>');
            html.push('<p class="p-name"><a href="/product/'+p.id+'.html#'+ p.skuId +'" title="'+p.briefName+'">'+p.name+'</a></p>');
            html.push('<p class="p-price">'+p.price+'</p>');
            html.push('</div></li>');
		}
		$("#product-history-list").html(html.join(""));
		$("#product-history-area").show();
	} , null , ec.product.isSale ? null : ec.product.id);

	//显示默认的组合套餐
	product.renderGroup(product.setSkuId || product.defaultSku);

	var comb_timer;
	//优惠套装的tab
	$("#bundle-tab li").mouseover(function(){
		var thix = $(this);
		thix.addClass("current").siblings().removeClass("current");
		product.showBundle(thix.attr("data-id"));
	});

	//显示默认的优惠套装
	product.renderBundle(product.setSkuId || product.defaultSku);

	//选中推荐配件
	$("#comb-pro-area input").click(function(){
		var thix = $(this),
			//ct = thix.parent().parent(),
			count = parseInt($("#comb-count").html() ,10) || 0,
			price = parseFloat($("#comb-price").html()) || 0;

		if(this.checked)
		{
			//ct.addClass("selected");
			price += parseFloat(thix.attr("data-price"));
			count++;
		}else{
			//ct.removeClass("selected");
			price -= parseFloat(thix.attr("data-price"));
			count--;
		}

		$("#comb-price").html(price.toFixed(2));
		$("#comb-count").html(count);
	});

	new ec.ajax().get({
		url : ec.remark.prefix + "/queryPrdinfoEvaluateScore.json?pid="+ec.product.id + "&t=" + new Date().getTime(),
		dataType : "jsonp",
		successFunction : function(json){
			$("#prd-remark-scoreAverage").attr("style", "width:" + (json.prdRemarkNum.scoreAverage * 20) + "%");
			$("#prd-remark-scoreAverage").show();
			
			$("#prd-remark-jmptoremark").attr("title", "共&nbsp;" + json.prdRemarkNum.totalPrdCount + "&nbsp;条评论");
			$("#prd-remark-jmptoremark").html("共&nbsp;" + json.prdRemarkNum.totalPrdCount + "&nbsp;条评论");
			$("#prd-remark-jmptoremark").show();
			
			$("#prd-remark-span-tab-evaluate").html("用户评价<em>（" + json.prdRemarkNum.totalPrdCount + "）</em>");
			$("#prd-remark-span-tab-evaluate").show();
		}
	});
		
	
	//合约机	
	var sku = ec.product.getSku();
	sku = ec.product.getSkuInfo(sku);
	
	ec.product.initContract(sku);

	//延保
	ec.form.input.label('#extend-text','输入IMEI/SN/MEID信息');
	
});
ec.product.divchange=function(data)
{
	if(data==1)
	{
		$("#prddetail_counsel_all").show();
		$("#prddetail_counsel_prd").hide();
		$("#prddetail_counsel_pay").hide();
		$("#prddetail_counsel_trans").hide();
		$("#prddetail_counsel_service").hide();
		$("#prddetail_counsel_ques").hide();
		$("#prd_detail_counsel_2").removeAttr('class');
		$("#prd_detail_counsel_3").removeAttr('class');
		$("#prd_detail_counsel_4").removeAttr('class');
		$("#prd_detail_counsel_5").removeAttr('class');
		$("#prd_detail_counsel_6").removeAttr('class');
		$("#prd_detail_counsel_1").attr('class','current');
	}else if(data==2)
	{
		$("#prddetail_counsel_all").hide();
		$("#prddetail_counsel_prd").show();
		$("#prddetail_counsel_pay").hide();
		$("#prddetail_counsel_trans").hide();
		$("#prddetail_counsel_service").hide();
		$("#prddetail_counsel_ques").hide();
		$("#prd_detail_counsel_1").removeAttr('class');
		$("#prd_detail_counsel_3").removeAttr('class');
		$("#prd_detail_counsel_4").removeAttr('class');
		$("#prd_detail_counsel_5").removeAttr('class');
		$("#prd_detail_counsel_6").removeAttr('class');
		$("#prd_detail_counsel_2").attr('class','current');
		ec.product.counselloadprd({"pageNumber": 1});
	}else if(data==3)
	{
		$("#prddetail_counsel_all").hide();
		$("#prddetail_counsel_prd").hide();
		$("#prddetail_counsel_pay").show();
		$("#prddetail_counsel_trans").hide();
		$("#prddetail_counsel_service").hide();
		$("#prddetail_counsel_ques").hide();
		$("#prd_detail_counsel_1").removeAttr('class');
		$("#prd_detail_counsel_2").removeAttr('class');
		$("#prd_detail_counsel_4").removeAttr('class');
		$("#prd_detail_counsel_5").removeAttr('class');
		$("#prd_detail_counsel_6").removeAttr('class');
		$("#prd_detail_counsel_3").attr('class','current');	
		ec.product.paycounselload({"pageNumber": 1});
		//ec.product.paycounselload(page);
	}else if(data==4)
	{
		$("#prddetail_counsel_all").hide();
		$("#prddetail_counsel_prd").hide();
		$("#prddetail_counsel_pay").hide();
		$("#prddetail_counsel_trans").show();
		$("#prddetail_counsel_service").hide();
		$("#prddetail_counsel_ques").hide();
		$("#prd_detail_counsel_2").removeAttr('class');
		$("#prd_detail_counsel_3").removeAttr('class');
		$("#prd_detail_counsel_1").removeAttr('class');
		$("#prd_detail_counsel_5").removeAttr('class');
		$("#prd_detail_counsel_6").removeAttr('class');
		$("#prd_detail_counsel_4").attr('class','current');	
		ec.product.transcounselload({"pageNumber": 1});
		//ec.product.transcounselload(page);
	}
	else if(data==5)
	{
		$("#prddetail_counsel_all").hide();
		$("#prddetail_counsel_prd").hide();
		$("#prddetail_counsel_pay").hide();
		$("#prddetail_counsel_trans").hide();
		$("#prddetail_counsel_service").show();
		$("#prddetail_counsel_ques").hide();
		$("#prd_detail_counsel_1").removeAttr('class');
		$("#prd_detail_counsel_3").removeAttr('class');
		$("#prd_detail_counsel_4").removeAttr('class');
		$("#prd_detail_counsel_2").removeAttr('class');
		$("#prd_detail_counsel_6").removeAttr('class');
		$("#prd_detail_counsel_5").attr('class','current');
		ec.product.sercounselload({"pageNumber": 1});
		//ec.product.sercounselload(page);
	}
	else
	{
		$("#prddetail_counsel_all").hide();
		$("#prddetail_counsel_prd").hide();
		$("#prddetail_counsel_pay").hide();
		$("#prddetail_counsel_trans").hide();
		$("#prddetail_counsel_service").hide();
		$("#prddetail_counsel_ques").show();
		$("#prd_detail_counsel_1").removeAttr('class');
		$("#prd_detail_counsel_3").removeAttr('class');
		$("#prd_detail_counsel_4").removeAttr('class');
		$("#prd_detail_counsel_5").removeAttr('class');
		$("#prd_detail_counsel_2").removeAttr('class');
		$("#prd_detail_counsel_6").attr('class','current');
		ec.product.quescounselload({"pageNumber": 1});
		//ec.product.quescounselload(page);
	}
	};
	ec.product.counselloadall = function(page) {
		new ec.ajax()
		.submit({
			url : "/product/query/consultation/"+ec.product.id+".json",
			data : {
				"prdId":ec.product.id,
				"dataType" : 0,
				"pageNumber" : page.pageNumber,
				"pageSize" : 5
			},
			timeout : 10000,
			timeoutFunction : function() {
				alert("读取超时，请重试！");
			},
			successFunction : function(json) {
				if (!json.success) {
					ec.showError(json);
					return;
				}
				var html=[];
				html=ec.product.createcounselhtml(json);
				// 无评论的时候隐藏掉外面的虚线框

				$("#all_prd_counsel_content").html(html.join(""));
				ec.product.allrenderPage(json.page);
			}
		});
	};
	ec.product.allrenderPage = function(page) {
				$("#all_prd_counsel").show();
				$("#all_prd_counsel").pager({
					pageNumber : page.pageNumber,
					pageCount : page.totalPage,
					pageSize : 5,
					text : {
						first : "|&lt;",
						pre : "&lt",
						next : "&gt;",
						last : "&gt;|"
					},
				item : [ "first", "pre", "qpage", "next", "last", "quickPager" ],// 显示样式
				callBack : ec.product.counselloadall
				});
	};

	ec.product.counselloadprd = function(page) {
		new ec.ajax()
		.submit({
			url : "/product/query/consultation/"+ec.product.id+".json",
			data : {
				"prdId":ec.product.id,
				"dataType" : 1,
				"pageNumber" : page.pageNumber,
				"pageSize" : 5
			},
			timeout : 10000,
			timeoutFunction : function() {
				alert("读取超时，请重试！");
			},
			successFunction : function(json) {
				if (!json.success) {
					ec.showError(json);
					return;
				}
				var html=[];
				html=ec.product.createcounselhtml(json);
				// 无评论的时候隐藏掉外面的虚线框

				$("#prd_prd_counsel_content").html(html.join(""));
				if(json.page.totalRow>0)
				{
				$("#prddetail_counsel_prd_total em").html(json.page.totalRow);
				}else
				{
					$("#prddetail_counsel_prd_total").hide();
				}
				ec.product.prdrenderPage(json.page);
			}
		});
	};
	ec.product.prdrenderPage = function(page) {
				$("#prd_prd_counsel").show();
				$("#prd_prd_counsel").pager({
					pageNumber : page.pageNumber,
					pageCount : page.totalPage,
					pageSize : 5,
					text : {
						first : "|&lt;",
						pre : "&lt",
						next : "&gt;",
						last : "&gt;|"
					},
				item : [ "first", "pre", "qpage", "next", "last", "quickPager" ],// 显示样式
				callBack : ec.product.counselloadprd
				});
	};
	ec.product.paycounselload = function(page) {
		new ec.ajax()
		.submit({
			url : "/product/query/consultation/"+ec.product.id+".json",
			data : {
				"prdId":ec.product.id,
				"dataType" : 2,
				"pageNumber" : page.pageNumber,
				"pageSize" : 5
			},
			timeout : 10000,
			timeoutFunction : function() {
				alert("读取超时，请重试！");
			},
			successFunction : function(json) {
				if (!json.success) {
					ec.showError(json);
					return;
				}
				var html=[];
				html=ec.product.createcounselhtml(json);
				// 无评论的时候隐藏掉外面的虚线框

				$("#pay_prd_counsel_content").html(html.join(""));
				if(json.page.totalRow>0)
				{
					$("#prddetail_counsel_pay_total em").html(json.page.totalRow);
				}
				else
				{
					$("#prddetail_counsel_pay_total").hide();
				}
				ec.product.payrenderPage(json.page);
			}
		});
	};
	ec.product.payrenderPage = function(page) {
				$("#pay_prd_counsel_page").show();
				$("#pay_prd_counsel_page").pager({
					pageNumber : page.pageNumber,
					pageCount : page.totalPage,
					pageSize : 5,
					text : {
						first : "|&lt;",
						pre : "&lt",
						next : "&gt;",
						last : "&gt;|"
					},
				item : [ "first", "pre", "qpage", "next", "last", "quickPager" ],// 显示样式
				callBack : ec.product.paycounselload
				});
	};
	ec.product.transcounselload = function(page) {
		new ec.ajax()
		.submit({
			url : "/product/query/consultation/"+ec.product.id+".json",
			data : {
				"prdId":ec.product.id,
				"dataType" : 3,
				"pageNumber" : page.pageNumber,
				"pageSize" : 5
			},
			timeout : 10000,
			timeoutFunction : function() {
				alert("读取超时，请重试！");
			},
			successFunction : function(json) {
				if (!json.success) {
					ec.showError(json);
					return;
				}
				var html=[];
				html=ec.product.createcounselhtml(json);
				// 无评论的时候隐藏掉外面的虚线框

				$("#trans_prd_counsel_content").html(html.join(""));
				if(json.page.totalRow>0){
				$("#prddetail_counsel_trans_total em").html(json.page.totalRow);
				}else
				{
					$("#prddetail_counsel_trans_total").hide();
				}
				ec.product.transrenderPage(json.page);
			}
		});
	};
	ec.product.transrenderPage = function(page) {
				$("#trans_prd_counsel_page").show();
				$("#trans_prd_counsel_page").pager({
					pageNumber : page.pageNumber,
					pageCount : page.totalPage,
					pageSize : 5,
					text : {
						first : "|&lt;",
						pre : "&lt",
						next : "&gt;",
						last : "&gt;|"
					},
				item : [ "first", "pre", "qpage", "next", "last", "quickPager" ],// 显示样式
				callBack : ec.product.transcounselload
				});
	};
	ec.product.sercounselload=function(page) {
		new ec.ajax()
		.submit({
			url : "/product/query/consultation/"+ec.product.id+".json",
			data : {
				"prdId":ec.product.id,
				"dataType" : 4,
				"pageNumber" : page.pageNumber,
				"pageSize" : 5
			},
			timeout : 10000,
			timeoutFunction : function() {
				alert("读取超时，请重试！");
			},
			successFunction : function(json) {
				if (!json.success) {
					ec.showError(json);
					return;
				}
				var html=[];
				html=ec.product.createcounselhtml(json);
				// 无评论的时候隐藏掉外面的虚线框

				$("#ser_prd_counsel_content").html(html.join(""));
				if(json.page.totalRow>0){
				$("#prddetail_counsel_serv_total em").html(json.page.totalRow);
				}else{
					$("#prddetail_counsel_serv_total").hide();
				}
				ec.product.serrenderPage(json.page);
			}
		});
	};
	ec.product.serrenderPage=function(page) {
		$("#ser_prd_counsel_page").show();
		$("#ser_prd_counsel_page").pager({
			pageNumber : page.pageNumber,
			pageCount : page.totalPage,
			pageSize : 5,
			text : {
				first : "|&lt;",
				pre : "&lt",
				next : "&gt;",
				last : "&gt;|"
			},
		item : [ "first", "pre", "qpage", "next", "last", "quickPager" ],// 显示样式
		callBack : ec.product.sercounselload
		});
	};
	ec.product.quescounselload=function(page) {
		new ec.ajax()
		.submit({
			url : "/product/query/frequentyQuestions/"+ec.product.id+".json",
			data : {
				"prdId":ec.product.id,
				"pageNumber" : page.pageNumber,
				"pageSize" : 10
			},
			timeout : 10000,
			timeoutFunction : function() {
				alert("读取超时，请重试！");
			},
			successFunction : function(json) {
				if (!json.success) {
					ec.showError(json);
					return;
				}
				var html=[];
				if(json.page.totalRow>0){
					for(var i=0;i<json.prdFrequentyQuestionsList.length;i++)
					{
						var p=json.prdFrequentyQuestionsList[i];
						html.push('<dl class="pro-faq-item"><dt>'+((page.pageNumber-1)*10+i+1)+'、'+p.question+'</dt>');
						html.push('<dd>'+p.reply+'</dd></dl>');
					}
				}else
				{
					html.push('<div class="pro-inquire-empty"><p>暂无相关内容</p></div>');
				}
				$("#ques_prd_counsel_content").html(html.join(""));
				
				if(json.page.totalRow>0)
				{
					$("#prddetail_counsel_ques_total em").html(json.page.totalRow);
				}else
				{
					$("#prddetail_counsel_ques_total").hide();
				}
				ec.product.quesrenderPage(json.page);
			}
		});
	};
	ec.product.quesrenderPage=function(page) {
		$("#ques_prd_counsel_page").show();
		$("#ques_prd_counsel_page").pager({
			pageNumber : page.pageNumber,
			pageCount : page.totalPage,
			pageSize : 10,
			text : {
				first : "|&lt;",
				pre : "&lt",
				next : "&gt;",
				last : "&gt;|"
			},
		item : [ "first", "pre", "qpage", "next", "last", "quickPager" ],// 显示样式
		callBack : ec.product.quescounselload
		});
	};
	ec.product.createcounselhtml=function(json)
	{
		var html=[];
		if(json.page.totalRow>0){
		for ( var i = 0; i < json.prdConsultationList.length; i++) {
			p = json.prdConsultationList[i];		
			//var grade = p.gradeCode == null ? 0 : p.gradeCode;
			var username=p.userName;
			var gradecode=p.gradeCode;
			var date = new Date(p.createTime);
			var answerdate = new Date(p.answerTime);
			html.push('<div class="pro-inquire-item clearfix">');//pro-comment-item start
			
			//用户信息
			html.push('<div class="pro-inquire-user"><label>网友：</label><span>'+username+'</span>');		
			html.push('<s><i class="icon-vip-level-'+gradecode+'"></i></s>');
			html.push('<em>'+date.format("yyyy-MM-dd HH:mm:ss")+'</em>');
			html.push('</div><div class="pro-inquire-question">');
					
			html.push('<label>咨询内容：</label><span>'+ec.util.escapeHtml(p.question)+'</span></div>');//pro-user-comment-main start
			
			html.push('<div class="pro-inquire-answer"><label>回复：</label><span>'+ec.util.escapeHtml(p.answer)+'</span>');
			html.push('<em>'+answerdate.format("yyyy-MM-dd HH:mm:ss")+'</em></div>');
			html.push('</div>');			
		}
		}else
		{
			html.push('<div class="pro-inquire-empty"><p>暂无相关内容</p></div>');
		}
		return html;
	};
	ec.product.loginCheckBefCoun=function()
	{
		if (!ec.account.isLogin()) {
			ec.account.afterLogin(function() {
				$("#counseltextid").focus();
				$("#error-span").hide();
			});
		} 
		else
		{
			$("#counseltextid").focus();
			$("#error-span").hide();
		}
	};
	ec.product.submitCounsel=function()
	{
		var text=$("#counseltextid").val();
		if(text==null||text.length<10)
		{
		    $("#error-span").show();
		    $("#error-span").html("输入的文字长度不能少于10个字,请重新输入");
			return;
		}
		if(text.length>100)
		{
			$("#error-span").show();
		    $("#error-span").html("输入的文字长度不能超过100个字,请重新输入");
			return;
		}
		new ec.ajax().submit({
			url: "/product/save/consultation.json", 
			form:"#counsel_content_form",
			data:{"productId":ec.product.id},
		    successFunction:function(json)
		    { 
		    	if(!json.success){
		    		$("#error-span").show();
				    $("#error-span").html(json.msg);
		    	}else
		    	{
		    		alert("提交成功,请耐心等待客服人员的答复！");
		    		$("#counsel_content_form")[0].reset();
		    		$("#error-span").hide();
		    		return;
		    	}
		    }});
	};
	
	ec.product.combChange=function(data)
	{
		//获取选择的是 推荐配置几 模块
		var currentLi=$(data).parent();
		//将选择的推荐配置加上  当前   类型
		currentLi.addClass("current");
		//将除了当前选择的配置以外的所有其它推荐配置删除  选中 类型
		currentLi.siblings().not(currentLi).removeClass("current");
		//获取推荐配置的数据div的id
		var ulId=currentLi.parent().attr("id");
		//截取字符串，获取skuID
		var  skuId=ulId.substring(14,ulId.length);
		//获取选取的推荐配置几
		var index=currentLi.index();
		//显示推荐配置的具体数据div模块

		var cuttentDivs=  $('[id="comb-pro-'+skuId+'"]');
                   
                 var cuttentDiv=cuttentDivs.eq(index);
		cuttentDiv.show();
		cuttentDiv.siblings().not(cuttentDiv).hide();
	};