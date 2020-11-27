-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: mariadb
-- Время создания: Ноя 27 2020 г., 21:00
-- Версия сервера: 10.4.16-MariaDB-1:10.4.16+maria~focal
-- Версия PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task_db`
--
CREATE DATABASE IF NOT EXISTS `task_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `task_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `task_tbl`
--

CREATE TABLE `task_tbl` (
  `id` int(11) NOT NULL,
  `status` varchar(150) NOT NULL,
  `result` varchar(150) DEFAULT NULL,
  `photo_name` varchar(150) NOT NULL,
  `photo_hash` varchar(150) NOT NULL,
  `retry_id` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `task_tbl`
--
ALTER TABLE `task_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `photo_hash` (`photo_hash`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `task_tbl`
--
ALTER TABLE `task_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
