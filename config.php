<?php

// 数据库连接信息
define('DBHostname','localhost');
define('DBUsername','root');
define('DBPassword','mypassword');
define('DBSchema','mydb');

// 目录信息
define('PATH_HANDOUTS','/handouts/');
define('PATH_SUBMITS','/submits/');  // without $_SERVER['DOCUMENT_ROOT']
define('PATH_REMARKS','remark.txt');

// 站点设置
define('SITENAME','schoolwork_manager');
define('MODE_DEBUG',false);

// 消息数量控制
define('MAX_DISPLAY_MESSAGE',15);
define('MAX_DISPLAY_ANNOUNCE',5);

// 管理员
$SUPERUSERS = [
    'joseph',
    'admin'
];

// 作业列表
$SUBMIT_CONTENT = [
    'Lab1' => 'Lab1-C# Basics',
	'Lab2' => 'Lab2-WinForm',
	'Lab3' => 'Lab3-WPF',
	'Lab4' => 'Lab4-GDI+',
	'Lab5' => 'Lab5-ADO.NET-1',
	'Lab6' => 'Lab6-ADO.NET-2',
	'Lab7' => 'Lab7-ASP.NET&LINQ',
	//'Lab8' => 'Lab8-ASP.NET MVC',
    'Ex1' => 'Ex1-乘法表',
	'Ex2' => 'Ex2-平均值',
	'Ex3' => 'Ex3-计算器',
	'Ex4' => 'Ex4-求和溢出',
	'Ex5' => 'Ex5-函数参数',
	'Ex6' => 'Ex6-继承重写',
	'Ex7' => 'Ex7-委托',
	'Ex8' => 'Ex8-动态链接',
	'Ex9' => 'Ex9-多线程'
];

// 作业可提交开关
$ALLOWED_SUBMIT = [
    //'Lab1',
	//'Lab2',
    //'Lab3',
	//'Lab4',
	//'Lab5',
	//'Lab6',
	//'Lab7',
	//'Lab8',
	'Ex1',
	//'Ex2',
	//'Ex3',
	//'Ex4',
	//'Ex5',
	//'Ex6',
	//'Ex7',
	//'Ex8',
	//'Ex9'
];

// 作业可批改开关
$ALLOWED_CHECK = [
    'Lab1',
	'Lab2',
	'Lab3',
	'Lab4',
	'Lab5',
    'Lab6',
	'Lab7',
	//'Lab8',
	'Ex1',
	'Ex2',
	'Ex3',
	'Ex4',
	'Ex5',
	'Ex6',
	'Ex7',
	'Ex8',
	'Ex9'
];

// 作业给分档级
$ALLOWED_GRADE = [
    10,
	8,
	6,
	0,
	-1
];