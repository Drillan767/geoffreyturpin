create table `biographies` (
  `id` int unsigned not null auto_increment primary key,
  `title` varchar(4) not null,
  `text` text not null,
  `created_at` DATETIME null default NOW()
)
