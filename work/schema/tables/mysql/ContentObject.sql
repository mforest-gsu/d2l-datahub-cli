DROP TABLE IF EXISTS `ContentObject`;

CREATE TABLE `ContentObject` (
  `ContentObjectId` INT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Title` VARCHAR(150) NOT NULL,
  `ContentObjectType` VARCHAR(6) NOT NULL,
  `CompletionType` VARCHAR(7) NOT NULL,
  `ParentContentObjectId` INT NOT NULL,
  `Location` VARCHAR(1024) DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `DueDate` DATETIME DEFAULT NULL,
  `ObjectId1` INT DEFAULT NULL,
  `ObjectId2` INT DEFAULT NULL,
  `ObjectId3` INT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `SortOrder` INT NOT NULL,
  `Depth` INT NOT NULL,
  `ToolId` INT DEFAULT NULL,
  `IsHidden` TINYINT NOT NULL,
  `ResultId` INT DEFAULT NULL,
  `DeletedDate` DATETIME DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `DeletedBy` INT DEFAULT NULL,
  UNIQUE KEY (`ContentObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
