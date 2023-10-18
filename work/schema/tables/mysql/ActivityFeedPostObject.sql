DROP TABLE IF EXISTS `ActivityFeedPostObject`;

CREATE TABLE `ActivityFeedPostObject` (
  `OrgUnitId` INT DEFAULT NULL,
  `PostId` VARCHAR(36) NOT NULL,
  `PostType` VARCHAR(16) DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `DropboxId` BIGINT DEFAULT NULL,
  `Content` VARCHAR(3072) DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `CommentCount` INT DEFAULT NULL,
  `AttachmentCount` INT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`PostId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
