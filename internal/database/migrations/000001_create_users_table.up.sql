create table `users` (
  `id` int unsigned not null auto_increment primary key,
  `name` varchar(60) not null,
  `email` varchar(255) not null,
  `password` varchar(255) not null,
  `picture` varchar(255) null,
  `biography` TEXT null,
  `created_at` DATETIME not null default NOW()
)
