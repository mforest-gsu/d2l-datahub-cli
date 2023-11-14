DROP TABLE IF EXISTS `CompetencyObject`;

CREATE TABLE `CompetencyObject` (
  `ObjectId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `Type` VARCHAR(256) DEFAULT NULL,
  `ReadyForEvaluation` TINYINT DEFAULT NULL,
  `Status` VARCHAR(9) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `NeedReevaluation` TINYINT DEFAULT NULL,
  `ReevaluationIfAchieved` TINYINT DEFAULT NULL,
  `ReevaluationIfNotAchieved` TINYINT DEFAULT NULL,
  `AdditionalIdentifier` VARCHAR(512) DEFAULT NULL,
  `IsHidden` TINYINT DEFAULT NULL,
  UNIQUE KEY (`ObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
