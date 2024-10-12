-- Create the database
CREATE DATABASE IF NOT EXISTS cms;

-- Use the newly created database
USE cms;

-- Set SQL mode and transaction settings
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Create the cms_user table
CREATE TABLE `cms_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,--It define the user type like it is admin/user to vary the permission
  `deleted` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create the cms_posts table
CREATE TABLE `cms_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,--Article the title
  `message` text NOT NULL,--it's the article Note or message by author
  `category_id` int(11) NOT NULL,--Article Category
  `userid` int(11) NOT NULL,
  `status` enum('published','draft','archived','') NOT NULL DEFAULT 'published',--To set an approval by admin to publish the  post
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Create the cms_category table
CREATE TABLE `cms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,--To categories the article according to the category added
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Commit the transaction
COMMIT;
-- Create and use the cms database
CREATE DATABASE IF NOT EXISTS cms;
USE cms;

-- Create the cms_permissions table
CREATE TABLE `cms_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `can_read_posts` tinyint(1) NOT NULL DEFAULT 0,
  `can_edit_posts` tinyint(1) NOT NULL DEFAULT 0,
  `can_delete_posts` tinyint(1) NOT NULL DEFAULT 0,
  `can_posts_post` tinyint(1) NOT NULL DEFAULT 0;
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Add primary key
ALTER TABLE `cms_permissions`
  ADD PRIMARY KEY (`id`);

-- Modify id to auto increment
ALTER TABLE `cms_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- Commit the transaction
COMMIT;
