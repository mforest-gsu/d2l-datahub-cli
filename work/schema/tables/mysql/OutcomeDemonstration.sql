DROP TABLE IF EXISTS `OutcomeDemonstration`;

CREATE TABLE `OutcomeDemonstration` (
  `DemonstrationId` VARCHAR(36) NOT NULL,
  `ExplicitlyEnteredScaleLevelId` VARCHAR(36) DEFAULT NULL,
  `AutomaticallyGeneratedScaleLevelId` VARCHAR(36) DEFAULT NULL,
  `AlignedObjectType` INT DEFAULT NULL,
  `AlignedObjectId` VARCHAR(1000) DEFAULT NULL,
  `OutcomeId` VARCHAR(36) DEFAULT NULL,
  `RegistryId` VARCHAR(36) DEFAULT NULL,
  `IsPublished` TINYINT DEFAULT NULL,
  `AssessedUserId` INT DEFAULT NULL,
  `AssessedDate` DATETIME DEFAULT NULL,
  `AssessorUserId` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`DemonstrationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
