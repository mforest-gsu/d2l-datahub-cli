DROP TABLE IF EXISTS `PreRequisiteConditionMet`;

CREATE TABLE `PreRequisiteConditionMet` (
  `PreRequisiteId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `DateMet` DATETIME DEFAULT NULL,
  UNIQUE KEY (`PreRequisiteId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
