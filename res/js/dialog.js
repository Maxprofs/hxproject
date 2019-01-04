    //加载artDialog

window.dialog = null;
window.d = null;
seajs.config({
    alias: {
        "jquery": "jquery-1.10.2.js"
    }
});
//定义全局dialog对象
seajs.use(['/res/js/artDialog/src/dialog-plus'], function (dialog) {
    window.dialog = dialog;

});
//弹出框

/*
  params为附加参数，可以是与dialog有关的所有参数，也可以是自定义参数
  其中自定义参数里有
  loadWindow: 表示回调函数的window
  loadCallback: 表示回调函数
  maxHeight:指定最高高度

 */
function floatBox(boxtitle, url, boxwidth, boxheight, closefunc, nofade,fromdocument,params) {
    boxwidth = boxwidth != '' ? boxwidth : 0;
    boxheight = boxheight != '' ? boxheight : 0;
    var func = $.isFunction(closefunc) ? closefunc : function () {
    };
    fromdocument = fromdocument ? fromdocument : null;//来源document

    var initParams={
        url: url,
        title: boxtitle,
        width: boxwidth,
        height: boxheight,
        scroll:0,
        loadDocument:fromdocument,
        onclose: function () {
            func();
        }
    }
    initParams= $.extend(initParams,params);

    var dlg = window.dialog(initParams);


    if(typeof(dlg.loadCallback)=='function'&&typeof(dlg.loadWindow)=='object')
    {
       dlg.finalResponse=function(arg,bool,isopen){
            dlg.loadCallback.call(dlg.loadWindow,arg,bool);
            if(!isopen)
              this.remove();
       }
    }

    window.d=dlg;
    d.close()
    if (initParams.width != 0) {
        d.width(initParams.width);
    }
    if (initParams.height!= 0) {
        d.height(initParams.height);
    }
  
    if (nofade) {
        d.show()
    } else {
        d.showModal();
    }

}