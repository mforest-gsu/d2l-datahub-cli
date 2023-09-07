DROP TABLE IF EXISTS `RubricObjectCriteria`;

CREATE TABLE `RubricObjectCriteria` (
  `RubricId` BIGINT NOT NULL,
  `CriterionId` BIGINT NOT NULL,
  `Name` VARCHAR(256) NOT NULL,
  `SortOrder` INT NOT NULL,
  `CriteriaGroupId` BIGINT NOT NULL,
  `GroupName` VARCHAR(256) NOT NULL,
  `GroupSortOrder` INT NOT NULL,
  `LevelSetId` BIGINT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  UNIQUE KEY (`CriterionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
