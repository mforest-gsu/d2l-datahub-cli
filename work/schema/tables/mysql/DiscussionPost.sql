DROP TABLE IF EXISTS `DiscussionPost`;

CREATE TABLE `DiscussionPost` (
  `OrgUnitId` INT NOT NULL,
  `TopicId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `PostId` BIGINT NOT NULL,
  `ThreadId` BIGINT NOT NULL,
  `IsReply` TINYINT NOT NULL,
  `ParentPostId` BIGINT DEFAULT NULL,
  `NumReplies` INT NOT NULL,
  `DatePosted` DATETIME NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `RatingSum` BIGINT NOT NULL,
  `NumRatings` BIGINT NOT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `LastEditDate` DATETIME DEFAULT NULL,
  `SortOrder` INT NOT NULL,
  `Depth` INT NOT NULL,
  `Thread` VARCHAR(400) DEFAULT NULL,
  `WordCount` INT DEFAULT NULL,
  `AttachmentCount` INT DEFAULT NULL,
  UNIQUE KEY (`PostId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
