-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2012 at 05:16 AM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `recipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `dependent_steps`
--

CREATE TABLE `dependent_steps` (
  `recipe` int(11) NOT NULL,
  `dependant` int(11) NOT NULL,
  `dependent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dependent_steps`
--

INSERT INTO `dependent_steps` (`recipe`, `dependant`, `dependent`) VALUES
(15, 2, 1),
(16, 2, 1),
(17, 2, 1),
(18, 3, 2),
(20, 2, 1),
(20, 1, 1),
(21, 2, 1),
(21, 1, 1),
(22, 3, 2),
(22, 2, 1),
(22, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`),
  UNIQUE KEY `user_id` (`user_id`,`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `picture_url` varchar(255) DEFAULT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `description`, `picture_url`, `user`) VALUES
(10, 'pate a choux', 'cream puff dough', NULL, 3),
(11, 'Pastry Cream', 'A custard used in French tarts', NULL, 3),
(13, 'Chocolate Mousse', 'A velvety dessert', NULL, 3),
(15, 'Carrot Muffins', 'the health-food junk-food snack', NULL, 3),
(16, 'blueberry muff', 'staple', NULL, 3),
(17, 'croissants', 'a flaky pastry', NULL, 3),
(18, 'Faux Gateux ', '', NULL, 4),
(19, 'Parapluie de Parmesan ', 'PARAPLUIE', NULL, 4),
(20, 'Pie D''Inception', 'its a pie, within a pie', NULL, 4),
(21, 'Tarte Blanche', 'Clean slate ', NULL, 4),
(22, 'Orange Muffins', 'These Muffins have Orange flavoring', NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `recipe` int(11) NOT NULL,
  `seq` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `instructions` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`recipe`, `seq`, `type`, `instructions`) VALUES
(10, 1, 2, 'boil water with butter and salt'),
(10, 2, 2, 'mix in flour'),
(11, 1, 10, '3 eggs\n1 pt milk\n75g sugar'),
(11, 2, 2, 'Whisk to ribbon stage'),
(11, 3, 10, '1 pt milk\n75g sugar'),
(11, 4, 1, 'boil two ingredients together'),
(13, 1, 10, '1 pt cream\n3 eggs\n4 sheets gelatin'),
(15, 1, 10, 'eggs\nsugar \nil'),
(15, 2, 2, 'Stir all this together'),
(16, 1, 10, 'eggs\nmelted butter\nsugar'),
(16, 2, 2, 'cream ingredients together'),
(17, 1, 10, 'butter'),
(17, 2, 7, 'flatten butter into a square and chill'),
(18, 1, 10, 'Sugar 2 Kilos\nFlour 4 Kilos \nFaux 1 Kilo \nWater 5 Kilos'),
(18, 2, 7, 'Chill Faux for seven hours, thirty two minutes'),
(18, 3, 6, 'Chop Faux into small pieces '),
(18, 4, 3, 'Roll faux into flour'),
(18, 5, 2, 'Stir flour, water, faux, sugar for twelve hours'),
(18, 6, 1, 'Bake into cake pan, 13 hours'),
(19, 1, 10, '4 Stone Parmesan \n1 Half Stone Lobster \n'),
(19, 2, 6, 'Chop the Lobster extensively '),
(19, 3, 2, 'Stir the parmesan into the lobster over a boiling pot of water'),
(19, 4, 1, 'Bake for 7 minutes'),
(19, 5, 3, 'Roll into a thin sheet'),
(19, 6, 1, 'Bake for three hours at 450 degrees C'),
(20, 1, 10, 'Pie'),
(20, 2, 3, 'Roll the pie into a pie crust'),
(20, 3, 6, 'Chop the resulting pie, into more pie based pie'),
(20, 4, 1, 'BAKE THE PIES '),
(21, 1, 10, 'Flour Five Kilos \nSugar Five Kilos \nWater Three Kilos '),
(21, 2, 2, 'Stir ingredients in bowl for nine (9) minutes '),
(21, 3, 3, 'Roll into Tarte Shape'),
(21, 4, 1, 'Bake it, or don''t'),
(22, 1, 10, 'Oranges \nOrange Peelz \nFlour\nSuger \nOrange Blossom Water'),
(22, 2, 6, 'CHOP THE ORANGES\nLEAVE NO ORANGE UNCHOPT'),
(22, 3, 2, 'EVERYTHING NEEDS TO BE STIRRED'),
(22, 4, 1, 'BUT IT IN MUFFIN TINS AND BAKE AT 500 DEGREES FOR 12 Minutes');

-- --------------------------------------------------------

--
-- Table structure for table `step_types`
--

CREATE TABLE `step_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `icon_url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `html` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `step_types`
--

INSERT INTO `step_types` (`id`, `name`, `icon_url`, `description`, `html`) VALUES
(1, 'Bake', 'bake.png', 'Bake item in an oven', '<br><label>Enter instructions here</label><textarea class="recipe-textarea"></textarea><br>'),
(2, 'Stir', 'stir.png', 'mix a bunch of ingredients', '<br><label>Enter instructions here</label><textarea class="recipe-textarea"></textarea>'),
(3, 'Roll', 'roll.png', 'Roll out dough into a flat sheet', '<br><label>Enter instructions here</label> <textarea class="recipe-textarea"></textarea><br>'),
(6, 'Chop', 'chop.png', 'Cut and slice', '<br><label>Enter instructions here</label> <textarea class="recipe-textarea"></textarea><br>'),
(7, 'Chill', 'chill.png', 'Place in fridge until cool', '<br><label>Enter instructions here</label><textarea class="recipe-textarea"></textarea><br>'),
(10, 'Ingredients', 'mipl.png', 'Mise-on-Place', '<br><label>Enter ingredients here</label> <textarea class="recipe-textarea"></textarea><br>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `modified`, `token`, `password`, `email`, `first_name`, `last_name`) VALUES
(3, 1355869061, 1355869061, '8586a9b087142c8440d4a6334819d5b753191096', '28bb23cb47d62588494400af5d26cba6b79df798', 'ah@hellskitchen.com', 'Gordon', 'Ramsey'),
(4, 1356140402, 1356140402, '51915e396c899e3ac6f5c4493c8b31e5fec128ec', 'e9aba03b1ab689d65561d3816ffc6fe5ce552fcd', 'J.Child@FamousChefs.ie', 'Julia', 'Child'),
(5, 1356142437, 1356142437, 'b8b0f58625e4c83bc4f8b366b543f3f30874b2c2', '0cd962f1153e5a33fc932bf9b79920306f52cee7', 'O.Jamie@chefs.au', 'Jamie ', 'Oliver');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
