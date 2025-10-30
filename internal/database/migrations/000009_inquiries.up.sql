create table `inquiries` (
  `id` int unsigned not null auto_increment primary key,
  `full_name` varchar(255) not null,
  `email` varchar(255) not null,
  `subject` varchar(255) not null,
  `message` TEXT not null,
  `is_read` BOOLEAN not null
)
