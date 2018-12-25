Ext.data.JsonP.Ext_Class({"tagname":"class","name":"Ext.Class","extends":null,"mixins":[],"alternateClassNames":[],"aliases":{},"singleton":false,"requires":[],"uses":[],"code_type":"nop","inheritable":false,"inheritdoc":null,"meta":{"author":["Jacky Nguyen <jacky@sencha.com>"],"docauthor":["Jacky Nguyen <jacky@sencha.com>","译者: 传说【重庆】<mkoplqq2006@qq.com>"]},"id":"class-Ext.Class","members":{"cfg":[{"name":"alias","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-alias"},{"name":"alternateClassName","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-alternateClassName"},{"name":"config","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-config"},{"name":"extend","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-extend"},{"name":"inheritableStatics","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-inheritableStatics"},{"name":"mixins","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-mixins"},{"name":"requires","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-requires"},{"name":"singleton","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-singleton"},{"name":"statics","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-statics"},{"name":"uses","tagname":"cfg","owner":"Ext.Class","meta":{},"id":"cfg-uses"}],"property":[{"name":"defaultPreprocessors","tagname":"property","owner":"Ext.Class","meta":{"private":true},"id":"property-defaultPreprocessors"},{"name":"preprocessors","tagname":"property","owner":"Ext.Class","meta":{"private":true},"id":"property-preprocessors"}],"method":[{"name":"constructor","tagname":"method","owner":"Ext.Class","meta":{},"id":"method-constructor"},{"name":"create","tagname":"method","owner":"Ext.Class","meta":{"private":true},"id":"method-create"},{"name":"getPreprocessors","tagname":"method","owner":"Ext.Class","meta":{"private":true},"id":"method-getPreprocessors"},{"name":"onBeforeCreated","tagname":"method","owner":"Ext.Class","meta":{"private":true},"id":"method-onBeforeCreated"},{"name":"process","tagname":"method","owner":"Ext.Class","meta":{"private":true},"id":"method-process"}],"event":[],"css_var":[],"css_mixin":[]},"statics":{"cfg":[],"property":[],"method":[{"name":"getDefaultPreprocessors","tagname":"method","owner":"Ext.Class","meta":{"private":true,"static":true},"id":"static-method-getDefaultPreprocessors"},{"name":"getPreprocessor","tagname":"method","owner":"Ext.Class","meta":{"private":true,"static":true},"id":"static-method-getPreprocessor"},{"name":"registerPreprocessor","tagname":"method","owner":"Ext.Class","meta":{"private":true,"static":true},"id":"static-method-registerPreprocessor"},{"name":"setDefaultPreprocessorPosition","tagname":"method","owner":"Ext.Class","meta":{"private":true,"static":true},"id":"static-method-setDefaultPreprocessorPosition"},{"name":"setDefaultPreprocessors","tagname":"method","owner":"Ext.Class","meta":{"private":true,"static":true},"id":"static-method-setDefaultPreprocessors"}],"event":[],"css_var":[],"css_mixin":[]},"files":[{"filename":"Class.js","href":"Class.html#Ext-Class"}],"html_meta":{"author":null,"docauthor":null},"component":false,"superclasses":[],"subclasses":[],"mixedInto":[],"parentMixins":[],"html":"<div><pre class=\"hierarchy\"><h4>Files</h4><div class='dependency'><a href='source/Class.html#Ext-Class' target='_blank'>Class.js</a></div></pre><div class='doc-contents'><p>处理整个框架 类的创建。 这是由Ext.ClassManager使用的底层工厂，不宜直接使用。\n如果您选择使用Ext.Class，你将失去命名空间， 混淆和依赖加载功能可通过Ext.ClassManager取得。\n你唯一一次使用Ext.Class，是通过Ext.Class直接创建匿名类。</p>\n\n<p>如果你想创建类，你应该使用<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>别名<a href=\"#!/api/Ext.ClassManager-method-create\" rel=\"Ext.ClassManager-method-create\" class=\"docClass\">Ext.ClassManager.create</a>启用命名空间和动态的依赖分离度。</p>\n\n<p>Ext.Class仅仅是工厂，它不是超类（superclass）的所有。\n所有Ext类继承Base类，请参阅<a href=\"#!/api/Ext.Base\" rel=\"Ext.Base\" class=\"docClass\">Ext.Base</a>。</p>\n</div><div class='members'><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-cfg'>Config options</h3><div class='subsection'><div id='cfg-alias' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/ClassManager.html#Ext-Class-cfg-alias' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-alias' class='name expandable'>alias</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a>[]</span></div><div class='description'><div class='short'>别名 类名称简短的别名列表。多数用于微件定义xtypes：\n\nExt.define('MyApp.CoolPanel', {\n    extend: 'Ext.panel.Panel',\n    alias: ['widget.coo...</div><div class='long'><p>别名 类名称简短的别名列表。多数用于微件定义xtypes：</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('MyApp.CoolPanel', {\n    extend: '<a href=\"#!/api/Ext.panel.Panel\" rel=\"Ext.panel.Panel\" class=\"docClass\">Ext.panel.Panel</a>',\n    alias: ['widget.coolpanel'],\n    title: 'Yeah!'\n});\n\n// 使用 <a href=\"#!/api/Ext-method-create\" rel=\"Ext-method-create\" class=\"docClass\">Ext.create</a>\n<a href=\"#!/api/Ext-method-create\" rel=\"Ext-method-create\" class=\"docClass\">Ext.create</a>('widget.coolpanel');\n\n// 使用速记定义微件的xtype\n<a href=\"#!/api/Ext-method-widget\" rel=\"Ext-method-widget\" class=\"docClass\">Ext.widget</a>('panel', {\n    items: [\n        {xtype: 'coolpanel', html: 'Foo'},\n        {xtype: 'coolpanel', html: 'Bar'}\n    ]\n});\n</code></pre>\n\n<p>除了\"微件\"的xtype还有\"插件\"的ftype,\"功能\"的ptype等别名命名空间。</p>\n</div></div></div><div id='cfg-alternateClassName' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/ClassManager.html#Ext-Class-cfg-alternateClassName' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-alternateClassName' class='name expandable'>alternateClassName</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a>/<a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a>[]</span></div><div class='description'><div class='short'>备用类名 这个类定义备用名称。例如：\n\n//开发人员\nExt.define('Developer', {\n    alternateClassName: ['Coder', 'Hacker'],\n    code: function(...</div><div class='long'><p>备用类名 这个类定义备用名称。例如：</p>\n\n<pre><code>//开发人员\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Developer', {\n    alternateClassName: ['Coder', 'Hacker'],\n    code: function(msg) {\n        alert('Typing... ' + msg);\n    }\n});\n\nvar joe = <a href=\"#!/api/Ext-method-create\" rel=\"Ext-method-create\" class=\"docClass\">Ext.create</a>('Developer');\njoe.code('stackoverflow'); //栈溢出\n\nvar rms = <a href=\"#!/api/Ext-method-create\" rel=\"Ext-method-create\" class=\"docClass\">Ext.create</a>('Hacker');//黑客\nrms.code('hack hack');\n</code></pre>\n</div></div></div><div id='cfg-config' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-cfg-config' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-config' class='name expandable'>config</a><span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a></span></div><div class='description'><div class='short'>配置\n配置它们的选项列表默认值，自动产生存取方法。 ...</div><div class='long'><p>配置\n配置它们的选项列表默认值，自动产生存取方法。\n例如:</p>\n\n<pre><code>//构造一台智能手机\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('SmartPhone', {\n     config: {\n         hasTouchScreen: false,//有触摸屏\n         operatingSystem: 'Other',//操作系统\n         price: 500//价格\n     },\n     constructor: function(cfg) {\n         this.initConfig(cfg);\n     }\n});\n//iPhone手机\nvar iPhone = new SmartPhone({\n     hasTouchScreen: true,\n     operatingSystem: 'iOS'\n});\n\niPhone.getPrice(); // 500;\niPhone.getOperatingSystem(); // 'iOS'\niPhone.getHasTouchScreen(); // true;\n</code></pre>\n</div></div></div><div id='cfg-extend' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-cfg-extend' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-extend' class='name expandable'>extend</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a></span></div><div class='description'><div class='short'>继承\n继承父类。 ...</div><div class='long'><p>继承\n继承父类。 例如:</p>\n\n<pre><code>//构造人类\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Person', {\n    say: function(text) { alert(text); }//具有说的方法\n});\n</code></pre>\n\n<p>   //构造开发人员</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Developer', {\n    extend: 'Person',//继承人类\n    say: function(text) { this.callParent([\"print \"+text]); }//继承了说的方法\n});\n</code></pre>\n</div></div></div><div id='cfg-inheritableStatics' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-cfg-inheritableStatics' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-inheritableStatics' class='name expandable'>inheritableStatics</a><span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a></span></div><div class='description'><div class='short'>可继承静态\n继承这个类的静态方法清单。 ...</div><div class='long'><p>可继承静态\n继承这个类的静态方法清单。\n另外的就像<a href=\"#!/api/Ext.Class-cfg-statics\" rel=\"Ext.Class-cfg-statics\" class=\"docClass\">statics</a> 但子类继承这些方法。</p>\n</div></div></div><div id='cfg-mixins' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-cfg-mixins' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-mixins' class='name expandable'>mixins</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a>[]/<a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a></span></div><div class='description'><div class='short'>混入\n混入这个类的类列表。例如：\n\n//唱歌\nExt.define('CanSing', {\n     sing: function() {\n         alert(\"I'm on the highway to hell...我...</div><div class='long'><p>混入\n混入这个类的类列表。例如：</p>\n\n<pre><code>//唱歌\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('CanSing', {\n     sing: function() {\n         alert(\"I'm on the highway to hell...我在地狱的公路......\")\n     }\n});\n//音乐家\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Musician', {\n     mixins: ['CanSing']\n})\n</code></pre>\n\n<p>在这种情况下的音乐家类将获得的<code>唱</code>CanSing混入的方法。</p>\n\n<p>但是，如果音乐家已经有'唱'的方法呢？或者你想混入两个类，这两个类都要定义<code>唱</code>吗？\n在这种情况下，它最好定义混入对象，为每个混入指派名称：</p>\n\n<pre><code>//音乐家\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Musician', {\n     mixins: {\n         canSing: 'CanSing'//唱歌\n     },\n\n     sing: function() {\n         // 唱歌操作委托到混入\n         this.mixins.canSing.sing.call(this);\n     }\n})\n</code></pre>\n\n<p><code>唱</code>音乐家的方法的在这种情况下的将覆盖在<code>唱</code>方法的混入。\n但您可以通过特殊的<code>混入</code>属性，访问有的混合方法。</p>\n</div></div></div><div id='cfg-requires' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Loader.html#Ext-Class-cfg-requires' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-requires' class='name expandable'>requires</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a>[]</span></div><div class='description'><div class='short'>需要的类列表（数组） 实例化类之前必须加载的类列表\n例如：\n\nExt.define('Mother', {\n    requires: ['Child'],\n    giveBirth: function() {\n        //...</div><div class='long'><p>需要的类列表（数组） 实例化类之前必须加载的类列表\n例如：</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Mother', {\n    requires: ['Child'],\n    giveBirth: function() {\n        // 确保Child类是可用的。\n        return new Child();\n    }\n});\n</code></pre>\n</div></div></div><div id='cfg-singleton' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/ClassManager.html#Ext-Class-cfg-singleton' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-singleton' class='name expandable'>singleton</a><span> : <a href=\"#!/api/Boolean\" rel=\"Boolean\" class=\"docClass\">Boolean</a></span></div><div class='description'><div class='short'>单例 当设置为true，这个类将被实例化为单例。例如：\n\n//记录器\nExt.define('Logger', {\n    singleton: true,\n    log: function(msg) {\n        conso...</div><div class='long'><p>单例 当设置为true，这个类将被实例化为单例。例如：</p>\n\n<pre><code>//记录器\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Logger', {\n    singleton: true,\n    log: function(msg) {\n        console.log(msg);\n    }\n});\n\nLogger.log('Hello');\n</code></pre>\n</div></div></div><div id='cfg-statics' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-cfg-statics' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-statics' class='name expandable'>statics</a><span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a></span></div><div class='description'><div class='short'>静态\n这个类的静态方法的清单。例如：\n\n //构造一台计算机\nExt.define('Computer', {\n     statics: {\n         factory: function(brand) {\n         ...</div><div class='long'><p>静态\n这个类的静态方法的清单。例如：</p>\n\n<pre><code> //构造一台计算机\n<a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Computer', {\n     statics: {\n         factory: function(brand) {\n             // 'this' 在静态方法中是指类本身\n             return new this(brand);\n         }\n     },\n\n     constructor: function() { ... }//构造函数\n});\n//创建一台戴尔电脑\nvar dellComputer = Computer.factory('Dell');\n</code></pre>\n</div></div></div><div id='cfg-uses' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Loader.html#Ext-Class-cfg-uses' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-cfg-uses' class='name expandable'>uses</a><span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a>[]</span></div><div class='description'><div class='short'>提供可选的类清单，加载相应的类。这些被创建的类不一定是之前加载过的，\n但要保证在Ext.onReady之前侦听被调用。 ...</div><div class='long'><p>提供可选的类清单，加载相应的类。这些被创建的类不一定是之前加载过的，\n但要保证在Ext.onReady之前侦听被调用。\n例如：</p>\n\n<pre><code><a href=\"#!/api/Ext-method-define\" rel=\"Ext-method-define\" class=\"docClass\">Ext.define</a>('Mother', {\n    uses: ['Child'],\n    giveBirth: function() {//生产\n        // 此代码可能无法正常工作：\n        // return new Child();\n\n        // 改为使用 <a href=\"#!/api/Ext-method-create\" rel=\"Ext-method-create\" class=\"docClass\">Ext.create</a>() \n        return <a href=\"#!/api/Ext-method-create\" rel=\"Ext-method-create\" class=\"docClass\">Ext.create</a>('Child');\n    }\n});\n</code></pre>\n</div></div></div></div></div><div class='members-section'><div class='definedBy'>Defined By</div><h3 class='members-title icon-property'>Properties</h3><div class='subsection'><div id='property-defaultPreprocessors' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-property-defaultPreprocessors' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-property-defaultPreprocessors' class='name expandable'>defaultPreprocessors</a><span> : <a href=\"#!/api/Array\" rel=\"Array\" class=\"docClass\">Array</a></span><strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<p>Defaults to: <code>[]</code></p></div></div></div><div id='property-preprocessors' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-property-preprocessors' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-property-preprocessors' class='name expandable'>preprocessors</a><span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a></span><strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<p>Defaults to: <code>{}</code></p></div></div></div></div></div><div class='members-section'><h3 class='members-title icon-method'>Methods</h3><div class='subsection'><div class='definedBy'>Defined By</div><h4 class='members-subtitle'>Instance Methods</h3><div id='method-constructor' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-method-constructor' target='_blank' class='view-source'>view source</a></div><strong class='new-keyword'>new</strong><a href='#!/api/Ext.Class-method-constructor' class='name expandable'>Ext.Class</a>( <span class='pre'><a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> data, <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a> onCreated</span> ) : <a href=\"#!/api/Ext.Base\" rel=\"Ext.Base\" class=\"docClass\">Ext.Base</a></div><div class='description'><div class='short'>构造\n创建新的匿名类。 ...</div><div class='long'><p>构造\n创建新的匿名类。</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>data</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>代表这个类的对象属性</p>\n</div></li><li><span class='pre'>onCreated</span> : <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a><div class='sub-desc'><p>可选，完全创建这个类时要执行的回调函数。\n需要注意的是创建过程中，可以是异步的，取决于所使用的预处理器。</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Base\" rel=\"Ext.Base\" class=\"docClass\">Ext.Base</a></span><div class='sub-desc'><p>新创建的类</p>\n</div></li></ul></div></div></div><div id='method-create' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-method-create' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-method-create' class='name expandable'>create</a>( <span class='pre'><a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> Class, <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> classData, <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> onClassCreated</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>Class</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>类</p>\n</div></li><li><span class='pre'>classData</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>类数据</p>\n</div></li><li><span class='pre'>onClassCreated</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>类创建函数</p>\n</div></li></ul></div></div></div><div id='method-getPreprocessors' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-method-getPreprocessors' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-method-getPreprocessors' class='name expandable'>getPreprocessors</a>( <span class='pre'></span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'>得到预处理器 ...</div><div class='long'><p>得到预处理器</p>\n</div></div></div><div id='method-onBeforeCreated' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-method-onBeforeCreated' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-method-onBeforeCreated' class='name expandable'>onBeforeCreated</a>( <span class='pre'><a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> Class, <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> data, <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> hooks</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>Class</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>类</p>\n</div></li><li><span class='pre'>data</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>数据</p>\n</div></li><li><span class='pre'>hooks</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>钩子</p>\n</div></li></ul></div></div></div><div id='method-process' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-method-process' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-method-process' class='name expandable'>process</a>( <span class='pre'><a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> Class, <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> data, <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a> onCreated</span> )<strong class='private signature'>private</strong></div><div class='description'><div class='short'> ...</div><div class='long'>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>Class</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>类</p>\n</div></li><li><span class='pre'>data</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>数据</p>\n</div></li><li><span class='pre'>onCreated</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>创建函数</p>\n</div></li></ul></div></div></div></div><div class='subsection'><div class='definedBy'>Defined By</div><h4 class='members-subtitle'>Static Methods</h3><div id='static-method-getDefaultPreprocessors' class='member first-child not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-static-method-getDefaultPreprocessors' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-static-method-getDefaultPreprocessors' class='name expandable'>getDefaultPreprocessors</a>( <span class='pre'></span> ) : <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a>[]<strong class='private signature'>private</strong><strong class='static signature'>static</strong></div><div class='description'><div class='short'>检索数组栈的默认预处理器 ...</div><div class='long'><p>检索数组栈的默认预处理器</p>\n<h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a>[]</span><div class='sub-desc'><p>defaultPreprocessors 默认预处理器</p>\n</div></li></ul></div></div></div><div id='static-method-getPreprocessor' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-static-method-getPreprocessor' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-static-method-getPreprocessor' class='name expandable'>getPreprocessor</a>( <span class='pre'><a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a> name</span> ) : <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a><strong class='private signature'>private</strong><strong class='static signature'>static</strong></div><div class='description'><div class='short'>检索其名称的预处理器的回调函数，在这之前已注册 ...</div><div class='long'><p>检索其名称的预处理器的回调函数，在这之前已注册</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>名称</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a></span><div class='sub-desc'><p>preprocessor 预处理</p>\n</div></li></ul></div></div></div><div id='static-method-registerPreprocessor' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-static-method-registerPreprocessor' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-static-method-registerPreprocessor' class='name expandable'>registerPreprocessor</a>( <span class='pre'><a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a> name, <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a> fn</span> ) : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a><strong class='private signature'>private</strong><strong class='static signature'>static</strong></div><div class='description'><div class='short'>注册新的类的创建过程中要使用移除预处理器 ...</div><div class='long'><p>注册新的类的创建过程中要使用移除预处理器</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>预处理器的名称</p>\n</div></li><li><span class='pre'>fn</span> : <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a><div class='sub-desc'><p>要执行的回调函数。典型的格式：</p>\n\n<pre><code>function(cls, data, fn) {\n    // 你的代码在这\n\n    // 执行此当处理完毕。\n    // 异步处理成功\n    if (fn) {\n        fn.call(this, cls, data);\n    }\n});\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>cls</span> : <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a><div class='sub-desc'><p>创建类</p>\n</div></li><li><span class='pre'>data</span> : <a href=\"#!/api/Object\" rel=\"Object\" class=\"docClass\">Object</a><div class='sub-desc'><p>通过属性集在<a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a>构造</p>\n</div></li><li><span class='pre'>fn</span> : <a href=\"#!/api/Function\" rel=\"Function\" class=\"docClass\">Function</a><div class='sub-desc'><p>预处理器完成后，无论是否同步处理或异步处理，都必须调用这个回调函数。</p>\n</div></li></ul></div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><div class='sub-desc'><p>this</p>\n</div></li></ul></div></div></div><div id='static-method-setDefaultPreprocessorPosition' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-static-method-setDefaultPreprocessorPosition' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-static-method-setDefaultPreprocessorPosition' class='name expandable'>setDefaultPreprocessorPosition</a>( <span class='pre'><a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a> name, <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a> offset, <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a> relativeName</span> ) : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a><strong class='private signature'>private</strong><strong class='static signature'>static</strong></div><div class='description'><div class='short'>可选择在预处理器堆栈中的具体位置，插入相应的预处理器。 ...</div><div class='long'><p>可选择在预处理器堆栈中的具体位置，插入相应的预处理器。\n例如:</p>\n\n<pre><code>Ext.Class.registerPreprocessor('debug', function(cls, data, fn) {\n    // 你的代码在这\n\n    if (fn) {\n        fn.call(this, cls, data);\n    }\n}).setDefaultPreprocessorPosition('debug', 'last');\n</code></pre>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>name</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>预处理器名称。\n注意在此之前注册registerPreprocessor</p>\n</div></li><li><span class='pre'>offset</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>插入的位置。四个可能的值是：\n'first', 'last', 或者: 'before', 'after' (相对提供的名称在第三个参数)</p>\n</div></li><li><span class='pre'>relativeName</span> : <a href=\"#!/api/String\" rel=\"String\" class=\"docClass\">String</a><div class='sub-desc'><p>相对名称</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><div class='sub-desc'><p>this</p>\n</div></li></ul></div></div></div><div id='static-method-setDefaultPreprocessors' class='member  not-inherited'><a href='#' class='side expandable'><span>&nbsp;</span></a><div class='title'><div class='meta'><span class='defined-in' rel='Ext.Class'>Ext.Class</span><br/><a href='source/Class.html#Ext-Class-static-method-setDefaultPreprocessors' target='_blank' class='view-source'>view source</a></div><a href='#!/api/Ext.Class-static-method-setDefaultPreprocessors' class='name expandable'>setDefaultPreprocessors</a>( <span class='pre'><a href=\"#!/api/Array\" rel=\"Array\" class=\"docClass\">Array</a> preprocessors</span> ) : <a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a><strong class='private signature'>private</strong><strong class='static signature'>static</strong></div><div class='description'><div class='short'>设置默认的预处理器的默认阵列堆叠 ...</div><div class='long'><p>设置默认的预处理器的默认阵列堆叠</p>\n<h3 class=\"pa\">Parameters</h3><ul><li><span class='pre'>preprocessors</span> : <a href=\"#!/api/Array\" rel=\"Array\" class=\"docClass\">Array</a><div class='sub-desc'><p>预处理器</p>\n</div></li></ul><h3 class='pa'>Returns</h3><ul><li><span class='pre'><a href=\"#!/api/Ext.Class\" rel=\"Ext.Class\" class=\"docClass\">Ext.Class</a></span><div class='sub-desc'><p>this</p>\n</div></li></ul></div></div></div></div></div></div></div>"});