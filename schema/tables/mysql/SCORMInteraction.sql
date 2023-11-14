DROP TABLE IF EXISTS `SCORMInteraction`;

CREATE TABLE `SCORMInteraction` (
  `InteractionId` VARCHAR(36) NOT NULL,
  `ActivityId` VARCHAR(36) DEFAULT NULL,
  `InternalId` VARCHAR(255) DEFAULT NULL,
  `InteractionType` VARCHAR(100) DEFAULT NULL,
  `Description` VARCHAR(250) DEFAULT NULL,
  `Weighting` FLOAT DEFAULT NULL,
  `CorrectResponses` VARCHAR(2000) DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`InteractionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
