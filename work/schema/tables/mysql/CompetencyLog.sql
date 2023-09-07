DROP TABLE IF EXISTS `CompetencyLog`;

CREATE TABLE `CompetencyLog` (
  `CompetencyLogId` BIGINT NOT NULL,
  `LogTypeId` INT NOT NULL,
  `LogTypeName` VARCHAR(19) DEFAULT NULL,
  `ObjectId` BIGINT NOT NULL,
  `ObjectTypeId` INT NOT NULL,
  `ObjectTypeName` VARCHAR(18) DEFAULT NULL,
  `ObjectVersion` INT NOT NULL,
  `LogDateTime` DATETIME NOT NULL,
  `ModifiedBy` BIGINT NOT NULL,
  `IndirectObjectId` BIGINT DEFAULT NULL,
  `IndirectObjectTypeName` VARCHAR(18) DEFAULT NULL,
  `IndirectObjectTypeId` INT DEFAULT NULL,
  `IndirectObjectVersion` INT DEFAULT NULL,
  UNIQUE KEY (`CompetencyLogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
