(function($){
	$.floatMenu = function(options) {
		var defaults = {
			menuContain : '#pdt-tabnav',
			tabItem : 'span',
			chooseClass : 'on',
			contentContain : '.pdt-tabbox',
			itemClass : '.pdt-tabcon'
			
		};

		var options = $.extend(defaults,options);
		var $menucontain = $(''+options.menuContain);
		_init();
		function _init(){
		   if($menucontain.length>0){
				var toTopHeight = $menucontain.offset().top;


               function scrollHanlder(){
                   if( $(window).scrollTop() > toTopHeight){
                       $menucontain.addClass("fxd");
                   }else{

                       $menucontain.removeClass("fxd");
                   }
                   h($(options.contentContain+' '+options.itemClass));//鼠标滚动定位
               }

				$(window).scroll(function(){
                    scrollHanlder();
                });
				// 滚动定位
				function h(id){
					var arr = [];
					id.each(function(i){
						arr.push(id.eq(i).offset().top-52);
					});
					for(var i = 0;i<arr.length;i++){
						if($(window).scrollTop() > arr[i]){

							tab1(i,options.chooseClass);
						}
					}
				}
				function tab1(index,clas){
					$(options.menuContain+' '+options.tabItem).removeClass(clas).eq(index).addClass(clas);
				}
			
				$(options.menuContain+' '+options.tabItem).click(function(e){
					//e.preventDefault();
					var index = ($(options.menuContain+' '+options.tabItem)).index($(this));

					var goTo = $(options.contentContain+' '+options.itemClass).eq(index).offset().top-52;
					$("html, body").animate({
						scrollTop: goTo+1
					}, 500);
				});
			}
		
		}
	}


})(jQuery);