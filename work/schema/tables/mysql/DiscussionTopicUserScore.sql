DROP TABLE IF EXISTS `DiscussionTopicUserScore`;

CREATE TABLE `DiscussionTopicUserScore` (
  `UserId` INT NOT NULL,
  `TopicId` BIGINT NOT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `IsGraded` TINYINT NOT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`UserId`, `TopicId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
