DROP TABLE IF EXISTS `sulata_blank`;
CREATE TABLE `sulata_blank` (`__ID` int(11) NOT NULL,`__Sort_Order` int(11) NOT NULL DEFAULT '0',`__Last_Action_On` datetime NOT NULL,`__Last_Action_By` varchar(64) NOT NULL,`__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sulata_faqs`;
CREATE TABLE `sulata_faqs` (`faq__ID` int(11) NOT NULL,`faq__Question` varchar(255) NOT NULL COMMENT '|s',`faq__Answer` text NOT NULL,`faq__Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active' COMMENT '|s',`faq__Sort_Order` int(11) NOT NULL DEFAULT '0',`faq__Last_Action_On` datetime NOT NULL,`faq__Last_Action_By` varchar(64) NOT NULL,`faq__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sulata_groups`;
CREATE TABLE `sulata_groups` (`group__ID` int(11) NOT NULL,`group__Name` varchar(64) NOT NULL COMMENT '|s',`group__Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active' COMMENT '|s',`group__Permissions` text NOT NULL,`group__Sort_Order` int(11) NOT NULL DEFAULT '0',`group__Last_Action_On` datetime NOT NULL,`group__Last_Action_By` varchar(64) NOT NULL,`group__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `sulata_groups` (`group__ID`, `group__Name`, `group__Status`, `group__Permissions`, `group__Sort_Order`, `group__Last_Action_On`, `group__Last_Action_By`, `group__dbState`) VALUES
(1, 'Super Admin', 'Active', '[\"faqs-view\",\"faqs-preview\",\"faqs-search\",\"faqs-add\",\"faqs-update\",\"faqs-delete\",\"faqs-restore\",\"faqs-sort\",\"faqs-duplicate\",\"faqs-downloadcsv\",\"faqs-downloadpdf\",\"groups-view\",\"groups-preview\",\"groups-search\",\"groups-add\",\"groups-update\",\"groups-delete\",\"groups-restore\",\"groups-sort\",\"groups-duplicate\",\"groups-downloadcsv\",\"groups-downloadpdf\",\"headers-view\",\"headers-preview\",\"headers-search\",\"headers-add\",\"headers-update\",\"headers-delete\",\"headers-restore\",\"headers-sort\",\"headers-duplicate\",\"headers-downloadcsv\",\"headers-downloadpdf\",\"media-view\",\"media-preview\",\"media-search\",\"media-add\",\"media-update\",\"media-delete\",\"media-restore\",\"media-sort\",\"media-duplicate\",\"media-downloadcsv\",\"media-downloadpdf\",\"pages-view\",\"pages-preview\",\"pages-search\",\"pages-add\",\"pages-update\",\"pages-delete\",\"pages-restore\",\"pages-sort\",\"pages-duplicate\",\"pages-downloadcsv\",\"pages-downloadpdf\",\"users-view\",\"users-preview\",\"users-search\",\"users-add\",\"users-update\",\"users-delete\",\"users-restore\",\"users-sort\",\"users-duplicate\",\"users-downloadcsv\",\"users-downloadpdf\"]', 0, '2019-11-15 23:50:51', 'Super User', 'Live');
DROP TABLE IF EXISTS `sulata_headers`;
CREATE TABLE `sulata_headers` (`header__ID` int(11) NOT NULL,`header__Title` varchar(64) NOT NULL COMMENT '|s',`header__Picture` varchar(128) NOT NULL COMMENT '|s',`header__Sort_Order` int(11) NOT NULL DEFAULT '0',`header__Last_Action_On` datetime NOT NULL,`header__Last_Action_By` varchar(64) NOT NULL,`header__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sulata_media`;
CREATE TABLE `sulata_media` (`media__ID` int(11) NOT NULL,`media__Title` varchar(100) NOT NULL COMMENT '|s',`media__File` varchar(255) NOT NULL COMMENT '|s',`media__Sort_Order` int(11) NOT NULL DEFAULT '0',`media__Last_Action_On` datetime NOT NULL,`media__Last_Action_By` varchar(64) NOT NULL,`media__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sulata_pages`;
CREATE TABLE `sulata_pages` (`page__ID` int(11) NOT NULL,`page__Name` varchar(64) NOT NULL COMMENT '|s',`page__Permalink` varchar(64) NOT NULL,`page__Title` varchar(70) NOT NULL,`page__Keyword` varchar(255) NOT NULL,`page__Description` varchar(155) NOT NULL,`page__Header` int(11) NOT NULL COMMENT '|s|header__ID,header__Title',`page__Short_Text` text,`page__Long_Text` text NOT NULL,`page__Sort_Order` int(11) NOT NULL DEFAULT '0',`page__Last_Action_On` datetime NOT NULL,`page__Last_Action_By` varchar(64) NOT NULL,`page__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sulata_settings`;
CREATE TABLE `sulata_settings` (`setting__ID` int(11) NOT NULL,`setting__Type` enum('Text','Dropdown') NOT NULL,`setting__Options` varchar(50) DEFAULT NULL,`setting__Setting` varchar(64) NOT NULL COMMENT '|s',`setting__Key` varchar(64) NOT NULL,`setting__Value` varchar(256) NOT NULL COMMENT '|s',`setting__Scope` enum('Public','Private') NOT NULL DEFAULT 'Public',`setting__Sort_Order` int(11) NOT NULL DEFAULT '0',`setting__Last_Action_On` datetime NOT NULL,`setting__Last_Action_By` varchar(64) NOT NULL,`setting__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `sulata_settings` (`setting__ID`, `setting__Type`, `setting__Options`, `setting__Setting`, `setting__Key`, `setting__Value`, `setting__Scope`, `setting__Sort_Order`, `setting__Last_Action_On`, `setting__Last_Action_By`, `setting__dbState`) VALUES
(1, 'Text', NULL, 'Site Name', 'site_name', 'Rapid CMS', 'Public', 280, '2019-11-03 06:02:39', 'Installer', 'Live'),
(2, 'Text', NULL, 'Site Tagline', 'site_tagline', 'BackOffice', 'Public', 270, '2019-11-03 06:02:39', 'Installer', 'Live'),
(3, 'Text', NULL, 'Page Size', 'page_size', '24', 'Public', 240, '2019-11-03 06:02:39', 'Installer', 'Live'),
(4, 'Text', NULL, 'Time Zone', 'timezone', 'ASIA/KARACHI', 'Public', 230, '2019-11-03 06:02:39', 'Installer', 'Live'),
(5, 'Text', '', 'Date Format', 'date_format', 'mm-dd-yy', 'Private', 80, '2019-11-04 18:08:32', 'Installer', 'Live'),
(6, 'Text', NULL, 'Allowed File Formats', 'allowed_file_formats', 'doc,xls,docx,xlsx,ppt,pptx,pdf,gif,jpg,jpeg,png,zip', 'Private', 70, '2019-11-03 06:02:39', 'Installer', 'Live'),
(7, 'Text', NULL, 'Allowed Image Formats', 'allowed_image_formats', 'gif,jpg,jpeg,png', 'Private', 60, '2019-11-03 06:02:39', 'Installer', 'Live'),
(8, 'Text', NULL, 'Allowed Attachment Formats', 'allowed_attachment_formats', 'doc,xls,docx,xlsx,ppt,pptx,pdf,gif,jpg,jpeg,png', 'Private', 50, '2019-11-03 06:02:39', 'Installer', 'Live'),
(9, 'Text', NULL, 'Site Email', 'site_email', 'tahir@sulata.com.pk', 'Public', 260, '2019-11-03 06:02:39', 'Installer', 'Live'),
(10, 'Text', NULL, 'Site URL', 'site_url', 'http://www.sulata.com.pk', 'Public', 250, '2019-11-03 06:02:39', 'Installer', 'Live'),
(11, 'Text', NULL, 'Employee Image Height', 'employee_image_height', '150', 'Public', 220, '2019-11-03 06:02:39', 'Installer', 'Live'),
(12, 'Text', NULL, 'Employee Image Width', 'employee_image_width', '100', 'Public', 210, '2019-11-03 06:02:39', 'Installer', 'Live'),
(13, 'Text', NULL, 'Default Meta Title', 'default_meta_title', '-', 'Public', 200, '2019-11-03 06:02:39', 'Installer', 'Live'),
(14, 'Text', NULL, 'Default Meta Description', 'default_meta_description', '-', 'Public', 190, '2019-11-03 06:02:39', 'Installer', 'Live'),
(15, 'Text', NULL, 'Default Meta Keywords', 'default_meta_keywords', '-', 'Public', 180, '2019-11-03 06:02:39', 'Installer', 'Live'),
(16, 'Text', NULL, 'Default Theme', 'default_theme', 'default', 'Private', 40, '2019-11-03 06:02:39', 'Installer', 'Live'),
(21, 'Text', NULL, 'Site Footer', 'site_footer', 'Developed by Sulata iSoft.', 'Public', 130, '2019-11-03 06:02:39', 'Installer', 'Live'),
(22, 'Text', NULL, 'Site Footer Link', 'site_footer_link', 'http://www.sulata.com.pk', 'Public', 120, '2019-11-03 06:02:39', 'Installer', 'Live'),
(23, 'Dropdown', 'Sidebar,Top,Both', 'Module Position', 'module_position', 'Both', 'Public', 110, '2019-11-26 10:06:37', 'Installer', 'Live'),
(24, 'Dropdown', 'Yes,No', 'Allow Multiple Location Login', 'multi_login', 'No', 'Public', 90, '2019-11-15 14:51:04', 'Super User', 'Live'),
(25, 'Text', NULL, 'Site Currency', 'site_currency', 'US$', 'Public', 100, '2019-11-03 06:02:39', 'Installer', 'Live'),
(26, 'Text', '', 'Thumbnail Height', 'thumbnail_height', '100', 'Private', 30, '2019-11-04 18:50:38', 'Installer', 'Live'),
(27, 'Text', '', 'Thumbnail Width', 'thumbnail_width', '100', 'Private', 20, '2019-11-04 18:50:49', 'Installer', 'Live'),
(28, 'Text', '', 'Sorting Page Size', 'sorting_page_size', '500', 'Private', 10, '2019-11-05 10:27:17', 'Installer', 'Live'),
(29, 'Text', '', 'Super Admin Group ID', 'super_admin_group_id', '1', 'Private', 0, '2019-11-09 00:00:00', 'Installer', 'Live'),
(30, 'Text', '', 'Super Admin User ID', 'super_admin_user_id', '1', 'Private', 0, '2019-11-11 00:00:00', 'Installer', 'Live'),
(33, 'Dropdown', 'Yes,No', 'Show Password', 'show_password', 'Yes', 'Public', 0, '2019-11-23 14:26:35', 'Installer', 'Live'),
(34, 'Text', '', 'Maximum Top Menu Links', 'maximum_top_menu_links', '5', 'Public', 0, '2019-11-26 09:50:24', 'Installer', 'Live');

DROP TABLE IF EXISTS `sulata_users`;
CREATE TABLE `sulata_users` (`user__ID` int(11) NOT NULL,`user__Name` varchar(32) NOT NULL COMMENT '|s',`user__Email` varchar(64) NOT NULL COMMENT '|s',`user__Password` varchar(13) NOT NULL,`user__Picture` varchar(128) DEFAULT NULL,`user__Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active' COMMENT '|s',`user__Notes` text,`user__Theme` varchar(24) NOT NULL DEFAULT 'default',`user__Type` enum('Private','Public') NOT NULL DEFAULT 'Public',`user__Sort_Order` int(11) NOT NULL DEFAULT '0',`user__Password_Reset` enum('Yes','No') NOT NULL DEFAULT 'Yes',`user__Last_Action_On` datetime NOT NULL,`user__Last_Action_By` varchar(64) NOT NULL,`user__dbState` enum('Live','Deleted') NOT NULL,`user__IP` varchar(15) NOT NULL DEFAULT '127.0.0.1') ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `sulata_users` (`user__ID`, `user__Name`, `user__Email`, `user__Password`, `user__Picture`, `user__Status`, `user__Notes`, `user__Theme`, `user__Type`, `user__Sort_Order`, `user__Password_Reset`, `user__Last_Action_On`, `user__Last_Action_By`, `user__dbState`, `user__IP`) VALUES
(1, 'SuperUser', 'project@sulata.com.pk', 'project', '', 'Active', '', 'default', 'Private', 20, 'No', '2019-11-11 11:04:56', 'Iyaan Tahir Barry', 'Live', '127.0.0.1');
DROP TABLE IF EXISTS `sulata_user_groups`;
CREATE TABLE `sulata_user_groups` (`usergroup__ID` int(11) NOT NULL,`usergroup__Group` int(11) NOT NULL,`usergroup__User` int(11) NOT NULL,`usergroup__Sort_Order` int(11) NOT NULL DEFAULT '0',`usergroup__Last_Action_On` datetime NOT NULL,`usergroup__Last_Action_By` varchar(64) NOT NULL,`usergroup__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `sulata_links` (`link__ID` int(11) NOT NULL,`link__Link` varchar(64) NOT NULL COMMENT '|s',`link__File` varchar(64) NOT NULL COMMENT '|s',`link__Sort_Order` int(11) NOT NULL DEFAULT '0',`link__Last_Action_On` datetime NOT NULL,`link__Last_Action_By` varchar(64) NOT NULL,`link__dbState` enum('Live','Deleted') NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `sulata_links` (`link__ID`, `link__Link`, `link__File`, `link__Sort_Order`, `link__Last_Action_On`, `link__Last_Action_By`, `link__dbState`) VALUES (1, 'FAQs', 'faqs.php', 70, '2019-11-28 11:28:53', 'Installer', 'Live'),(2, 'Groups', 'groups.php', 20, '2019-11-28 11:28:53', 'Installer', 'Live'),(3, 'Headers', 'headers.php', 50, '2019-11-28 11:28:53', 'Installer', 'Live'),(4, 'Links', 'links.php', 10, '2019-11-28 11:28:53', 'Installer', 'Live'),(5, 'Media', 'media.php', 60, '2019-11-28 11:28:53', 'Installer', 'Live'),(7, 'Pages', 'pages.php', 80, '2019-11-28 11:28:53', 'Installer', 'Live'),(8, 'Settings', 'settings.php', 30, '2019-11-28 11:28:53', 'Installer', 'Live'),(9, 'Users', 'users.php', 40, '2019-11-28 11:28:53', 'Installer', 'Live');
ALTER TABLE `sulata_blank` ADD PRIMARY KEY (`__ID`);
ALTER TABLE `sulata_faqs` ADD PRIMARY KEY (`faq__ID`), ADD UNIQUE KEY `faq__Question` (`faq__Question`);
ALTER TABLE `sulata_groups` ADD PRIMARY KEY (`group__ID`), ADD UNIQUE KEY `|s` (`group__Name`);
ALTER TABLE `sulata_headers` ADD PRIMARY KEY (`header__ID`), ADD UNIQUE KEY `header__Title` (`header__Title`);
ALTER TABLE `sulata_media` ADD PRIMARY KEY (`media__ID`), ADD UNIQUE KEY `media__Title` (`media__Title`);
ALTER TABLE `sulata_pages` ADD PRIMARY KEY (`page__ID`), ADD UNIQUE KEY `page__Name` (`page__Name`);
ALTER TABLE `sulata_settings` ADD PRIMARY KEY (`setting__ID`), ADD UNIQUE KEY `setting__Setting` (`setting__Setting`), ADD UNIQUE KEY `setting__Key` (`setting__Key`);
ALTER TABLE `sulata_users` ADD PRIMARY KEY (`user__ID`), ADD UNIQUE KEY `user__Email` (`user__Email`);
ALTER TABLE `sulata_user_groups` ADD PRIMARY KEY (`usergroup__ID`);
ALTER TABLE `sulata_blank` MODIFY `__ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sulata_faqs` MODIFY `faq__ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sulata_groups` MODIFY `group__ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `sulata_headers` MODIFY `header__ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sulata_media` MODIFY `media__ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sulata_pages` MODIFY `page__ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sulata_settings` MODIFY `setting__ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
ALTER TABLE `sulata_users` MODIFY `user__ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `sulata_user_groups` MODIFY `usergroup__ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sulata_links` ADD PRIMARY KEY (`link__ID`), ADD UNIQUE KEY `link__Link` (`link__Link`), ADD UNIQUE KEY `link__File` (`link__File`);
ALTER TABLE `sulata_links` MODIFY `link__ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;