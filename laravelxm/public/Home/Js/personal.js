/**
 * 个人信息 Last Update:2014-04-07
 */
ec.pkg("ec.member.personal");
ec.load("ec.box");
ec.load("ajax");
ec.load("ec.linkSelect.region");

ec.member.personal.time = 60;
ec.member.personal.isNum = false;

ec.member.personal.timer = setInterval(function() {
	var $code_num = $("#checkCodeFrom").find("#check-code-num");
	if (ec.member.personal.isNum) {
		ec.member.personal.time--;
		$code_num.html(ec.member.personal.time + "&nbsp;&nbsp;&nbsp;&nbsp;重新获取验证码");
		if (ec.member.personal.time == 0) {
			ec.member.personal.isNum = false;
			ec.member.personal.time = 60;
			$code_num.html("重新获取验证码").parent().removeClass("button-disabled");
		}
	}
}, 1000);

// 激活用户
ec.member.personal.activeUserCheck = function(email) {
	if ($.trim(email).length <= 0) {
		return;
	}
	var reqUrl = "/member/sendEmail.json",
		email = $.trim(email);
	ec.member.personal.sendEmail(reqUrl, email);
};

/**
 * 手机验证
 * 
 * @param dom
 * @param type 1:绑定 2:立即验证 3:修改
 */
ec.member.personal.mobileBindCheck = function(dom, type) {
	new ec.box($("#box-check-mobile").val(), {
		boxid : "check_mobil_box",
		title : "手机号码验证",
		showButton : false,
		onopen : function() {
			if (2 == type) {
				var oldMoblie = $(dom).prev("span").text();
				$("#check_mobil_box input[name=mobile]").val(oldMoblie);
			}
		},
		width : 472,
		onok : function(box) {
			$("#check-mobile-msg").text("");
			var mobile = $.trim($("#checkCodeFrom input[name=mobile]").val());
			if ("" == mobile) {
				$("#check-mobile-msg").text("请输入手机号");
				return;
			}

			var validateMoblie = function(mobile) {
				if (mobile.length < 11) {
					return false;
				}
				return /^(\+|00)?((86)?(1[3458])[0-9]{9}|852[9865][0-9]{7})$/.test(mobile);
			};

			if (!validateMoblie) {
				$("#check-mobile-msg").text("手机号错误");
				return;
			}

			var authCode = $.trim($("#smsAuthCode").val());
			if ("" == authCode) {
				$("#check-mobile-msg").text("请输入验证码");
				return;
			}
			if (!(/^\d{4}$/.test(authCode))) {
				$("#check-mobile-msg").text("验证错误");
				return;
			}

			var randomFlag = $.trim($("#randomFlag").val());
			new ec.ajax().post({
				url : "/member/activateMsisdn.json",
				data : {
					"smsAuthCode" : authCode,
					"mobile" : mobile,
					"randomFlag" : randomFlag
				},
				timeout : 10000,
				timeoutFunction : function() {
					alert("读取超时，请重试！");
				},
				beforeSendFunction : ec.ui.loading.show,
				afterSendFunction : ec.ui.loading.hide,
				successFunction : function(json) {
					if (!json.success) {
						$("#check-mobile-msg").text(json.msg);
						return;
					}
					ec.member.personal.isNum = false;
					ec.member.personal.time = 60;
					alert("验证成功！");
					$("#check_mobil_box .box-close").click();
					var htm = '<span>'+mobile+'</span><a href="javascript:;" onclick="ec.member.personal.mobileBindCheck(this, 3)" class="link">修改手机号</a><span class="icon-ok">已验证</span>';
					$(dom).closest("td").html(htm);
					return;
				},
				errorFunction : function() {
					alert("验证失败！");
					return;
				}
			});
		}
	}).open();
};

// 发送验证码到手机
ec.member.personal.sendCode = function(dom) {
    if($(dom).hasClass("button-disabled")){
    	return;
    }
	$("#checkCodeFrom .icon-error").remove();
	var mobile = $.trim($("#checkCodeFrom input[name=mobile]").val());

	if ("" == mobile) {
		alert("请输入手机号");
		return;
	}

	var validateMoblie = function(mobile) {
		if (mobile.length < 11) {
			return false;
		}
		return /^(\+|00)?((86)?(1[34578])[0-9]{9}|852[9865][0-9]{7})$/.test(mobile);
	};

	if (!validateMoblie(mobile)) {
		$("#checkCodeFrom input[name=mobile]").after('<span class="icon-error">&nbsp;</span>');
		return;
	}

	var randomFlag = $.trim($("#randomFlag").val());
	new ec.ajax().post({
		url : "/member/sendAuthCode.json",
		data : {
			"mobile" : mobile,
			"randomFlag" : randomFlag
		},
		timeout : 10000,
		timeoutFunction : function() {
			alert("读取超时，请重试");
		},
		beforeSendFunction : ec.ui.loading.show,
		afterSendFunction : ec.ui.loading.hide,
		beforeSendFunction : function() {
			$(dom).addClass("button-disabled");
			$(dom).children().html("正在发送...");
		},
		afterSendFunction : function() {
			$(dom).removeClass("button-disabled");
			$(dom).children().html("免费获取验证码");
		},
		successFunction : function(json) {
			if (!json.success) {
				ec.showError(json);
				return;
			}
			$(dom).addClass("button-disabled");
			ec.member.personal.time = 60;
			ec.member.personal.isNum = true;
			return;
		},
		errorFunction : function() {
			alert("发送失败");
		}
	});
};

