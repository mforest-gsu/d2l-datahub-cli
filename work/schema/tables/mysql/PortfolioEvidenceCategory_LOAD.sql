DROP TABLE IF EXISTS `PortfolioEvidenceCategory_LOAD`;

CREATE TABLE `PortfolioEvidenceCategory_LOAD` (
  `CategoryId` VARCHAR(16) NOT NULL,
  `EvidenceId` VARCHAR(16) NOT NULL,
  `Group` VARCHAR(30) NOT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  UNIQUE KEY (`CategoryId`, `EvidenceId`, `Group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
