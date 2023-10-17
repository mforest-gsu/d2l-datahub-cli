DROP TABLE IF EXISTS `OutcomeCourseSpecificScale`;

CREATE TABLE `OutcomeCourseSpecificScale` (
  `OrgUnitId` INT NOT NULL,
  `RegistryId` VARCHAR(16) DEFAULT NULL,
  `ScaleId` VARCHAR(16) DEFAULT NULL,
  `AchievementThreshold` VARCHAR(16) DEFAULT NULL,
  `CreatedDate` DATETIME DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`OrgUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