// 邮箱验证
ec.member.personal.verifyEmail = function(email){
	if($.trim(email).length <= 0){
		alert("请输入邮箱");
		return false;
	}
	
	if (!(/^\w+((-w+)|(.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(email)) {
		alert("邮箱格式错误!");
		return false;
	}
	
	return true;
};

/**
 * 绑定邮箱
 */
ec.member.personal.bindEmail = function(dom){
	new ec.box($("#box-check-change-mail").val(), {
		boxid : "check_email_box",
		title : "绑定邮箱",
		showButton : false,
		width : 578,
		onopen : function(){
			$("#btn-send-email").click(function(){
				var email = $("#email-content").val();
				if(!ec.member.personal.verifyEmail(email)){
					return;
				}
				var reqUrl = "/member/updateEmail.json",
					email = $.trim(email);
				var fillHtml = '<span>'+email+'</span><a href="javascript:;" onclick="ec.member.personal.changeEmail(this)" class="link">修改邮箱</a><a href="javascript:;" onclick="ec.member.personal.checkEmailNow(this)" class="button-style-1"><span><b>立即验证</b></span></a>';
				ec.member.personal.sendEmail(reqUrl, email, "#check_email_box", "#bind-email", fillHtml);
			});
		}
	}).open();
};

/**
 * 立即验证邮箱
 */
ec.member.personal.checkEmailNow = function(dom){
	var email = $(dom).closest("td").find("span").eq(0).text();
	var reqUrl = "/member/sendEmail.json?",
		email = $.trim(email);

	ec.member.personal.sendEmail(reqUrl, email);
};

/**
 * 修改邮箱
 */
ec.member.personal.changeEmail = function(dom){
	new ec.box($("#box-check-change-mail").val(), {
		boxid : "check_email_box",
		title : "修改邮箱",
		showButton : false,
		width : 578,
		onopen : function(){
			$("#btn-send-email").click(function(){
				var email = $("#email-content").val();
				if(!ec.member.personal.verifyEmail(email)){
					return;
				}
				var reqUrl = "/member/updateEmail.json?",
					email = $.trim(email);
				var fillHtml = '<span>'+email+'</span><a href="javascript:;" onclick="ec.member.personal.changeEmail(this)" class="link">修改邮箱</a><a href="javascript:;" onclick="ec.member.personal.checkEmailNow(this)" class="button-style-1"><span><b>立即验证</b></span></a>';
				ec.member.personal.sendEmail(reqUrl, email, "#check_email_box", "#bind-email", fillHtml);
			});
		}
	}).open();
};

/**
 * 发送邮件
 * 
 * @param reqUrl 请求地址
 * @param boxId 发出请求的boxId
 * @param fillDom 需要填充的结点
 * @param fillHtml 需要填充的内容
 */
ec.member.personal.sendEmail = function(reqUrl, email, boxId, fillDom, fillHtml){
	if($.trim(reqUrl).lenght <= 0)
		return;
		
	var isCloseBox = (fillDom != null ? true : false);
	var isFill = (boxId != null ? true : false);
	var randomFlag = $.trim($("#randomFlag").val());
	new ec.ajax().post({
		url : reqUrl,
		data : {
			"email" : email,
			"randomFlag" : randomFlag
		},
		timeout : 10000,
		timeoutFunction : function() {
			new ec.box($("#box-fail-email").val(), {
				boxid : "fail_email_box",
				boxclass : "ol_box_2",
				showTitle : true,
				showButton : false,
				onopen : function(){
					$("#resend-email").click(function(){
						ec.member.personal.sendEmail(reqUrl, email, "#fail_email_box", fillDom, fillHtml);
						$("#fail_email_box").find(".box-close").click();
					});
				},
				width : 580
			}).open();
		},
		successFunction : function(json) {
			if (!json.success) {
				ec.showError(json);
				return;
			}
			// 如果需要回填，则回填内容
			if(isFill){
				$(fillDom).html(fillHtml);	
			}
			// 如果是由弹出框发送则关闭弹出框
			if(isCloseBox){
				$(boxId).find(".box-close").click();
			}
			
			//删除遮罩层，防止鼠标双击时出现两层遮罩层，关闭时只关闭一层的情况
			if($(".ol_box_mask").length > 0){
				$(".ol_box_mask").remove();
			}
			new ec.box($("#box-success-email").val(), {
				boxid : "success_email_box",
				boxclass : "ol_box_2",
				showTitle : true,
				showButton : false,
				width : 670
			}).open(), 2000
			
		},
		errorFunction : function() {
			alert("发送验证邮件失败！");
		}
	});
};

// 签到
/*
 * ec.member.personal.signIn = function() { var api = '/sale/signin.json'; new
 * ec.ajax().get({ url : api +"?_t="+new Date().getTime(),
 * successFunction:function(json){ var tipsHtml =
 * $('#coupon-tips-success').val(); if(!json.success) { tipsHtml =
 * $('#coupon-tips-'+ json.code).val(); } new ec.box(tipsHtml, { boxid :
 * "signin_box", boxclass : "ol_box_2", showTitle : true, showButton : false,
 * width : 670 }).open(); } }); };
 */

ec.member.personal.submit = function(form) {
	var _this = ec.member.personal, name = $("#personal-save input[name='name']");
/*	var checkNickName = function(val) {
		var regex = /^[\u4E00-\u9FA5\sA-Za-z0-9]+$/, msg_ct = $('#nickName_msg');
		if ($.trim(val).length < 1) {
			msg_ct.html('<span class="vam icon-warn">请输入昵称</span>');
			return false;
		}
		if ($.trim(val).length > 20) {
			msg_ct.html('<span class="vam icon-error">最长为20个字符</span>');
			return false;
		}

		if (!regex.test(val)) {

			msg_ct.html('<span class="vam icon-error">只允许输入中、英文和数字</span>');
			return false;
		}
		return true;
	};
	if (!checkNickName(nickName.val()))
		return false;
*/
	if ($.trim(name.val()).length == 0) {
		name.val('');
	}

//	nickName.attr({
//		'validator' : ''
//	});
	if (!ec.form.validator(form, false)) {
		return false;
	}

	// 扩展一个新的验证类型, 验证密码强度
	var checkBirthday = function() {
		if (_this.year && _this.month && _this.day)
			return true;
		var year = $('#select_year'), month = $('#select_month'), day = $('#select_day'), yearVal = year.val(), monthVal = month.val(), dayVal = day.val();
		day.removeClass('error');
		if (!yearVal && !monthVal && !dayVal)
			return true;
		if (yearVal && monthVal && dayVal)
			return true;

	}, $birthdayMsg = $("#birthday-msg");
	// 验证生日
	if (!checkBirthday()) {
		$birthdayMsg.html('<span class="vam icon-error">请选择完整的生日信息</span>');
		return false;
	} else {
		$birthdayMsg.html('');
	}
	new ec.ajax().submit({
		url : "/member/account/update.json",
		form : "#personal-save",
		timeout : 10000,
		timeoutFunction : function() {
			alert("读取超时，请重试！");
		},
		beforeSendFunction : ec.ui.loading.show,
		afterSendFunction : ec.ui.loading.hide,
		successFunction : function(json) {
			if (!json.success) {
				ec.showError(json);
				return;
			}
			alert("保存成功");
			location.reload();
			return;
		}
	});
	return false;
};


// 领取优惠券
ec.member.personal.receive = function() {
	// ec.member.personal.timer();
	var api = '/member/account/drawCoupon.json';
	new ec.ajax().post({
		url : api + "?_t=" + new Date().getTime(),
		successFunction : function(json) {
			var tipsHtml = $('#coupon-tips-success').val();
			if (!json.success) {
				tipsHtml = $('#coupon-tips-' + json.code).val();
			}
			new ec.box(tipsHtml, {
				boxid : "drawCoupon_box",
				boxclass : "ol_box_2",
				showTitle : true,
				showButton : false,
				width : 670
			}).open();
		}
	});
};

ec
		.ready(function() {
			$("#li-account").addClass("current");
			$("#pathTitle").html("个人信息");
			var _this = ec.member.personal;

			// 初始化生日列表
			var nowYear = new Date().getFullYear(), optionList = '';
			if (!_this.year || !_this.month || !_this.day) { // 填写生日后不可更改
				// 初始化年份
				for ( var i = nowYear; i > nowYear - 100; i -= 1) {
					optionList += '<option value="' + i + '">' + i + '年' + '</option>';
				}
				$('#select_year').append(optionList);

				// 初始化月份
				optionList = '';
				for ( var i = 1; i <= 12; i += 1) {
					optionList += '<option value="' + i + '">' + i + '月' + '</option>';
				}
				$('#select_month').append(optionList);

				// 初始化天数
				optionList = '';
				for ( var i = 1; i <= 31; i += 1) {
					optionList += '<option value="' + i + '">' + i + '日' + '</option>';
				}
				$('#select_day').append(optionList);

				// 动态获取选中月份的天数
				$('#select_year, #select_month').change(function() {

					// 动态写入天数
					optionList = '';
					var getYear = $('#select_year').val(), getMonth = $('#select_month').val(), maxDay = 0;
					if (getYear > 0 && getMonth > 0) {
						maxDay = new Date(getYear, getMonth, 0).getDate();
						for ( var i = 1; i <= maxDay; i += 1) {
							optionList += '<option value="' + i + '">' + i + '日' + '</option>';
						}
						$('#select_day').html('<option value="">-选择日-</option>' + optionList);
					}
				});
			}

			// 初始化地区列表
			new ec.linkSelect.region("#linkSelect", {
				defaultValue : _this.linkSelectVal,
				ids : [ 'province', 'city', "district" ],
				names : [ "province", "city", "district" ],
				css : [ "ec_linkSelect", "ec_linkSelect", "ec_linkSelect" ],
				tips : [ "- 请选择 -", "- 请选择 -" ]
			});

			// 选中用户填写的信息
			$('#price').val(_this.price);
			$('#profession').val(_this.profession);

			var name = $("#personal-save input[name='name']"),  birthday = $('#select_day'), _vb = ec.form.validator.bind;
/*			nickName.focus(function() {
				if (bindNickName) {
					var thisValidator = nickName.attr('data-oldValidator');
					nickName.attr({
						'validator' : thisValidator
					});
					return false;
				}

				_vb(this, {
					type : [ "require", "length", "regex" ],
					regex : /^[\u4E00-\u9FA5\sA-Za-z0-9]+$/,
					validOnChange : true,
					max : 20,
					msg_ct : '#nickName_msg',
					msg : {
						"require" : "请输入昵称",
						"length" : "最长为20个字符",
						"regex" : "只允许输入中、英文和数字"
					},
					successFunction : function(obj, options) {
						$(options.msg_ct).empty();
						var newVal = $.trim(obj.val());
						if (newVal === obj.attr('data-old') || newVal.length == 0) {
							return;
						}
						new ec.ajax().get({
							dataType : 'json',
							url : "/member/check/nickName/" + newVal + ".json?_t=" + new Date().getTime(),
							successFunction : function(json) {
								if (!json.success) {
									$(options.msg_ct).html("<span class='vam icon-error'>您输入的昵称已被人注册</span>");

								}
							}
						});
					}

				});
				bindNickName = true;

			}).blur(function() {
				var thisValidator = nickName.attr('validator');
				nickName.attr({
					'validator' : '',
					'data-oldValidator' : thisValidator
				});
			});
*/
			_vb(name, {
				type : [ "length", "regex" ],
				validOnChange : true,
				max : 20,
				regex : /^[\u4E00-\u9FA5\sA-Za-z]+$/,
				msg : {

					"length" : "最长为20个字符",
					"regex" : "只允许输入中、英文和空格"
				}
			});

			$("#myNumber-area-current .number-area").hover(function() {
				$(this).addClass("current");
			}, function() {
				$(this).removeClass("current");
			});

			// 浮动效果
			var _window = $(window), _binded = false, _doc = document.compatMode == 'CSS1Compat' ? document.documentElement : document.body, _scrollTopSrart = 0, _timer, $flow = $("#hf-coupon-fw-area-flow"), _flowH = $flow
					.height() + 15, _contentH = _doc.scrollHeight, _scrollEnd = _contentH - _flowH - 400, _scrollEvent;

			var _resetRightCss = function() {
				$flow.css('right', ((_doc.clientWidth - 1002) / 2) + 10 + 'px').show();
			};
			_resetRightCss();
			// 绑定事件
			_scrollEvent = function() {
				// clearTimeout(_timer);
				// _timer = setTimeout(function(){

				_scrollTopSrart = _window.scrollTop();
				if (_scrollTopSrart < 270) {
					$flow.css({
						"position" : "absolute",
						"top" : "270px"
					});
					return;
				}
				if (_scrollTopSrart < _scrollEnd) {
					if (ec.isIE6) {
						$flow.css({
							"position" : "absolute",
							"top" : (_scrollTopSrart + 15) + "px"
						});
					} else {
						$flow.css({
							"position" : "fixed",
							"top" : "15px"
						});
					}
					return;
				}

				$flow.css({
					"position" : "absolute",
					"top" : _scrollEnd + "px"
				});

				// } , 10);

			};
			_window.bind("scroll", _scrollEvent);
			_scrollTopSrart = _window.scrollTop();
			_window.bind("resize", _resetRightCss);

		});
