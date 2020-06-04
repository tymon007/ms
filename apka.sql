-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 04 2020 г., 22:23
-- Версия сервера: 10.3.22-MariaDB-log
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `apka`
--

-- --------------------------------------------------------

--
-- Структура таблицы `chats`
--

CREATE TABLE `chats` (
  `id` int(255) NOT NULL,
  `is_between2users` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uniqueKey` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admins` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `participants` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1:1:1:1:1:1:1:1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `chats`
--

INSERT INTO `chats` (`id`, `is_between2users`, `uniqueKey`, `image`, `name`, `description`, `creator`, `admins`, `participants`, `permissions`) VALUES
(89, 'true', '6fd86d3fa52379c242955ed933e67ad083.9612446523436', NULL, NULL, NULL, '3', NULL, '3;2', '1:1:1:1:1:1:1:1');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(255) NOT NULL,
  `fromID` int(255) NOT NULL,
  `chatID` int(255) NOT NULL,
  `text` longtext NOT NULL,
  `time` varchar(1000) NOT NULL,
  `type` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `fromID`, `chatID`, `text`, `time`, `type`) VALUES
(227, 3, 89, 'Hello', '1591282157', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `login` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_register` int(255) NOT NULL,
  `dateLast` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `salt`, `lang`, `date_register`, `dateLast`) VALUES
(1, 'Albdarion', '48fdf98ed7df9865944da93482e88fa7', 'd568abda', 'eng', 0, NULL),
(2, 'AlbdarionA', 'e60b7f2b71e8ab2925c4f0b55724caf6', '2468a3e7', 'eng', 1591292258, NULL),
(3, 'AlbdarionB', '9b446e9590beb2f1e21fcc8b8881e6be', 'aa7a5ae9', 'eng', 1591292626, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
