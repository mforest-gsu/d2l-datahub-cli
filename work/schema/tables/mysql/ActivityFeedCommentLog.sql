DROP TABLE IF EXISTS `ActivityFeedCommentLog`;

CREATE TABLE `ActivityFeedCommentLog` (
  `LogId` VARCHAR(16) NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `CommentId` VARCHAR(16) NOT NULL,
  `Action` VARCHAR(16) NOT NULL,
  `ActionDate` DATETIME NOT NULL,
  `Content` VARCHAR(3072) NOT NULL,
  `PostId` VARCHAR(16) NOT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
