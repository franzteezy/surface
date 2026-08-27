CREATE DATABASE IF NOT EXISTS `shared`;
GRANT ALL ON `shared`.* TO 'lumen'@'%';

CREATE DATABASE IF NOT EXISTS `tenant1`;
GRANT ALL ON `tenant1`.* TO 'lumen'@'%';

CREATE DATABASE IF NOT EXISTS `tenant2`;
GRANT ALL ON `tenant2`.* TO 'lumen'@'%';

CREATE TABLE IF NOT EXISTS `shared`.`tenants` (`id` int AUTO_INCREMENT,`tenant` varchar(255) NOT NULL,`ip_address` varchar(255) NOT NULL,`password` varchar(255) NOT NULL,`name` varchar(255) NOT NULL,`database_name` varchar(255) NOT NULL, PRIMARY KEY (id));

INSERT INTO `shared`.`tenants` (`tenant`, `ip_address`, `password`, `name`, `database_name`) VALUES ('tenant1', 'mariadb', 'eyJpdiI6InJxMlhoV09HOHk0ZHJZbGxJT2VVRGc9PSIsInZhbHVlIjoiMFJTWEo2LzIzanZvUGZMMTcrWHY2UT09IiwibWFjIjoiYWVlMmQ2ZWIwMmQ1Y2NlZjEwYjhkZDliNWVlYTlkZjZiMzY5MGU4ZDE4MmNmNTA2YWYzNGI1M2IzOGM5MWY3ZCIsInRhZyI6IiJ9', 'Tenant 1', 'tenant1');
INSERT INTO `shared`.`tenants` (`tenant`, `ip_address`, `password`, `name`, `database_name`) VALUES ('tenant2', 'mariadb', 'eyJpdiI6InJxMlhoV09HOHk0ZHJZbGxJT2VVRGc9PSIsInZhbHVlIjoiMFJTWEo2LzIzanZvUGZMMTcrWHY2UT09IiwibWFjIjoiYWVlMmQ2ZWIwMmQ1Y2NlZjEwYjhkZDliNWVlYTlkZjZiMzY5MGU4ZDE4MmNmNTA2YWYzNGI1M2IzOGM5MWY3ZCIsInRhZyI6IiJ9', 'Tenant 2', 'tenant2');