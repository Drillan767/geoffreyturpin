create table `social_networks` (
  `id` int unsigned not null auto_increment primary key,
  `platform` VARCHAR(100) NOT NULL,
  `url` VARCHAR(255) NOT NULL
)
