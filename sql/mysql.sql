CREATE TABLE `jill_equipment_week` (
  `bsn` mediumint(9) unsigned NOT NULL COMMENT '預約編號',
  `week` tinyint(1) NOT NULL COMMENT '星期',
  `tsn` mediumint(8) unsigned NOT NULL COMMENT '時段編號',
  PRIMARY KEY (`bsn`,`week`,`tsn`)
) ENGINE=MyISAM;

CREATE TABLE `jill_equipment_date` (
  `bsn` mediumint(9) unsigned NOT NULL default 0 COMMENT '預約編號',
  `bdate` date NOT NULL COMMENT '預約日期',
  `tsn` mediumint(8) unsigned NOT NULL  COMMENT '時段編號',
  `status` enum('lend','order','back') NOT NULL COMMENT '狀態',
  `approver` mediumint(8)  unsigned NOT NULL default 0 COMMENT '審核者',
  `loan_date` datetime NOT NULL COMMENT '借出時間',
  `return_date` datetime NOT NULL COMMENT '實際歸還時間',
  `note` varchar(255) NOT NULL default '' COMMENT '備註',
  PRIMARY KEY (`bsn`,`bdate`,`tsn`)
) ENGINE=MyISAM  COMMENT='預約審核';

CREATE TABLE `jill_equipment_booking` (
  `bsn` mediumint(9) unsigned NOT NULL auto_increment COMMENT '預約編號',
  `buid` mediumint(8) unsigned NOT NULL default '0' COMMENT '預約者',
  `booking_time` datetime NOT NULL COMMENT '預約時間',
  `booking_content` text NOT NULL COMMENT '預約理由',
  `start` date NOT NULL COMMENT '開始日期',
  `end` date NOT NULL COMMENT '預定歸還日期',
  PRIMARY KEY (`bsn`)
) ENGINE=MyISAM  COMMENT='預約';


CREATE TABLE `jill_equipment_time` (
  `tsn` mediumint(8) unsigned NOT NULL auto_increment COMMENT '時段編號',
  `sn` smallint(6) unsigned NOT NULL default '0'  COMMENT '設備編號',
  `title` varchar(255) NOT NULL default '' COMMENT '時段標題',
  `tsort` smallint(6) unsigned NOT NULL default '0' COMMENT '時段排序',
  `open_week` set('0','1','2','3','4','5','6') NOT NULL default '1'  COMMENT '開放星期' ,
  PRIMARY KEY (`tsn`)
) ENGINE=MyISAM  COMMENT='時段';

CREATE TABLE `jill_equipment_cate` (
  `cate_id` mediumint(9) unsigned NOT NULL auto_increment COMMENT '分類編號',
  `cate_name` varchar(255) NOT NULL default '' COMMENT '分類名稱',
  `is_enable` enum('1','0') NOT NULL default '1' COMMENT '是否啟用',
  `cate_sort` smallint(6) unsigned NOT NULL default 0 COMMENT '排序',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM COMMENT='設備分類';


CREATE TABLE `jill_equipment` (
  `sn` mediumint(9) unsigned NOT NULL auto_increment COMMENT '設備編號',
  `cate_id` mediumint(9) unsigned NOT NULL default '0' COMMENT '分類編號',
  `title` varchar(255) NOT NULL default '' COMMENT '設備名稱',
  `directions` text NOT NULL COMMENT '設備說明',
  `total` int(10) NOT NULL default '0' COMMENT '數量',
  `auditor` text NOT NULL COMMENT '可審核人員',
  `booking_group` varchar(255) NOT NULL DEFAULT '[\"2\"]' COMMENT '可預約群組',
PRIMARY KEY  (`sn`)
) ENGINE=MyISAM COMMENT='設備';

