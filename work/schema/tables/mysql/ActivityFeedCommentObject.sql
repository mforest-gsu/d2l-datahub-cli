DROP TABLE IF EXISTS `ActivityFeedCommentObject`;

CREATE TABLE `ActivityFeedCommentObject` (
  `OrgUnitId` INT DEFAULT NULL,
  `CommentId` VARCHAR(36) NOT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `Content` VARCHAR(3072) DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `PostId` VARCHAR(36) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`CommentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
