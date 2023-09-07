DROP TABLE IF EXISTS `SCORMObject`;

CREATE TABLE `SCORMObject` (
  `ScormObjectId` VARCHAR(16) NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `ContentObjectId` INT NOT NULL,
  `ContentServiceContentId` VARCHAR(16) NOT NULL,
  `ContentServiceRevisionId` VARCHAR(16) NOT NULL,
  `ContentServiceTopicId` VARCHAR(16) NOT NULL,
  `Title` VARCHAR(1000) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `LearningStandard` VARCHAR(100) DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  UNIQUE KEY (`ScormObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
