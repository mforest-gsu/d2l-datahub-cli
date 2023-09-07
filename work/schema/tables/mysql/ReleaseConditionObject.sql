DROP TABLE IF EXISTS `ReleaseConditionObject`;

CREATE TABLE `ReleaseConditionObject` (
  `PreRequisiteId` INT NOT NULL,
  `ResultId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Name` VARCHAR(64) NOT NULL,
  `IsNegativeCondition` TINYINT NOT NULL,
  `PreRequisiteToolId` INT NOT NULL,
  `Id1` INT DEFAULT NULL,
  `Id2` INT DEFAULT NULL,
  `ResultToolId` INT NOT NULL,
  `UsesPercentage` TINYINT NOT NULL,
  `OperatorTypeDesc` VARCHAR(3) DEFAULT NULL,
  `Version` BIGINT NOT NULL,
  UNIQUE KEY (`PreRequisiteId`, `ResultId`, `OrgUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
