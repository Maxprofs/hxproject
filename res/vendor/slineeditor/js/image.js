//隐藏原生图片上传组件
document.write('<style type="text/css">' +
    '.edui-default .edui-for-vseem .edui-icon{background-position: -380px 0;}' +
    '.edui-default .edui-for-stinsertimage .edui-icon{background-position: -380px 0;}' +
    '.edui-box.edui-button.edui-for-insertimage.edui-default{display: none!important;}' +
    '.edui-default .edui-for-vseem .edui-dialog-content {height: 390px;overflow: hidden;width: 640px;}' +
    '.edui-default .edui-for-stinsertimage .edui-dialog-content {height: 390px;overflow: hidden;width: 640px;}' +
    '</style>');
UE.commands['vseem'] = {
    execCommand:function (cmd, opt) {
        var me = this;
        var url=BASEHOST + '/plugins/upload_image/image/insert_view',width=430,height=340;
        if(window.UPLOADIMAGEURL){
            url=window.UPLOADIMAGEURL;
            width=0;
            height=0;
        }
        ST.Util.showBox('插入图片',url, width,height, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
        function Insert(result,bool){
            var imgs=result.data;
            var html='';
            for(var i in imgs){
                if(imgs[i].indexOf("$$")>-1){
                    var temp=imgs[i].split('$$');
                    if(temp[0].indexOf(temp[1])>-1){
                        html+='<img src="'+temp[0]+'" alt="" title=""/>';
                    }else{
                        html+='<img src="'+temp[0]+'" alt="'+temp[1]+'" title="'+temp[1]+'"/>';
                    }
                }else{
                    html+='<img src="'+imgs[i]+'" alt="" title=""/>';
                }

            }
            me.execCommand('insertHtml',html);
        }
    }
};
