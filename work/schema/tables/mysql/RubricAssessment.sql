DROP TABLE IF EXISTS `RubricAssessment`;

CREATE TABLE `RubricAssessment` (
  `RubricId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `Score` DECIMAL(36, 2) DEFAULT NULL,
  `AssessedByUserId` INT DEFAULT NULL,
  `AssessmentDate` DATETIME NOT NULL,
  `IsCompleted` TINYINT NOT NULL,
  `ActivityType` VARCHAR(50) DEFAULT NULL,
  `ActivityObjectId` BIGINT DEFAULT NULL,
  `DateCreated` DATETIME NOT NULL,
  `AssessmentId` BIGINT NOT NULL,
  `LevelAchievedId` BIGINT DEFAULT NULL,
  UNIQUE KEY (`UserId`, `AssessmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
