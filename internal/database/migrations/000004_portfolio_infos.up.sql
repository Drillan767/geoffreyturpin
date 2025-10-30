create table `portfolio_infos` (
  `id` int unsigned not null auto_increment primary key,
  `hero_message` TEXT null,
  `hero_playlist_url` varchar(255) null,
  `biography` TEXT null,
  `profile_picture_url` varchar(255) null,
  `work_philosophy` TEXT null,
  `closing_phrase` TEXT null,
  `legal_mentions` TEXT null
)
