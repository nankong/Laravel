/**
 * Last  Update:2012-1-22
 */

ec.debug = false;

ol.load.define("jquery" , [{mark:"jquery",uri: "base/jquery-1.4.4.min.js",type: "js"}]);
ol.load.define("jquery.form" , ["jquery",{mark:"jquery.form",uri: "base/jquery.form-2.49.js",type: "js",	charset: "utf-8",depend:true}]);
ol.load.define("jquery.bgiframe" , [{mark:"jquery.bgiframe",uri: "base/jquery.bgiframe.min.js",type: "js",	charset: "utf-8",depend:true,loadType:"lazy"}]);
ol.load.define("jquery.autocomplete" , [{mark:"jquery.autocomplete",uri: "jquery.autocomplete/jquery.autocomplete.hack-min.js",type: "js",	charset: "utf-8",depend:true}]);
ol.load.define("My97DatePicker" , [{mark:"My97DatePicker",uri: "My97DatePicker/WdatePicker.js",type: "js",charset: "utf-8",depend:false , onload : function(){
	WdatePicker();
}}]);

ol.load.define("uploadify" , [
	"jquery",
	"swfobject",
	{uri: "uploadify/jquery.uploadify.v2.1.4.min.js",type:"js",depend:true},
	{uri: "uploadify/uploadify.customize.css",type:"css"}
]);
ol.load.define("ec.pager" , [
	"jquery",
	{uri: "ec.pager/pager-min.js",type:"js",charset: "gbk",depend:true}
]);
ol.load.define("ajax" , [
	"jquery.form",
	{mark:"ajax",uri: "base/ajax.js",type: "js",	charset: "utf-8",depend:true}
]);
ol.load.define("ajaxcdr" , [
	"jquery.form",
	{mark:"ajaxcdr",uri: "base/ajaxcdr.js?20121031",type: "js",	charset: "utf-8",depend:true}
]);
ol.load.define("ec.box" , [
	"jquery",
	{mark:"jquery.bgiframe",uri: "base/jquery.bgiframe.min.js",type: "js",charset: "utf-8",depend:true,loadType:null},
	{uri: "ec.box/box-min.js",type: "js",depend:true}
]);
ol.load.define("ec.tab" , [
	"jquery",
	{uri: "ec.tab/tab-min.js",type: "js",charset:"utf-8",depend:true}
]);

ol.load.define("jquery.float" , [
	"jquery",
	{uri: "jquery.float/float-min.js",type: "js",charset:"gbk",depend:true}
]);

ol.load.define("cloud-zoom" , [
	{uri : "cloud-zoom.1.0.2/cloud-zoom.1.0.2-hack-min.js" , type :"js"}
]);
ol.load.define("jqzoom" , [
	"jquery",
	{uri : "jqzoom-2.3/js/jquery.jqzoom-core.js" , type :"js", depend:true},
	{uri : "jqzoom-2.3/css/jquery.jqzoom.css", type : "css"}
]);


ol.load.define("RaterStar" , [
	{uri : "RaterStar/rater-star.js" , type :"js"}
]);

ol.load.define("ec.slider" , [
	{uri : "ec.slider/slider-min.js" , type :"js"}
]);

ol.load.define("ec.linkSelect.region" , [
	"jquery",
	{uri: "linkSelect/region-min.js",type: "js",charset:"utf-8",depend:true}
]);
ol.load.define("ec.md5" , [
	{uri: "md5/md5-min.js",type: "js"}
]);
ol.load.define("jquery.rotate" , [
	"jquery",
	{uri: "jquery.rotate/jQueryRotate-min.js",type: "js"}
]);
ol.load.define("jquery.fixed" , [
	"jquery",
	{uri: "jquery.fixed/fixed.js",type: "js"}
]);
if(jQuery)
{
	ol._setLoadStatus("jquery" , "complete");
}


window["_gaq"] = window["_gaq"] || [];
_gaq.push(['_setAccount', (ec.debug ? '' : "UA-28046633-2"),'t1']);

