USE csharper;

-- Create Tables
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账户流水号',
  `username` varchar(45) NOT NULL COMMENT '用户名为学号，对应submission.SID',
  `password` varchar(45) NOT NULL COMMENT '初始密码为4位字母',
  `displayname` varchar(45) NOT NULL COMMENT '学生姓名',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最末一次账户修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `submission` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '提交记录流水号',
  `SID` varchar(45) NOT NULL COMMENT '学号，对应user.username',
  `work` char(5) NOT NULL COMMENT '作业名，''Lab1''/''Ex1''等',
  `path` varchar(150) NOT NULL COMMENT '上传的文件路径',
  `score` smallint(4) DEFAULT NULL COMMENT '十分制成绩，未登记时为空',
  `remark` varchar(200) DEFAULT NULL COMMENT '评价',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最末一次提交更新的时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `announce` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水号',
  `title` varchar(60) NOT NULL COMMENT '公告标题',
  `text` text NOT NULL COMMENT '公告内容',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '公告发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '流水号',
  `poster` varchar(45) DEFAULT NULL COMMENT '发布者，可空匿名，为学号对应user.username',
  `message` text NOT NULL COMMENT '留言内容',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- Supuerusers
INSERT INTO user (username, password, displayname) VALUES ('kahsolt','1379','Kahsolt');
INSERT INTO user (username, password, displayname) VALUES ('tkhkdjt','cs2017','Tkhkdjt');