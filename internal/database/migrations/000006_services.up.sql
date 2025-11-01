create table `services` (
  `id` int unsigned not null auto_increment primary key,
  `name` varchar(255) not null,
  `description` TEXT not null,
  `display_order` INT not null default 0
)
