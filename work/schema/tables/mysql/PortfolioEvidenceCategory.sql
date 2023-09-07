DROP TABLE IF EXISTS `PortfolioEvidenceCategory`;

CREATE TABLE `PortfolioEvidenceCategory` (
  `CategoryId` VARCHAR(16) NOT NULL,
  `EvidenceId` VARCHAR(16) NOT NULL,
  `Group` VARCHAR(30) NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  UNIQUE KEY (`CategoryId`, `EvidenceId`, `Group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
