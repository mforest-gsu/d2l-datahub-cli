DROP TABLE IF EXISTS `SCORMInteractionObjective`;

CREATE TABLE `SCORMInteractionObjective` (
  `InteractionId` VARCHAR(16) NOT NULL,
  `ObjectiveId` VARCHAR(16) NOT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`InteractionId`, `ObjectiveId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

