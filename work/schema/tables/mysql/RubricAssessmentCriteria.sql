DROP TABLE IF EXISTS `RubricAssessmentCriteria`;

CREATE TABLE `RubricAssessmentCriteria` (
  `AssessmentId` BIGINT NOT NULL,
  `UserId` INT NOT NULL,
  `RubricId` BIGINT NOT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `Feedback` VARCHAR(1000) DEFAULT NULL,
  `IsScoreOverridden` TINYINT NOT NULL,
  `CriterionId` BIGINT NOT NULL,
  `LevelAchievedId` BIGINT DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`AssessmentId`, `UserId`, `CriterionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
