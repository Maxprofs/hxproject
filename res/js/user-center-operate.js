/**
 *
 * Created by xuqiang on 2017/1/5.
 *
 */
(function(){

    $(".side-menu-group").on("click",function(){
        if( !$(this).hasClass("up") )
        {
            $(this).addClass("up").next(".son").show();
        }
        else
        {
            $(this).removeClass("up").next(".son").hide();
        }
        $(this).parent("li").siblings().children(".side-menu-group").removeClass("up").next(".son").hide()
    })

})();