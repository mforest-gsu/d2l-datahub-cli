DROP TABLE IF EXISTS `CompetencyActivityResult_LOAD`;

CREATE TABLE `CompetencyActivityResult_LOAD` (
  `ActivityId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `LearningObjectId` BIGINT NOT NULL,
  `IsAchieved` TINYINT DEFAULT NULL,
  `PercentAchieved` DECIMAL(19, 9) DEFAULT NULL,
  `RubricScore` DECIMAL(19, 9) DEFAULT NULL,
  `RubricLevelAchieved` VARCHAR(256) DEFAULT NULL,
  `RubricId` BIGINT DEFAULT NULL,
  `RubricCriterionId` BIGINT DEFAULT NULL,
  `AchievedDate` DATETIME DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`ActivityId`, `OrgUnitId`, `UserId`, `LearningObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
