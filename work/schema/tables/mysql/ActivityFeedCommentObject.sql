DROP TABLE IF EXISTS `ActivityFeedCommentObject`;

CREATE TABLE `ActivityFeedCommentObject` (
  `OrgUnitId` INT NOT NULL,
  `CommentId` VARCHAR(16) NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `Content` VARCHAR(3072) NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `PostId` VARCHAR(16) NOT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`CommentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