var _hmt = _hmt || [];
var _paq = _paq || [];
var _zpq = _zpq || [];

window._bd_share_config = {};
ec.code = {
	//baidu分享
	addShare : function(options){
		options = $.extend({
			//type : "tools",
			//lazy : true,
			jsUrl : "http://bdimg.share.baidu.com/static/api/js/share.js?v=86835285.js?cdnversion="+~(-new Date()/36e5)
		} , options);
		//document.write('<script type="text/javascript" id="bdshare_js" data="type='+options.type+'&amp;uid=4505950" ></s' + 'cript>');
		window._bd_share_config = options;
		ec.ready(function(){
			with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src=options.jsUrl];
		});
		
	},
	addAnalytics:function(options){
		
		options = options || {
			google : true,
			cnzz : true,
			baidu : true,
			click99 : true,
			hicloud : true,
			suning : true,
			operate:false 
		};
		//不需要统计的页面地址列表
		var filterList = [
				'/payment/alipay/returnURL',
				'/order/feedBack'
			],
			locationHref = location.href;

		for (var i=0; i< filterList.length; i+=1){
			if (locationHref.indexOf(filterList[i]) > 0) return;
		}

		//_gaq.push(['_setDomainName', '.vmall.com']);
		//_gaq.push(['_setVisitorCookieTimeout', 157680000000]);
		_gaq.push(['_trackPageview']);
		_gaq.push(['_trackPageLoadTime']);
		_gaq.push(['_addOrganic', 'baidu', 'word']);
		_gaq.push(['_addOrganic', 'baidu', 'kw']);
		_gaq.push(['_addOrganic', 'opendata.baidu', 'wd']);
		_gaq.push(['_addOrganic', 'zhidao.baidu', 'word']);
		_gaq.push(['_addOrganic', 'news.baidu', 'word']);
		_gaq.push(['_addOrganic', 'post.baidu', 'kw']);
		_gaq.push(['_addOrganic', 'tieba.baidu', 'kw']);
		_gaq.push(['_addOrganic', 'mp3.baidu', 'word']);
		_gaq.push(['_addOrganic', 'image.baidu', 'word']);
		_gaq.push(['_addOrganic', 'top.baidu', 'word']);
		_gaq.push(['_addOrganic', 'news.google', 'q']);
		_gaq.push(['_addOrganic', 'soso', 'w']);
		_gaq.push(['_addOrganic', 'image.soso', 'w']);
		_gaq.push(['_addOrganic', 'music.soso', 'w']);
		_gaq.push(['_addOrganic', 'post.soso', 'kw']);
		_gaq.push(['_addOrganic', 'wenwen.soso', 'sp']);
		_gaq.push(['_addOrganic', 'post.soso', 'kw']);
		_gaq.push(['_addOrganic', '3721', 'name']);
		_gaq.push(['_addOrganic', '114', 'kw']);
		_gaq.push(['_addOrganic', 'youdao', 'q']);
		_gaq.push(['_addOrganic', 'vnet', 'kw']);
		_gaq.push(['_addOrganic', 'sogou', 'query']);
		_gaq.push(['_addOrganic', 'news.sogou', 'query']);
		_gaq.push(['_addOrganic', 'mp3.sogou', 'query']);
		_gaq.push(['_addOrganic', 'pic.sogou', 'query']);
		_gaq.push(['_addOrganic', 'blogsearch.sogou', 'query']);
		_gaq.push(['_addOrganic','gougou', 'search']);	
		

		//suning
		var honor3 = (locationHref.indexOf('/product/678.html') > 0) ? true : false;
		_zpq.push(['_setPageID', (!honor3) ? '100' : '101']);
		_zpq.push(['_setPageType', (!honor3) ? 'home' : 'honor3']);
		_zpq.push(['_setParams','']);
		_zpq.push(['_setAccount','95']);

		if(options.google)ec.load({url:"http://www.google-analytics.com/ga.js",type:"js",loadType:"lazy"});
		if(options.baidu)ec.load({url:"http://hm.baidu.com/h.js?a08b68724dd89d23017170634e85acd8",type:"js",loadType:"lazy"});
		if(options.cnzz)ec.load({url : "http://s95.cnzz.com/stat.php?id=4754392&web_id=4754392",type:"js",loadType:"lazy"});
		//if(options.click99)ec.load({ type : "js" , uri : "../echannel/99click.js" , loadType : "lazy"});
		if(options.suning)ec.load({url:"http://cdn.zampda.net/s.js", type:"js", loadType : "lazy"});

		if(options.hicloud)
		{
			_paq.push(['setTrackerUrl', 'http://datacollect.vmall.com:28080/webv1']);
			
			//获取订单ID并转换为字符串类型，注意：只支持字符串类型
			var orderCode = ((ec.order && ec.order.orderCode) ? ec.order.orderCode : "")+ '';
			//log(orderId);
			// 分配的site id
			_paq.push(['setSiteId', "www.vmall.com"]);
			// 上报自定义数据
			_paq.push(['setCustomVariable',1, 'cid', (ec.util.cookie.get("cps_id") || ""), 'page']);
			_paq.push(['setCustomVariable',2, 'direct', (ec.util.cookie.get("cps_direct") || ""), 'page']);
			_paq.push(['setCustomVariable',3, 'orderid', orderCode, 'page']);
			_paq.push(['setCustomVariable',4, 'wi', (ec.util.cookie.get("cps_wi") || ""), 'page']);
			_paq.push(['setCustomVariable',1, 'uid', ((ec.util.cookie.get("uid") ? ec.util.cookie.get("uid") : "") || ""), 'visit']);
			_paq.push(['setCustomVariable',10, 'uid', ((ec.util.cookie.get("uid") ? ec.util.cookie.get("uid") : "") || ""), 'visit']);
			// 跟踪网页浏览
			_paq.push(['trackPageView']);
			
			ec.load({url : "http://res.vmall.com/bi/hianalytics.js" , type:"js",loadType:"lazy"});
			ec.util.cookie.remove("cps_direct");
		}
		//采集加入购物车和删除购物车的行为
		//是不是加入购物车或者删除购车上商品的行为进行判断
		if(options.operate){
			_paq.push(['setTrackerUrl', 'http://datacollect.vmall.com:28080/webv1']);
			
			//获取订单ID并转换为字符串类型，注意：只支持字符串类型
			var orderCode = ((ec.order && ec.order.orderCode) ? ec.order.orderCode : "")+ '';
			//log(orderId);
			// 分配的site id
			_paq.push(['setSiteId', "www.vmall.com"]);
			// 上报自定义数据
			_paq.push(['setCustomVariable',1, 'cid', (ec.util.cookie.get("cps_id") || ""), 'page']);
			_paq.push(['setCustomVariable',2, 'direct', (ec.util.cookie.get("cps_direct") || ""), 'page']);
			_paq.push(['setCustomVariable',3, 'orderid', orderCode, 'page']);
			_paq.push(['setCustomVariable',4, 'wi', (ec.util.cookie.get("cps_wi") || ""), 'page']);
			_paq.push(['setCustomVariable',1, 'uid', ((ec.util.cookie.get("uid") ? ec.util.cookie.get("uid") : "") || ""), 'visit']);
			_paq.push(['setCustomVariable',10, 'uid', ((ec.util.cookie.get("uid") ? ec.util.cookie.get("uid") : "") || ""), 'visit']);
			var operData = "";
			operData = ec.code.convertFormat(options.optype,options.skuIds,options.bundleIds,options.custSkuIds,options.custBundleIds);
			_paq.push(['setCustomVariable',10, 'cart', operData, 'page']);
			_paq.push(['trackGoal',1]);
			
		}
	}
};

