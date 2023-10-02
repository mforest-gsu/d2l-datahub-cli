DROP TABLE IF EXISTS `RubricObjectLevel_LOAD`;

CREATE TABLE `RubricObjectLevel_LOAD` (
  `RubricId` BIGINT DEFAULT NULL,
  `LevelId` BIGINT NOT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `Feedback` VARCHAR(1000) DEFAULT NULL,
  `Value` DECIMAL(19, 9) DEFAULT NULL,
  `RangeStartValue` DECIMAL(19, 9) DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `LevelSetId` BIGINT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`LevelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
