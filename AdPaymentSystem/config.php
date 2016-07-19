<?php
function FinancialSystem_Config(){
    return array(
	/*数据库配置 */
	'DB_TYPE'=>'mysql',   //设置数据库类型
	'DB_HOST'=>'localhost',//设置主机
	'DB_NAME'=>'adpayment',//设置数据库名
	'DB_USER'=>'root',    //设置用户名
	'DB_PWD'=>'123456',        //设置密码
	'DB_PORT'=>'3306',   //设置端口号
	'DB_PREFIX'=>'ad_',  //设置表前缀
    //SESSION设置
	'SESSION_EXPIRE'  =>'600',   // 默认Session有效期（10分钟）
    //模块配置
    'DEFAULT_MODULE'  => 'Home',
    /*调试配置*/
	'SHOW_PAGE_TRACE' => ture,//开启页面Trace
    //统一生成小写的URL地址
    'URL_CASE_INSENSITIVE' => true,
    );
}