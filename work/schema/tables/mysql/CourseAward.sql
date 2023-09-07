DROP TABLE IF EXISTS `CourseAward`;

CREATE TABLE `CourseAward` (
  `AssociationId` BIGINT NOT NULL,
  `AwardId` BIGINT NOT NULL,
  `OrgUnitId` BIGINT NOT NULL,
  `DateCreated` DATETIME NOT NULL,
  `HiddenAward` TINYINT NOT NULL,
  `ConditionSetId` BIGINT DEFAULT NULL,
  UNIQUE KEY (`AssociationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
