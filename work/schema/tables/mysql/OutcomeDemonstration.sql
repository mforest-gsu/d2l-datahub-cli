DROP TABLE IF EXISTS `OutcomeDemonstration`;

CREATE TABLE `OutcomeDemonstration` (
  `DemonstrationId` VARCHAR(16) NOT NULL,
  `ExplicitlyEnteredScaleLevelId` VARCHAR(16) DEFAULT NULL,
  `AutomaticallyGeneratedScaleLevelId` VARCHAR(16) DEFAULT NULL,
  `AlignedObjectType` INT NOT NULL,
  `AlignedObjectId` VARCHAR(1000) NOT NULL,
  `OutcomeId` VARCHAR(16) NOT NULL,
  `RegistryId` VARCHAR(16) NOT NULL,
  `IsPublished` TINYINT DEFAULT NULL,
  `AssessedUserId` INT NOT NULL,
  `AssessedDate` DATETIME NOT NULL,
  `AssessorUserId` INT DEFAULT NULL,
  `LastModifiedDate` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`DemonstrationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
