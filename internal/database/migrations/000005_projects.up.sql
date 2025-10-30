create table `projects` (
  `id` int unsigned not null auto_increment primary key,
  `title` varchar(255) not null,
  `project_type` varchar(100) not null,
  `short_description` varchar(255) not null,
  `description` TEXT null,
  `audio_url` varchar(255) null,
  `project_date` varchar(60) not null
)