//把商品sku_id,bundle_id组合成一个格式化的数据，传给BI
/*对operData的格式说明一下 operData:operType,0_id:0_id:1_id
 * 第一个逗号前的是操作类型，1代表添加，0代表删除
 * 逗号后面的字符串0_id，表示套餐类id
 * 1_id表示单品类  后面是商品id
 * 2_id表示新捆绑套餐/自选套餐ID
 * 3_id表示新捆绑套餐/自选套餐对应的商品ID
 */
ec.code.convertFormat = function(optype,skuIds,bundleIds,custSkuIds,custBundleIds){
	
	var _result = "";
	var _skuIds = [];
	var _bundleIds =[];
	var _custSkuIds = [];
	var _custBundleIds = [];
	
	//判断是不是数组单品id
	if(ec.util.isArray(skuIds)){
		_skuIds = $.map(skuIds,function(ele){
			return "1_"+ele;
		});
	}
	
	//判断套餐id
	if(ec.util.isArray(bundleIds)){
		_bundleIds = $.map(bundleIds,function(ele){
			return "0_"+ele;
		});
	}
	
	//判断新捆绑套餐商品id
	if(ec.util.isArray(custSkuIds)){
		_custSkuIds = $.map(custSkuIds,function(ele){
			return "3_"+ele;
		});
	}
	
	//判断新捆绑套餐id
	if(ec.util.isArray(custBundleIds)){
		_custBundleIds = $.map(custBundleIds,function(ele){
			return "2_"+ele;
		});
	}
	
	//把四个数组合并起来
	_skuIds = _bundleIds.concat(_skuIds,_custBundleIds,_custSkuIds);
	
	//拼接成我们所要的格式
	_result = optype + "," + _skuIds.join(":");
	
	return _result;
	
};

