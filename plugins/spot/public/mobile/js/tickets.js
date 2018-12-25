/**
*tickets page javascript
*/
	$(function(){


		//轮播图
		var BannerSwiper = new Swiper ('.swiper-banner-container', {
			pagination: '.swiper-banner-container .swiper-pagination',
			observer:true,
			observeParents:true,
			autoplayDisableOnInteraction : false,
		});

		//精选产品
		var productRecommend = new Swiper ('.product-recommend-block', {
			slidesPerView:2.45,
			observer:true,
			observeParents:true
		});

		//监听滚动
		window.onscroll = function(){
			var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

			if( scrollTop > 300 )
				backTop.style.display = 'block';
			else
				backTop.style.display = 'none'

		};

		//返回顶部
		var backTop = document.getElementById("backTop");
		backTop.onclick = function(){
			document.documentElement.scrollTop = document.body.scrollTop = 0
		};

	});

