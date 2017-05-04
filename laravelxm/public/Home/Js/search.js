/**
 * 搜索
 * Last Update:2012-12-4
 */
ec.pkg("ec.search");
ec.load("ec.pager");
ec.load("ajax" , {loadType : "lazy"})

//排序字段
ec.search.sortField = "sale_number";
//排序方式
ec.search.sortType = "desc";
//关键字
ec.search.keyword;

ec.product.pageNumber = 1;

//排序
ec.search.sort = function(sortField){

	var 
		cur_sortField = ec.search.sortField,
		cur_sortType = ec.search.sortType,
		new_sortType;
	switch(sortField){
		case "sale_number" :
			$("#sort-sale").addClass("sort-desc").siblings().removeClass();
			new_sortType = "desc";
			break;
		default :
			if(sortField == cur_sortField)
			{
				$("#sort-" + sortField).attr("class" , cur_sortType == "desc" ? "sort-asc" : "sort-desc");
				new_sortType =  cur_sortType == "desc" ? "asc" : "desc";
			}else{
				$("#sort-" + sortField).addClass("sort-desc").siblings().removeClass();
				new_sortType = "desc";
			}
			break;
	}
	ec.search.sortType = new_sortType;
	ec.search.sortField = sortField;
	ec.search.load();
};



ec.search.load = function(page){

	var p = ec.search.pageNumber = (page ?  page.pageNumber : ec.product.pageNumber);

	ec.Cache.get("search_ajaxer" , function(){
		return new ec.ajax();
	}).get({
		url : "/search/"+encodeURIComponent(ec.search.keyword)+".json?pageNumber="+p+"&"+ec.search.sortField+"="+ec.search.sortType,
		timeout : 10000,
		timeoutFunction : function(){
			alert("读取超时，请重试！");
		},
		beforeSendFunction : function(){
			ec.ui.loading.show({modal : false});
		},
		afterSendFunction  : ec.ui.loading.hide,
		successFunction : function(json){

			if(!json.success)
			{
				alert("读取失败，请重试！");
			}

			var html = [] , p;

			for(var i = 0 ; i < json.prdList.length ; i ++)
			{
				p = json.prdList[i];
				p.price = (p.priceMode == 2) ? '<em>暂无报价</em>' : '<b>&yen;'+p.price+'</b>';
				html.push('<li><div>');
				html.push('<p class="p-img"><a href="/product/'+p.id+'.html#'+ p.skuId +'" title="'+p.briefName+'"><img src="'+ec.mediaPath + p.photoPath + '142_142_' + p.photoName + '" alt="' + p.briefName + '"/></a></p>');
				html.push('<p class="p-price">'+ p.price +'</p>');
				html.push('<p class="p-name"><a href="/product/'+p.id+'.html#'+ p.skuId +'" title="'+p.briefName+'"><span class="red">'+p.name+'</span></a></p>');
				html.push("</div></li>");
			}

			$("#pro-list").html(html.join(""));
			ec.ui.scrollTo("#ct-list");

			//初始化分页
			ec.search.renderPage(json.page);

		}
	});
};


ec.search.renderPage = function(page){
		if(!page.totalPage || page.totalPage==1)return;

		$("#search-pager").pager({
			pageNumber : page.pageNumber, 
			pageCount : page.totalPage, 
			recordCount : page.totalRow, 
			qpageSize:5, 
			text:{ 
				first:"|&lt;", 
				pre:"&lt", 
				next:"&gt;", 
				last:"&gt;|"
			}, 
			item:["first","pre","qpage","next","last","quickPager"],//显示样式 
			callBack: ec.search.load
		});
};
