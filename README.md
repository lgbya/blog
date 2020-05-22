## Laravel-admin版个人博客
`   

    一, 执行建库语句
    create database blog charset utf8 collate utf8_bin;

    二, 修改.env.example 为 .env

    三, 修改.env 下的以下字段
    DB_USERNAME=mysql账号
    DB_PASSWORD=mysql密码

    
    四, 执行./install.sh, 在执行前请注意以下几点
    1, 务必安装好composer并设置为composer 的bin命令
    2, 在php.ini中，找到disable_functions选项，看看后面是否有proc_open,proc_get_status函数被禁用了，如果有的话，去掉即可
    
    五, 访问后台，http://域名/admin 
    账号:admin
    密码:admin
` 
