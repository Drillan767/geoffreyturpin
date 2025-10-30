create table `working_processes` (
  `id` int unsigned not null auto_increment primary key,
  `title` varchar(255) not null,
  `description` TEXT not null,
  `step_number` INT not null
)
