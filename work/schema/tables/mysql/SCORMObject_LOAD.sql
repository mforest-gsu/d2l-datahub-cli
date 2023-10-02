DROP TABLE IF EXISTS `SCORMObject_LOAD`;

CREATE TABLE `SCORMObject_LOAD` (
  `ScormObjectId` VARCHAR(16) NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `ContentObjectId` INT DEFAULT NULL,
  `ContentServiceContentId` VARCHAR(16) DEFAULT NULL,
  `ContentServiceRevisionId` VARCHAR(16) DEFAULT NULL,
  `ContentServiceTopicId` VARCHAR(16) DEFAULT NULL,
  `Title` VARCHAR(1000) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `LearningStandard` VARCHAR(100) DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  UNIQUE KEY (`ScormObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
