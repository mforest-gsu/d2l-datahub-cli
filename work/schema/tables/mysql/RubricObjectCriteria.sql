DROP TABLE IF EXISTS `RubricObjectCriteria`;

CREATE TABLE `RubricObjectCriteria` (
  `RubricId` BIGINT DEFAULT NULL,
  `CriterionId` BIGINT NOT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `CriteriaGroupId` BIGINT DEFAULT NULL,
  `GroupName` VARCHAR(256) DEFAULT NULL,
  `GroupSortOrder` INT DEFAULT NULL,
  `LevelSetId` BIGINT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  UNIQUE KEY (`CriterionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

