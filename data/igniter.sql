-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 16 2015 г., 02:08
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `igniter`
--

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `avatar` varchar(250) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `email`, `avatar`, `password`) VALUES
(1, 'asdfasdf', 'asdfsafd@mail.ru', '', '827ccb0eea8a706c4c34a16891f84e7b'),
(6, 'OpenServer', 'hello.there@mail.ru', 'application/modules/user/img/OpenServer.jpg', '827ccb0eea8a706c4c34a16891f84e7b'),
(7, 'Friend', 'friend.there@mail.ru', 'application/modules/user/img/Friend.jpg', '827ccb0eea8a706c4c34a16891f84e7b'),
(8, 'Hello', 'hello.there@mail.ru', 'application/modules/user/img/Hello.jpg', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Структура таблицы `user_dialogues`
--

CREATE TABLE IF NOT EXISTS `user_dialogues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user_dialogues`
--

INSERT INTO `user_dialogues` (`id`, `creation_date`) VALUES
(1, '2015-10-14 20:41:55'),
(2, '2015-10-14 20:41:55');

-- --------------------------------------------------------

--
-- Структура таблицы `user_dialogues_members`
--

CREATE TABLE IF NOT EXISTS `user_dialogues_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dialogue_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `dialogue_id` (`dialogue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user_dialogues_members`
--

INSERT INTO `user_dialogues_members` (`id`, `user_id`, `dialogue_id`, `status`) VALUES
(1, 6, 1, '1'),
(2, 7, 1, '1'),
(3, 6, 2, '1'),
(4, 8, 2, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dialogue_id` int(11) NOT NULL,
  `data` tinytext NOT NULL,
  `stamp` datetime NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`dialogue_id`),
  KEY `dialogue_id` (`dialogue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `user_messages`
--

INSERT INTO `user_messages` (`id`, `user_id`, `dialogue_id`, `data`, `stamp`, `status`) VALUES
(1, 6, 1, 'Привет, как дела?)', '2015-10-14 20:49:31', '0'),
(2, 8, 2, 'Хай!)', '2015-10-14 20:49:31', '1'),
(3, 7, 1, 'Хай!)', '2015-10-14 16:49:31', '1'),
(6, 6, 1, 'Как ты там?', '2015-10-15 01:43:54', '0'),
(7, 8, 2, 'Эй, ты!)', '2015-10-15 20:56:35', '1'),
(8, 6, 1, 'Чувааак', '2015-10-15 22:04:50', '0'),
(9, 6, 1, 'Ты куда пропал?', '2015-10-16 00:50:53', '1'),
(20, 6, 1, 'фывыфвфыв', '2015-10-16 00:59:12', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `user_message_status`
--

CREATE TABLE IF NOT EXISTS `user_message_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `have_read` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `message_id` (`message_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Дамп данных таблицы `user_message_status`
--

INSERT INTO `user_message_status` (`id`, `user_id`, `message_id`, `status`, `have_read`) VALUES
(27, 6, 1, '1', '1'),
(28, 7, 1, '1', '1'),
(29, 6, 3, '1', '1'),
(30, 7, 3, '1', '1'),
(31, 6, 6, '0', '1'),
(32, 7, 6, '1', '1'),
(33, 8, 2, '1', '1'),
(34, 6, 2, '1', '1'),
(35, 6, 7, '1', '1'),
(36, 8, 7, '1', '1'),
(37, 6, 8, '1', '1'),
(38, 7, 8, '1', '1'),
(47, 6, 20, '1', '1'),
(48, 7, 20, '1', '0');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `user_dialogues_members`
--
ALTER TABLE `user_dialogues_members`
  ADD CONSTRAINT `user_dialogues_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_dialogues_members_ibfk_2` FOREIGN KEY (`dialogue_id`) REFERENCES `user_dialogues` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_messages_ibfk_2` FOREIGN KEY (`dialogue_id`) REFERENCES `user_dialogues` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_message_status`
--
ALTER TABLE `user_message_status`
  ADD CONSTRAINT `user_message_status_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_message_status_ibfk_2` FOREIGN KEY (`message_id`) REFERENCES `user_messages` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
