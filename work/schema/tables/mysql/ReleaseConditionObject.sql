DROP TABLE IF EXISTS `ReleaseConditionObject`;

CREATE TABLE `ReleaseConditionObject` (
  `PreRequisiteId` INT NOT NULL,
  `ResultId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Name` VARCHAR(64) DEFAULT NULL,
  `IsNegativeCondition` TINYINT DEFAULT NULL,
  `PreRequisiteToolId` INT DEFAULT NULL,
  `Id1` INT DEFAULT NULL,
  `Id2` INT DEFAULT NULL,
  `ResultToolId` INT DEFAULT NULL,
  `UsesPercentage` TINYINT DEFAULT NULL,
  `OperatorTypeDesc` VARCHAR(3) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  UNIQUE KEY (`PreRequisiteId`, `ResultId`, `OrgUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

