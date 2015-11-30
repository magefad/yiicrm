SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `fadcrm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fad_auth_assignment`
--

CREATE TABLE IF NOT EXISTS `fad_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_auth_item`
--

CREATE TABLE IF NOT EXISTS `fad_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_auth_item_child`
--

CREATE TABLE IF NOT EXISTS `fad_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `fk_fad_auth_item_child_fad_auth_item_child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_client`
--

CREATE TABLE IF NOT EXISTS `fad_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name_company` varchar(255) DEFAULT NULL,
  `name_contact` varchar(255) DEFAULT NULL,
  `time_zone` tinyint(4) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `cp` tinyint(1) DEFAULT NULL,
  `call_source` tinyint(4) DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `next_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_id` (`id`),
  UNIQUE KEY `ux_project_id_client_id` (`project_id`,`client_id`),
  KEY `project_id` (`project_id`),
  KEY `manager_id` (`create_user_id`),
  KEY `update_user_id` (`update_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12055 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_client_order`
--

CREATE TABLE IF NOT EXISTS `fad_client_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `number` tinyint(4) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `product` varchar(255) NOT NULL,
  `client_request` text NOT NULL,
  `sponsor` varchar(100) NOT NULL,
  `comment_history` text NOT NULL,
  `status_fail` tinyint(4) DEFAULT NULL,
  `comment_fail` text NOT NULL,
  `contract_copy` tinyint(1) DEFAULT NULL,
  `comment_review` text NOT NULL,
  `photo` int(11) DEFAULT NULL,
  `description_production` text NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id_2` (`client_id`,`number`),
  KEY `client_id` (`client_id`,`create_user_id`),
  KEY `create_user_id` (`create_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12015 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_partner`
--

CREATE TABLE IF NOT EXISTS `fad_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_short` varchar(3) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_partner_project`
--

