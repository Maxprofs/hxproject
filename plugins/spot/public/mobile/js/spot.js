/*
 *
 *门票业务代码
 *
*/
;

window.onload = function(){

	//详情页滚动图
    var mySwiper = new Swiper('.st-photo-container', {
        autoplay: 5000,
        loop: true,
        lazyLoading: true,
        observer: true,
        observeParents: true,
        autoplayDisableOnInteraction: false,
        onInit: function(){
            $('#slideAllCount').text($('.swiper-slide').length - 2);
        },
        onSlideChangeEnd: function(swiper){
            $('#slideCurrentIndex').text(swiper.realIndex + 1)
        }
    });


    //套餐展示
    var productTypeBar = $('.product-type-block').find('.type-bar');
    productTypeBar.on('click',function(){
    	var _this = $(this);
    	if( _this.parent().hasClass('retract') ){
    		_this.parent().removeClass('retract');
            _this.siblings('.product-type-group').addClass('hide');
    	} else{
    		_this.parent().addClass('retract');
            _this.siblings('.product-type-group').removeClass('hide');
    	}
    });

    //选择票型
    var $chooseTicketType = $('#chooseTicketType');
    var scrollHeight = parseInt($('#productTypeWrapper').offset().top - 48);
    $chooseTicketType.on('click',function(){
        //console.log(scrollHeight);
        $('#productScrollFixed').scrollTop(scrollHeight)
    });


    //门票说明
    $('.product-type-info').on('click',function(){
        var suit=$(this).attr('data-id');
        var index = layer.open({
            type: 1,
            content: $('#ticketInfo_'+suit).html(),
            anim: 'up',
            className: 'layer-show-content',success: function(){
                $('body').on('click','#closeTicketLayer_'+suit,function(){
                    layer.close(index);
                })
            }
        });
    });


    //积分优惠
    $('.product-itg-bar').on('click', function () {
        var index = layer.open({
            type: 1,
            content: $('#integralInfo').html(),
            anim: 'up',
            className: 'layer-show-content',
            success: function () {
                $('body').on('click', '#closeTicketLayer_jifen', function () {
                    layer.close(index);
                })
            }
        });
    });



    //回到顶部
    $(function(){
        //返回顶部
        $('#roll_top').click(function(){
            $('.spot-content').animate({scrollTop: '0px'}, 800);
        });
    });

}