//保存cps信息到cookie
ec.code.saveCpsInfoToCookie = function(){
	var cid = ec.code.getCPSInfoFromUrl(location.href, "cid");
	var wi = ec.code.getCPSInfoFromUrl(location.href, "wi");
	
	//cid为0到10位数字
	if(cid.length < 0 || cid.lenght > 11){
		return;
	}
	
	var regText = /^\d+$/;
	if(!regText.test(cid)){
		return;
	}
	
	ec.util.cookie.remove("cps_id");
	ec.util.cookie.remove("cps_wi");
	ec.util.cookie.set("cps_id", cid, {"expires": 10, "domain":".vmall.com"});
	ec.util.cookie.set("cps_direct", "1", {"expires": 10, "domain":".vmall.com"});

	//wi为0-200位
	if(wi.length > 0 && wi.length < 200){
		ec.util.cookie.set("cps_wi", wi, {"expires": 10, "domain":".vmall.com"});
	}
};

//从url获取cps信息
ec.code.getCPSInfoFromUrl = function(url, name) {
    // 如果链接没有参数，或者链接中不存在我们要获取的参数，直接返回空 
    if (url.indexOf("#") == -1 || url.indexOf(name + '=') == -1) {
        return '';
    }
    // 获取链接中参数部分 
    var queryString = url.substring(url.indexOf("#") + 1);
    
    //解决可能出现多个问号的情况 例如：http://www.vmall.com/?vmallFlag=login#?cid=6569
    var parmSegments = queryString.split("#");
    
    for(var i = 0; i < parmSegments.length; i++){
    	var tempStr = parmSegments[i];
    	
    	// 分离参数对 ?key=value&key2=value2 
        var parameters = tempStr.split("&");
        var pos, paraName, paraValue;
        for (var j = 0; j < parameters.length; j++) {
            // 获取等号位置 
            pos = parameters[j].indexOf('=');
            if (pos == -1) {
                continue;
            }
            // 获取name 和 value 
            paraName = parameters[j].substring(0, pos);
            paraValue = parameters[j].substring(pos + 1);
     
            if (paraName == name) {
                return unescape(paraValue.replace(/\+/g, " "));
            }
        }
    }
    return '';
};