CREATE TABLE IF NOT EXISTS `fad_partner_project` (
  `partner_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  UNIQUE KEY `partner_id` (`partner_id`,`project_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_payment`
--

CREATE TABLE IF NOT EXISTS `fad_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `partner_id` int(11) NOT NULL,
  `name_company` varchar(100) DEFAULT NULL,
  `name_contact` varchar(100) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `payment_amount` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `payment_remain` int(11) DEFAULT NULL,
  `agent_comission_percent` varchar(14) DEFAULT NULL,
  `agent_comission_amount` int(11) DEFAULT NULL,
  `agent_comission_received` int(11) DEFAULT NULL,
  `agent_comission_remain_amount` int(11) DEFAULT NULL,
  `agent_comission_remain_now` int(11) DEFAULT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `partner_id` (`partner_id`),
  KEY `create_user_id` (`create_user_id`),
  KEY `update_user_id` (`update_user_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=964 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_payment_money`
--

CREATE TABLE IF NOT EXISTS `fad_payment_money` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `method` tinyint(4) DEFAULT NULL,
  `payment_id` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `payment_id` (`payment_id`,`create_user_id`,`update_user_id`),
  KEY `create_user_id` (`create_user_id`),
  KEY `update_user_id` (`update_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1922 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_project`
--

CREATE TABLE IF NOT EXISTS `fad_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `name_short` varchar(3) NOT NULL,
  `count_client` int(11) NOT NULL,
  `count_payment` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_project_user`
--

CREATE TABLE IF NOT EXISTS `fad_project_user` (
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  UNIQUE KEY `project_id` (`project_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_settings`
--

CREATE TABLE IF NOT EXISTS `fad_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(32) NOT NULL,
  `key` varchar(32) NOT NULL,
  `value` varchar(255) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ix_fad_settings_module_id` (`module_id`),
  KEY `ix_fad_settings_create_user_id` (`create_user_id`),
  KEY `ix_fad_settings_update_user_id` (`update_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_user`
--

CREATE TABLE IF NOT EXISTS `fad_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(150) DEFAULT NULL,
  `lastname` varchar(150) DEFAULT NULL,
  `username` varchar(150) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `birth_date` date DEFAULT NULL,
  `country` varchar(50) NOT NULL DEFAULT '',
  `city` varchar(50) NOT NULL DEFAULT '',
  `phone` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `access_level` tinyint(1) NOT NULL DEFAULT '0',
  `last_visit` datetime DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `registration_ip` varchar(20) NOT NULL,
  `activation_ip` varchar(20) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `use_gravatar` tinyint(1) NOT NULL DEFAULT '0',
  `activate_key` varchar(32) NOT NULL,
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_fad_user_username` (`username`),
  UNIQUE KEY `ux_fad_user_email` (`email`),
  KEY `ix_fad_user_status` (`status`),
  KEY `ix_fad_user_email_confirm` (`email_confirm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `fad_user_percent`
--

CREATE TABLE IF NOT EXISTS `fad_user_percent` (
  `user_id` int(11) NOT NULL,
  `from_sum` int(11) NOT NULL,
  `to_sum` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `percent` tinyint(4) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`,`from_sum`,`to_sum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `fad_auth_assignment`
--
ALTER TABLE `fad_auth_assignment`
  ADD CONSTRAINT `fk_fad_auth_assignment_fad_auth_item_name` FOREIGN KEY (`itemname`) REFERENCES `fad_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `fad_auth_item_child`
--
ALTER TABLE `fad_auth_item_child`
  ADD CONSTRAINT `fk_fad_auth_item_child_fad_auth_item_child` FOREIGN KEY (`child`) REFERENCES `fad_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fad_auth_item_child_fad_auth_item_parent` FOREIGN KEY (`parent`) REFERENCES `fad_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `fad_client`
--
ALTER TABLE `fad_client`
  ADD CONSTRAINT `fad_client_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `fad_project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_client_ibfk_2` FOREIGN KEY (`create_user_id`) REFERENCES `fad_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_client_ibfk_3` FOREIGN KEY (`update_user_id`) REFERENCES `fad_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `fad_client_order`
--
ALTER TABLE `fad_client_order`
  ADD CONSTRAINT `fad_client_order_ibfk_2` FOREIGN KEY (`create_user_id`) REFERENCES `fad_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_client_order_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `fad_client` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `fad_partner_project`
--
ALTER TABLE `fad_partner_project`
  ADD CONSTRAINT `fad_partner_project_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `fad_partner` (`id`),
  ADD CONSTRAINT `fad_partner_project_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `fad_project` (`id`);

--
-- Ограничения внешнего ключа таблицы `fad_payment`
--
ALTER TABLE `fad_payment`
  ADD CONSTRAINT `fad_payment_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `fad_client` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_payment_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `fad_client_order` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_payment_ibfk_3` FOREIGN KEY (`partner_id`) REFERENCES `fad_partner` (`id`),
  ADD CONSTRAINT `fad_payment_ibfk_4` FOREIGN KEY (`create_user_id`) REFERENCES `fad_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_payment_ibfk_5` FOREIGN KEY (`update_user_id`) REFERENCES `fad_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `fad_payment_money`
--
ALTER TABLE `fad_payment_money`
  ADD CONSTRAINT `fad_payment_money_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `fad_payment` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_payment_money_ibfk_2` FOREIGN KEY (`create_user_id`) REFERENCES `fad_user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fad_payment_money_ibfk_3` FOREIGN KEY (`update_user_id`) REFERENCES `fad_user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `fad_project_user`
--
ALTER TABLE `fad_project_user`
  ADD CONSTRAINT `fad_project_user_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `fad_project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fad_project_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `fad_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `fad_settings`
--
ALTER TABLE `fad_settings`
  ADD CONSTRAINT `fk_fad_settings_fad_user_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `fad_user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fad_settings_fad_user_update_user_id` FOREIGN KEY (`update_user_id`) REFERENCES `fad_user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `fad_user_percent`
--
ALTER TABLE `fad_user_percent`
  ADD CONSTRAINT `fad_user_percent_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `fad_user` (`id`);
