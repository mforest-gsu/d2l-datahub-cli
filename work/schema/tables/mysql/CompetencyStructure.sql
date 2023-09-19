DROP TABLE IF EXISTS `CompetencyStructure`;

CREATE TABLE `CompetencyStructure` (
  `ObjectId` BIGINT NOT NULL,
  `ParentObjectId` BIGINT NOT NULL,
  `BaseObjectID` BIGINT NOT NULL,
  `Depth` INT DEFAULT NULL,
  `EntryTime` INT NOT NULL,
  UNIQUE KEY (`ObjectId`, `ParentObjectId`, `BaseObjectID`, `EntryTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
