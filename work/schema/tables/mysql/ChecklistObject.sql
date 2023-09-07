DROP TABLE IF EXISTS `ChecklistObject`;

CREATE TABLE `ChecklistObject` (
  `ChecklistId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Name` VARCHAR(512) NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionIsHtml` TINYINT NOT NULL,
  `SharedUserId` INT DEFAULT NULL,
  `DisplayInNewWindow` TINYINT NOT NULL,
  `SortOrder` INT NOT NULL,
  `Version` BIGINT DEFAULT NULL,
  `ResultId` INT DEFAULT NULL,
  UNIQUE KEY (`ChecklistId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
