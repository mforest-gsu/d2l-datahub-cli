DROP TABLE IF EXISTS `Announcement`;

CREATE TABLE `Announcement` (
  `AnnouncementId` BIGINT NOT NULL,
  `OrgUnitId` BIGINT NOT NULL,
  `Title` VARCHAR(400) NOT NULL,
  `StartDate` DATETIME NOT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `IsGlobal` TINYINT NOT NULL,
  `IsDraft` TINYINT NOT NULL,
  `NumAttachments` INT NOT NULL,
  `DeletedDate` DATETIME DEFAULT NULL,
  `DeletedByUserId` INT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `IsAuthorInfoShown` TINYINT NOT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `ResultId` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AnnouncementId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
