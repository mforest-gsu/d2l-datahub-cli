DROP TABLE IF EXISTS `DiscussionPostReadStatus`;

CREATE TABLE `DiscussionPostReadStatus` (
  `TopicId` BIGINT DEFAULT NULL,
  `UserId` INT NOT NULL,
  `PostId` BIGINT NOT NULL,
  `IsRead` TINYINT DEFAULT NULL,
  `FirstReadDate` DATETIME DEFAULT NULL,
  `LastReadDate` DATETIME DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`UserId`, `PostId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

