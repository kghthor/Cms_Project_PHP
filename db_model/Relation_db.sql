-- Use the cms database
USE cms;

-- Alter the cms_posts table to add foreign key constraints
ALTER TABLE `cms_posts`
  ADD CONSTRAINT `fk_category`
  FOREIGN KEY (`category_id`)
  REFERENCES `cms_category` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

ALTER TABLE `cms_posts`
  ADD CONSTRAINT `fk_user`
  FOREIGN KEY (`userid`)
  REFERENCES `cms_user` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

-- Alter the cms_permissions table to add foreign key constraints
ALTER TABLE `cms_permissions`
  ADD CONSTRAINT `fk_permission_user`
  FOREIGN KEY (`user_id`)
  REFERENCES `cms_user` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;

