!function(t){t.fn.buttonBox=function(a){var i={id:null,dataurl:"1",params:{}},n=t.extend(i,a),d='<div style="padding-top:50px;padding-bottom:50px;text-align:center;">加载失败...</div>';return this.each(function(){t(this).click(function(a){a&&a.stopPropagation?a.stopPropagation():window.event.cancelBubble=!0;var i="STBOX_"+t(this).attr("id"),e=t(this).attr("data-url"),o=t(this).attr("data-result");if(""!=o){var r={resultid:o};n.params=t.extend(n.params,r)}if(t("div[id^='STBOX_']").hide(),0==t("#"+i).length){var p=t(this).offset(),l=t("<div id='"+i+"'></div>");t("body").append(l),t("#"+i).css({background:"#fff",position:"absolute",boxShadow:"3px 3px 5px #ddd;",top:p.top+t(a.target).height()+"px",left:p.left,padding:"0 15px 10px;",zIndex:"1001",display:"none"}),""!=n.dataurl&&t.ajax({type:"POST",url:SITEURL+e,data:n.params,dataType:"html",cache:!1,success:function(t){l.html(t)},error:function(){l.html(d)}})}t("#"+i).toggle(),t(document).unbind("click").bind("click",function(a){var n=t(a.target);0==n.closest("#"+i).length&&t("#"+i).hide()})})})}}(jQuery);