//在线客服 & 右侧工具条
ec.code.addService = function(options){
	ec.load("jquery.float" , {
		loadType : "lazy",
		callback : function(){
			
			if(options.showService){
				var url = window.location.href;
				var index = url.indexOf("/product/");
				var urlInfo = "";
				var memo = "";
				if(index > 0) {                  // 如果进入明细页，则封装好明细信息
					urlInfo = url.substring(index + 9, url.length);
					
					if(urlInfo.length > 1) {
						var prdInfo = urlInfo.split('.html', 2);
						if(prdInfo.length > 1) {
							memo = prdInfo[0];
							var hash = prdInfo[1];
							if(hash.indexOf('#') >= 0) {
								var skuInfo = hash.split('#', 2)[1];
								var skuId = (skuInfo.length > 0) ? (skuInfo.split(',', 2)[0] || 0) : 0;
								
								if(skuId != 0) {
									memo = memo + "," + skuId;
								}
							}
						}						
					}
				}
				$("#tools-nav-service-robotim").attr("href" , "http://robotim.vmall.com/live800/chatClient/chatbox.jsp?companyID=8922&configID=10&enterurl="+encodeURIComponent(window.location.href)+"&k=1&remark="+encodeURIComponent(memo)).css('display','block');
				//$("#tools-nav-service-qq").css('display','block');
			}
			if(options.showTools){
				$("#tools-nav-survery").css('display','block');
			}
			if(options.showService || options.showTools) {
				$('#tools-nav')["float"]("mr").show();
			}
			//if(options.showTools)$("#tools-nav")["float"]("rb").show();
		}
	});
};

(function(){
	//保存cps信息到cookie
	ec.code.saveCpsInfoToCookie();
	
	var 
		_tracker,
		getTracker = function(){

			if(_tracker)return _tracker;

			_tracker = _gat._createTracker((ec.debug ? '' : "UA-28046633-3"),"t2");
			//_tracker._setDomainName('.vmall.com');
			//_tracker._setVisitorCookieTimeout(157680000000);

			return _tracker;
		};

	ec.track= function(path , retryTime){
		retryTime = retryTime || 3;
		try {
			if (window._gat && window._gat._createTracker) {
				if ("[object Array]" == Object.prototype.toString.apply(path)) {
					path = path.join("/")
				}
				getTracker()._trackPageview(path);
				log("Track", path)
			} else {
				if (retryTime > 0) {
					setTimeout(function() {
						ec.track(path , retryTime -1)
					},
					1000)
				}
			}
		} catch(c) {
			throw c
		}
	};

	ec.trackEvent = function(category , action , optional_label, optional_value , retryTime){
		retryTime = retryTime || 3;
		try {
			if (window._gat && window._gat._createTracker) {
				getTracker()._trackEvent(category , action , optional_label, optional_value);
				log("TrackEvent", category + " : " + action)
			} else {
				if (retryTime > 0) {
					setTimeout(function() {
						ec.trackEvent(category , action , optional_label, optional_value , retryTime -1)
					},
					1000)
				}
			}
		} catch(c) {
			throw c
		}
	};


})();

(function(){

	var source =  ec.util.cookie.get("cps_source"),
		channel = ec.util.cookie.get("cps_channel"),
		direct = ec.util.cookie.get("cps_direct");

	
	//跟踪cps引来的用户操作事件
	ec.trackCPS = function(action , optional_value){
		if(source && channel)ec.track(["/cps/event" , action , source+"/"+channel , optional_value]);
	};
	
	if(source && channel && direct)
	{
		ec.ready(function(){
			//跟踪cps的pv,uv
			ec.track("/cps/pv/" +source+"/"+channel +  location.pathname);
		});
	}
})();

//跟踪99click
ec.track99click = function(options)
{
	var _ozprm;
	if(typeof(options) == "string")
	{
		_ozprm = options;
	}else{
		
		var array = [] , v;
		for(var s in options)
		{
			v = options[s];
			array.push(s+"="+(ec.util.isArray(v) ? v.join(";") : v));
		}
		_ozprm = array.join("&");
	}

	ec.track99click._ozuid = ec.account.id;
	ec.track99click._ozprm = _ozprm;
}

