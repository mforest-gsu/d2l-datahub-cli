DROP TABLE IF EXISTS `ChecklistObject_LOAD`;

CREATE TABLE `ChecklistObject_LOAD` (
  `ChecklistId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Name` VARCHAR(512) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionIsHtml` TINYINT DEFAULT NULL,
  `SharedUserId` INT DEFAULT NULL,
  `DisplayInNewWindow` TINYINT DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  `ResultId` INT DEFAULT NULL,
  UNIQUE KEY (`ChecklistId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
