-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 11 2019 г., 20:45
-- Версия сервера: 5.6.41
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `gbphp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `info` varchar(250) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `info`, `price`) VALUES
(1, 'Товар 1', 'Тут информация о товаре 1', 200),
(2, 'Товар 2', 'Тут информация о товаре 2', 300),
(3, 'Товар 3', 'Описание', 230),
(4, 'Товар 4', 'Описание этого товара', 4560);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `src` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `src`) VALUES
(1, 'C:oserOSPaneldomainsgbphp/img/due18_1.jpg'),
(2, 'img');

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `id` int(10) NOT NULL,
  `preview_src` varchar(50) NOT NULL,
  `photo_src` varchar(50) NOT NULL,
  `size` int(30) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `show_count` int(30) NOT NULL DEFAULT '0' COMMENT 'количество просмотров',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`id`, `preview_src`, `photo_src`, `size`, `name`, `show_count`, `added`) VALUES
(1, './img/min/1.jpg', './img/max/1.jpg', 661462, 'planet js', 0, '2019-01-29 12:31:00'),
(2, './img/min/2.jpg', './img/max/2.jpg', 25499, NULL, 0, '2019-01-29 12:31:00'),
(3, './img/min/3.jpg', './img/max/3.jpg', 57637, 'js class', 0, '2019-01-29 12:33:05'),
(4, './img/min/4.jpg', './img/max/4.jpg', 20832, 'объява ', 4, '2019-01-29 12:33:05');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` int(2) NOT NULL DEFAULT '0' COMMENT '1 - адин, 0 - юзер',
  `dob` date DEFAULT NULL,
  `delivery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `role`, `dob`, `delivery`) VALUES
(1, 'Вася', 'admin', 'F75162EF3AADED42BC5D00C20793496F', 1, '2000-01-25', ''),
(42, 'Саня', 'sasha', 'F75162EF3AADED42BC5D00C20793496F', 0, NULL, '{\"fio\":\"Мунини Александр\",\"tel\":\"321123\",\"address\":\"Тольятти Автостроителей 10 кв 21\"}');

-- --------------------------------------------------------

--
-- Структура таблицы `zakaz`
--

CREATE TABLE `zakaz` (
  `id` int(11) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `info` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `registeredas` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `zakaz`
--

INSERT INTO `zakaz` (`id`, `fio`, `tel`, `address`, `info`, `status`, `registeredas`) VALUES
(25, 'Копытин Юрий', '123456', 'Самара Коммисаров д. 12', '[{\"price\":\"300\",\"name\":\"Товар 2\",\"count\":3},{\"price\":\"4560\",\"name\":\"Товар 4\",\"count\":1}]', 'в обработке', NULL),
(27, 'Мунини Александр', '321123', 'Тольятти Автостроителей 10 кв 21', '[{\"price\":\"300\",\"name\":\"Товар 2\",\"count\":1},{\"price\":\"4560\",\"name\":\"Товар 4\",\"count\":1},{\"price\":\"230\",\"name\":\"Товар 3\",\"count\":1}]', 'в обработке', 'sasha'),
(28, 'Покутов Андрей', '987231', 'Чебоксары Латинская 20 21', '[{\"price\":\"4560\",\"name\":\"Товар 4\",\"count\":1},{\"price\":\"300\",\"name\":\"Товар 2\",\"count\":1}]', 'в обработке', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `zakaz`
--
ALTER TABLE `zakaz`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `zakaz`
--
ALTER TABLE `zakaz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
