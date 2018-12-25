DECCATECH CMS nginx 伪静态规则
==========================
   为了让DECCATECH CMS 更好的在Nginx+fastcig环境下运行，笛卡官方做成如下示范文件，如下列所示，其中笛卡配置是必须要引入的，基础配置、首页入口、
php运行模式需要您根据自己的服务器环境做出最优的配置与优化。

#server {
#    #基础配置
#    server_name www.deccatech.cn 127.0.0.1;
#    listen 80 ;
#    index index.php;
#	 root /www/web/deccatech;
#
#	#首页入口
#	location / {
#	    index index.php index.html index.htm;
#	    try_files $uri $uri/ index.php$uri?$args;
#	}
#
#	#PHP 运行模式
#	location ~ ^(.+.php)(.*)$ {
#	    fastcgi_split_path_info ^(.+.php)(.*)$;
#	    fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
#	    fastcgi_param  SCRIPT_FILENAME    $document_root/$fastcgi_script_name;
#	    fastcgi_param  PATH_INFO          $fastcgi_path_info;
#	    include fastcgi.conf;
#	    fastcgi_pass  127.0.0.1:9000;
#	    fastcgi_index index.php;
#	}
#
#    #笛卡配置 deccatech_conf
#    #笛卡已将你所需要的nginx配置文件，统一整理到了网站根目录下 stourweb_conf/nginx/中，除system.conf(系统标准配置)外，其他均为应用配置
#    #在线安装完成以后，只需重新启动nginx，不再做其他配置即可使用
#    #/www/web/deccatech为网站根目录，需您根据自己的需要重新配置
#    include /www/web/deccatech/deccatech_conf/nginx/*.conf;
#}

  感谢您一直以来对笛卡cms的支持，如有疑问请联系我们！！