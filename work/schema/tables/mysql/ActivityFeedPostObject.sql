DROP TABLE IF EXISTS `ActivityFeedPostObject`;

CREATE TABLE `ActivityFeedPostObject` (
  `OrgUnitId` INT NOT NULL,
  `PostId` VARCHAR(16) NOT NULL,
  `PostType` VARCHAR(16) NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `DropboxId` BIGINT DEFAULT NULL,
  `Content` VARCHAR(3072) DEFAULT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `CommentCount` INT NOT NULL,
  `AttachmentCount` INT DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`PostId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
