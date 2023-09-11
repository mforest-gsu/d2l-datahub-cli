DROP TABLE IF EXISTS `RubricAssessment`;

CREATE TABLE `RubricAssessment` (
  `RubricId` BIGINT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `UserId` INT NOT NULL,
  `Score` DECIMAL(36, 2) DEFAULT NULL,
  `AssessedByUserId` INT DEFAULT NULL,
  `AssessmentDate` DATETIME DEFAULT NULL,
  `IsCompleted` TINYINT DEFAULT NULL,
  `ActivityType` VARCHAR(50) DEFAULT NULL,
  `ActivityObjectId` BIGINT DEFAULT NULL,
  `DateCreated` DATETIME DEFAULT NULL,
  `AssessmentId` BIGINT NOT NULL,
  `LevelAchievedId` BIGINT DEFAULT NULL,
  UNIQUE KEY (`UserId`, `AssessmentId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

