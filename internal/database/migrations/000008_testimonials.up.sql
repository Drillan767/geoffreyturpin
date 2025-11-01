create table `testimonials` (
  `id` int unsigned not null auto_increment primary key,
  `client_name` varchar(255) not null,
  `client_occupation` varchar(255) not null,
  `testimonial_text` TEXT not null,
  `display_order` INT not null default 0,
  `created_at` DATETIME not null default NOW(),
  `updated_at` DATETIME not null default NOW()
)
