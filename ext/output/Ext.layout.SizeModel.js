Ext.data.JsonP.Ext_layout_SizeModel({"tagname":"class","name":"Ext.layout.SizeModel","extends":null,"mixins":[],"alternateClassNames":[],"aliases":{},"singleton":false,"requires":[],"uses":[],"code_type":"assignment","inheritable":false,"inheritdoc":null,"meta":{"protected":true},"id":"class-Ext.layout.SizeModel","members":{"cfg":[],"property":[{"name":"auto","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-auto"},{"name":"calculated","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-calculated"},{"name":"calculatedFromConfigured","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-calculatedFromConfigured"},{"name":"calculatedFromNatural","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-calculatedFromNatural"},{"name":"calculatedFromShrinkWrap","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-calculatedFromShrinkWrap"},{"name":"configured","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-configured"},{"name":"constrainedMax","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-constrainedMax"},{"name":"constrainedMin","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-constrainedMin"},{"name":"fixed","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-fixed"},{"name":"name","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-name"},{"name":"names","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-names"},{"name":"natural","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-natural"},{"name":"shrinkWrap","tagname":"property","owner":"Ext.layout.SizeModel","meta":{"readonly":true},"id":"property-shrinkWrap"}],"method":[],"event":[],"css_var":[],"css_mixin":[]},"statics":{"cfg":[],"property":[],"method":[],"event":[],"css_var":[],"css_mixin":[]},"files":[{"filename":"Layout.js","href":"Layout.html#Ext-layout-SizeModel"}],"html_meta":{"protected":null},"component":false,"superclasses":[],"subclasses":[],"mixedInto":[],"parentMixins":[],"html":"<div><pre class=\"hierarchy\"><h4>Files</h4><div class='dependency'><a href='source/Layout.html#Ext-layout-SizeModel' target='_blank'>Layout.js</a></div></pre><div class='doc-contents'><p>本类描述了布局系统使用的尺寸测定策略或算法. 以下是一些此类的特殊实例, 它们被存储为静态对象\n以避免不必要的对象创建工作. 这些实例应该为只读的.</p>\n\n<ul>\n<li><code>calculated</code> (计算模型)</li>\n<li><code>configured</code> (配置模型)</li>\n<li><code>constrainedMax</code> (最大约束模型)</li>\n<li><code>constrainedMin</code> (最小约束模型)</li>\n<li><code>natural</code> (原始尺寸模型)</li>\n<li><code>shrinkWrap</code> (包装模型)</li>\n<li><code>calculatedFromConfigured</code> (从配置计算模型)</li>\n<li><code>calculatedFromNatural</code> (从原始尺寸计算模型)</li>\n<li><code>calculatedFromShrinkWrap</code> (从包装尺寸计算模型)</li>\n</ul>\n\n\n<p>要使用这些实例对象非常简单:</p>\n\n<pre><code>  var calculated = <a href=\"#!/api/Ext.layout.SizeModel-property-calculated\" rel=\"Ext.layout.SizeModel-property-calculated\" class=\"docClass\">Ext.layout.SizeModel.calculated</a>;\n</code></pre>\n</div><div class='members'><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-property'>Properties</h3><div class='subsection'><div id='property-auto' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-auto' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-auto' class='name not-expandable'>auto</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'><p>'true'表示尺寸模型为 <code>natural</code> 或 <code>shrinkWrap</code>, 否则为'false'.</p>\n</div><div class='long'><p>'true'表示尺寸模型为 <code>natural</code> 或 <code>shrinkWrap</code>, 否则为'false'.</p>\n</div></div></div><div id='property-calculated' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-calculated' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-calculated' class='name expandable'>calculated</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>True if the size is calculated by the ownerLayout. ...</div><div class='long'><p>True if the size is calculated by the <code>ownerLayout</code>.\n'true'表示尺寸由所属布局(ownerLayout)负责计算.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-calculatedFromConfigured' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-calculatedFromConfigured' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-calculatedFromConfigured' class='name expandable'>calculatedFromConfigured</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true'表示尺寸大小由所属布局基于对初始化参数的计算得到. ...</div><div class='long'><p>'true'表示尺寸大小由所属布局基于对初始化参数的计算得到.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-calculatedFromNatural' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-calculatedFromNatural' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-calculatedFromNatural' class='name expandable'>calculatedFromNatural</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>True if the size is calculated by the ownerLayout based on natural size model\nresults. ...</div><div class='long'><p>True if the size is calculated by the <code>ownerLayout</code> based on <code>natural</code> size model\nresults.\n'true'表示尺寸大小由所属布局基于对'natural'模型的计算得到.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-calculatedFromShrinkWrap' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-calculatedFromShrinkWrap' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-calculatedFromShrinkWrap' class='name expandable'>calculatedFromShrinkWrap</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true'表示尺寸大小由所属布局基于对shrinkWrap模型的计算得到. ...</div><div class='long'><p>'true'表示尺寸大小由所属布局基于对<code>shrinkWrap</code>模型的计算得到.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-configured' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-configured' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-configured' class='name expandable'>configured</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true'表示尺寸由参数得到(例如 'width' 或 'minWidth'). ...</div><div class='long'><p>'true'表示尺寸由参数得到(例如 'width' 或 'minWidth'). 参数属性名称参见<a href=\"#!/api/Ext.layout.SizeModel-property-names\" rel=\"Ext.layout.SizeModel-property-names\" class=\"docClass\">names</a>属性.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-constrainedMax' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-constrainedMax' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-constrainedMax' class='name expandable'>constrainedMax</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true' 表示尺寸大小受到maxWidth或maxHeight属性的约束. ...</div><div class='long'><p>'true' 表示尺寸大小受到<code>maxWidth</code>或<code>maxHeight</code>属性的约束. 这有点像'configured'模型(因为\n<code>maxWidth</code>和<code>maxHeight</code>来自配置参数). 如果为'true', <a href=\"#!/api/Ext.layout.SizeModel-property-names\" rel=\"Ext.layout.SizeModel-property-names\" class=\"docClass\">names</a>必须被正确定义.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-constrainedMin' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-constrainedMin' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-constrainedMin' class='name expandable'>constrainedMin</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true' 表示尺寸大小受到minWidth或minHeight属性的约束. ...</div><div class='long'><p>'true' 表示尺寸大小受到<code>minWidth</code>或<code>minHeight</code>属性的约束. 这有点像'configured'模型(因为\n<code>minWidth</code>和<code>minHeight</code>来自配置参数). 如果为'true', <a href=\"#!/api/Ext.layout.SizeModel-property-names\" rel=\"Ext.layout.SizeModel-property-names\" class=\"docClass\">names</a>必须被正确定义.</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-fixed' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-fixed' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-fixed' class='name not-expandable'>fixed</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'><p>'true' 表示尺寸模型是<code>calculated</code>或<code>configured</code>, 否则为false.</p>\n</div><div class='long'><p>'true' 表示尺寸模型是<code>calculated</code>或<code>configured</code>, 否则为false.</p>\n</div></div></div><div id='property-name' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-name' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-name' class='name not-expandable'>name</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'><p>尺寸模型的名称(例如 \"calculated\").</p>\n</div><div class='long'><p>尺寸模型的名称(例如 \"calculated\").</p>\n</div></div></div><div id='property-names' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-names' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-names' class='name expandable'>names</a><span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>一个包含定义尺寸的属性名称的对象. ...</div><div class='long'><p>一个包含定义尺寸的属性名称的对象.</p>\n<p>Defaults to: <code>null</code></p><ul><li><span class='pre'>width</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>宽度属性名称 (例如 'width').</p>\n</div></li><li><span class='pre'>height</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>高度属性名称 (例如 'minHeight').</p>\n</div></li></ul></div></div></div><div id='property-natural' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-natural' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-natural' class='name expandable'>natural</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true'表示尺寸由CSS决定而且不是由容器内容决定. ...</div><div class='long'><p>'true'表示尺寸由CSS决定而且不是由容器内容决定. 这种大小可以认为依赖于容器的盒模型, 仅对\n最外层的元素进行测量</p>\n<p>Defaults to: <code>false</code></p></div></div></div><div id='property-shrinkWrap' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.layout.SizeModel'>Ext.layout.SizeModel</span><br/><a href='source/Layout.html#Ext-layout-SizeModel-property-shrinkWrap' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.layout.SizeModel-property-shrinkWrap' class='name expandable'>shrinkWrap</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span><strong class='readonly signature'>readonly</strong></div><div class='description'><div class='short'>'true'表示尺寸大小由容器的容量决定, 而与容器的盒模型无关. ...</div><div class='long'><p>'true'表示尺寸大小由容器的容量决定, 而与容器的盒模型无关.</p>\n<p>Defaults to: <code>false</code></p></div></div></div></div></div></div></div>"});