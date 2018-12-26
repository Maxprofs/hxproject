(function ($) {
    var st = {};
    st.Util={

        showMsg:function(msg,type,time)
        {
            time = time ? time : 1000;//显示时间
            ZENG.msgbox.show(msg,type,time);
        },
        //隐藏消息框
        hideMsgBox:function(){
            ZENG.msgbox._hide();
        },
        //弹出框
        showBox:function(boxtitle,url,boxwidth,boxheight,closefunc,nofade,fromdocument,params)
        {
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
                loadDocument:fromdocument,
                onclose: function () {
                    func();
                }
            }
            initParams= $.extend(initParams,params);
            var dlg = dialog(initParams);
            if(typeof(dlg.loadCallback)=='function'&&typeof(dlg.loadWindow)=='object')
            {
                dlg.finalResponse=function(arg,bool,isopen){
                    dlg.loadCallback.call(dlg.loadWindow,arg,bool);
                    if(!isopen)
                        this.remove();
                }
            }
            window.d=dlg;
            if (boxwidth != 0) {
                d.width(boxwidth);
            }
            if (boxheight != 0) {
                d.height(boxheight);
            }
            if (nofade) {
                d.show()
            } else {
                d.showModal();
            }

        },
        //弹出框关闭
        closeBox:function()
        {
            window.d.close().remove();
        },
        //确认框
        confirmBox:function(boxtitle,boxcontent,okfunc,cancelfunc)
        {
            boxcontent='<div class="confirm-box">'+boxcontent+'</div>';
            var d = dialog({
                title: boxtitle,
                content: boxcontent,
                okValue: '确定',
                ok: function () {
                    okfunc();
                },
                cancelValue: '取消',
                cancel: function () {

                    if(typeof(cancelfunc)=='function')
                        cancelfunc();
                }
            });
            window.d = d;
            d.showModal();

        },
        //信息框
        messagBox:function(boxtitle,boxcontent,nofade,width,height)
        {
            var d = dialog({
                title: boxtitle,
                content: boxcontent,
                width:width,
                height:height
            });
            if(nofade){
                d.show()
            }else
            {
                d.showModal();
            }

        },

        getDialog:function()
        {
            var frames = parent.window.document.getElementsByTagName("iframe"); //获取父页面所有iframe

            for(i=0;i<frames.length;i++) { //遍历，匹配时弹出id
                if (frames[i].contentWindow == window) {
                    var dlgEle = $(frames[i]).parents(".ui-popup:first");
                    var dlgId = dlgEle.attr('aria-labelledby');
                    dlgId = dlgId.substr(6);
                    var dialog = parent.dialog.get(dlgId);
                    return dialog;
                }
            }
            return null;
        },
        closeDialog:function()
        {
            var dialog=this.getDialog();
            console.log(dialog);
            dialog.remove();

        },
        resizeDialog:function(selector)
        {
            var dialog=this.getDialog();
            var maxHeight=dialog.maxHeight;
            var height=$(selector).height();
            if(maxHeight&&height>maxHeight)
                height=maxHeight;
            dialog.height(height).show();
        }
        ,
        resizeDialogHeight:function(height)
        {
            var dialog=this.getDialog();
            var maxHeight=dialog.maxHeight;
            if(maxHeight&&height>maxHeight)
                height=maxHeight;
            dialog.height(height).show();
        }
        ,responseDialog:function(results,bool)
        {
            var dialog=this.getDialog();
            dialog.finalResponse(results,bool);

        }
        ,prevPopup:function(e,ele)
        {
            var evt = e ? e : window.event;
            if (evt.stopPropagation) {
                evt.stopPropagation();
            }
            else {

                evt.cancelBubble = true;
            }
        },
        insertContent : function(myValue, obj,t) {
            var $t = obj[0];
            if (document.selection) { // ie
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
                sel.moveStart('character', -l);
                var wee = sel.text.length;
                if (arguments.length == 2) {
                    var l = $t.value.length;
                    sel.moveEnd("character", wee + t);
                    t <= 0 ? sel.moveStart("character", wee - 2 * t
                    - myValue.length) : sel.moveStart(
                        "character", wee - t - myValue.length);
                    sel.select();
                }
            } else if ($t.selectionStart
                || $t.selectionStart == '0') {
                var startPos = $t.selectionStart;
                var endPos = $t.selectionEnd;
                var scrollTop = $t.scrollTop;
                $t.value = $t.value.substring(0, startPos)
                + myValue
                + $t.value.substring(endPos,
                    $t.value.length);
                this.focus();
                $t.selectionStart = startPos + myValue.length;
                $t.selectionEnd = startPos + myValue.length;
                $t.scrollTop = scrollTop;
                if (arguments.length == 2) {
                    $t.setSelectionRange(startPos - t,
                        $t.selectionEnd + t);
                    this.focus();
                }
            } else {
                this.value += myValue;
                this.focus();
            }
        }

    }




    //验证码URL添加随机数
    st.captcha = captcha;
    function captcha(url) {
        var path = url.split('?');
        return path[0] + '?' + Math.random() * 10000;
    }
    st.openUrl=function(url,issingle)
    {
        open(url,'_self');
    }


    var STMath={
        add:function(a, b) {
            var c, d, e;
            try {
                c = a.toString().split(".")[1].length;
            } catch (f) {
                c = 0;
            }
            try {
                d = b.toString().split(".")[1].length;
            } catch (f) {
                d = 0;
            }
            return e = Math.pow(10, Math.max(c, d)), (this.mul(a, e) + this.mul(b, e)) / e;
        },
        sub:function(a, b) {
            var c, d, e;
            try {
                c = a.toString().split(".")[1].length;
            } catch (f) {
                c = 0;
            }
            try {
                d = b.toString().split(".")[1].length;
            } catch (f) {
                d = 0;
            }
            return e = Math.pow(10, Math.max(c, d)), (this.mul(a, e) - this.mul(b, e)) / e;
        },
        mul:function(a, b) {
            var c = 0,
                d = a.toString(),
                e = b.toString();
            try {
                c += d.split(".")[1].length;
            } catch (f) {}
            try {
                c += e.split(".")[1].length;
            } catch (f) {}
            return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
        },
        div: function(a, b){
            var c, d, e = 0,
                f = 0;
            try {
                e = a.toString().split(".")[1].length;
            } catch (g) {}
            try {
                f = b.toString().split(".")[1].length;
            } catch (g) {}
            return c = Number(a.toString().replace(".", "")), d = Number(b.toString().replace(".", "")), this.mul(c / d, Math.pow(10, f - e));
        }
    }
    st.Math=STMath;
    window.ST = st;

    //修改页面使用共公函数
    ST.Modify={
        //获取选择的目的地
        getSelectDest:function(arr)
        {
            var html = '';
            $.each(arr, function(i, item){
                html+="<span><s onclick=\"$(this).parent('span').remove()\"></s>"+item.kindname;
                html+="<input type=\"hidden\" name=\"kindlist[]\" value=\""+item.id+"\"></span>";
            });
            return html;
        },
        //获取选择的属性
        getSelectAttr:function(arr)
        {
            var html = '';
            $.each(arr, function(i, item){

                html+="<span><s onclick=\"$(this).parent('span').remove()\"></s>"+item.attrname;
                html+="<input type=\"hidden\" name=\"attrlist[]\" value=\""+item.id+"\"></span>";
            });
            return html;
        },
        //获取选择的图标
        getSelectIcon:function(arr)
        {

            var html = '';
            $.each(arr, function(i, item){

                html+="<span><s onclick=\"$(this).parent('span').remove()\"></s><img src=\""+item.picurl+"\">";
                html+="<input type=\"hidden\" name=\"iconlist[]\" value=\""+item.id+"\"></span>";
            });
            return html;
        },
        getUploadFile:function(arr,showsethead)
        {

            var html = '';
            var sethead = showsethead==0 ? 0 : 1;
            $.each(arr,function(i,item){
                var k=i+1;

                html+='<li class="img-li">';
                html+='<img class="fl" src="'+item.litpic+'" width="100" height="100">';
                html+='<p class="p1">';
                html+='<input type="text" class="img-name" name="imagestitle['+k+']" value="'+item.desc+'" style="width:90px">';
                html+='<input type="hidden" class="img-path" name="images['+k+']" value="'+item.litpic+'">';
                html+='</p>';
                html+='<p class="p2">';
                if(sethead){
                    html+='<span class="btn-ste" onclick="Imageup.setHead(this,'+k+')">设为封面</span>';
                }

                html+='<span class="btn-closed" onclick="Imageup.delImg(this,\''+item.litpic+'\','+k+')"></span>';
                html+='</p>';
                html+='</li>';


            })
            return html;


        }


    }

})(jQuery)


