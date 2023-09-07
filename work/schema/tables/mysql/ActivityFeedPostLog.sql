DROP TABLE IF EXISTS `ActivityFeedPostLog`;

CREATE TABLE `ActivityFeedPostLog` (
  `LogId` VARCHAR(16) NOT NULL,
  `UserId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `PostId` VARCHAR(16) NOT NULL,
  `PostType` VARCHAR(16) NOT NULL,
  `Action` VARCHAR(16) NOT NULL,
  `ActionDate` DATETIME NOT NULL,
  `DropboxId` BIGINT DEFAULT NULL,
  `Content` VARCHAR(3072) DEFAULT NULL,
  `CommentCount` INT NOT NULL,
  `AttachmentCount` INT DEFAULT NULL,
  UNIQUE KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
