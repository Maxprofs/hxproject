/**
 * @TAB 切换组件
 *
 * */

!(function($,win,doc,undefined){

    var changeContainer = function(opt){

        var _this = this;

        this.defaults = {
            tabContainer: '.column-container',
            tabBar: '.tab-group',
            tabBarMenu: '.tab-group li',
            tabWrapper: '.column-wrapper',
            tabConBox: '.tab-con-box'
        };

        this.options = $.extend({},this.defaults,opt);
        $(this.options.tabBarMenu).on('click',function(){

            _this.tabChange(this);

        })

    };

    changeContainer.prototype = {

        constructor: changeContainer,

        tabChange: function(curItem){

            $(this.options.tabConBox).eq(0).show();
            var curIndex = $(curItem).index();
            $(curItem).addClass('cur').siblings().removeClass('cur');

        }

    };

    $.fn.myTabPlugin = function(options){

        var tab = new changeContainer(this,options);
        return tab.tabChange()

    };

})(jQuery,window,document);