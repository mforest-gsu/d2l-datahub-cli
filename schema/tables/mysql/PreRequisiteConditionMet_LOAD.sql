DROP TABLE IF EXISTS `PreRequisiteConditionMet_LOAD`;

CREATE TABLE `PreRequisiteConditionMet_LOAD` (
  `PreRequisiteId` INT NOT NULL,
  `UserId` INT NOT NULL,
  `DateMet` DATETIME DEFAULT NULL,
  UNIQUE KEY (`PreRequisiteId`, `UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
