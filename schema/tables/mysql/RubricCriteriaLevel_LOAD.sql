DROP TABLE IF EXISTS `RubricCriteriaLevel_LOAD`;

CREATE TABLE `RubricCriteriaLevel_LOAD` (
  `RubricId` BIGINT NOT NULL,
  `CriterionId` BIGINT NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `Feedback` VARCHAR(1000) DEFAULT NULL,
  `Value` DECIMAL(19, 9) DEFAULT NULL,
  `LevelId` BIGINT NOT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`RubricId`, `CriterionId`, `LevelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
