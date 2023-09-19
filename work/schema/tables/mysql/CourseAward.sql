DROP TABLE IF EXISTS `CourseAward`;

CREATE TABLE `CourseAward` (
  `AssociationId` BIGINT NOT NULL,
  `AwardId` BIGINT DEFAULT NULL,
  `OrgUnitId` BIGINT DEFAULT NULL,
  `DateCreated` DATETIME DEFAULT NULL,
  `HiddenAward` TINYINT DEFAULT NULL,
  `ConditionSetId` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AssociationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
