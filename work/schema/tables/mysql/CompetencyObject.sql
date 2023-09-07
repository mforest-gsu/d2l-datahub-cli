DROP TABLE IF EXISTS `CompetencyObject`;

CREATE TABLE `CompetencyObject` (
  `ObjectId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `Name` VARCHAR(256) NOT NULL,
  `Type` VARCHAR(256) NOT NULL,
  `ReadyForEvaluation` TINYINT NOT NULL,
  `Status` VARCHAR(9) DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `NeedReevaluation` TINYINT NOT NULL,
  `ReevaluationIfAchieved` TINYINT DEFAULT NULL,
  `ReevaluationIfNotAchieved` TINYINT DEFAULT NULL,
  `AdditionalIdentifier` VARCHAR(512) DEFAULT NULL,
  `IsHidden` TINYINT NOT NULL,
  UNIQUE KEY (`ObjectId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
