$(function() {
	var accountTabBarItem = $('.account-tab-bar .item');
	$('.form-clear-val').each(function(){
		//监听输入框是否有值，有则出现清空按钮
		$(this).on('input onpropertychange',function(){
			if($(this).val() == "" ){
				$(this).next().addClass('hide');
			}
			else
			{
				$(this).next().removeClass('hide');
			}
		});
	});

	//协议条款
	$('#checkLabel').on('click',function(){
		if( !$(this).hasClass('checked') ){
			$(this).addClass('checked');
		}
		else{
			$(this).removeClass('checked');
		}
	});

	//下一步
	$('#nextBarBtn').on('click',function(){
		layer.open({
		    content: '手机号或邮箱格式不正确！'
		    ,skin: 'msg'
		    ,time: 3 
		});
	});

	//重置密码
	$('#resetBarBtn').on('click',function(){
		layer.open({
		    content: '密码前后不一致，请重新输入！',
			skin: 'msg',
			time: 3
		});
	});

	$('.visible-icon').on('click',function(){
		if(!$(this).hasClass('on')){
			$(this).addClass('on');
			$(this).prev().prop('type','text');
		}
		else{
			$(this).removeClass('on');
			$(this).prev().prop('type','password');
		}
	});

	//清空输入框的值
	$('.clear-icon').on('click',function(){
		$(this).addClass('hide');
		$(this).prev().val('');
	});
});
