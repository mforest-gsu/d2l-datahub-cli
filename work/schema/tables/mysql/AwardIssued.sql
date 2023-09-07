DROP TABLE IF EXISTS `AwardIssued`;

CREATE TABLE `AwardIssued` (
  `AwardId` BIGINT NOT NULL,
  `OrgUnitId` BIGINT NOT NULL,
  `UserId` BIGINT NOT NULL,
  `Type` VARCHAR(128) NOT NULL,
  `IssuedBy` INT NOT NULL,
  `IssueDate` DATETIME NOT NULL,
  `ExpiryDate` DATETIME DEFAULT NULL,
  `IsRevoked` TINYINT NOT NULL,
  `IssuedId` BIGINT NOT NULL,
  `Credits` DECIMAL(9, 2) NOT NULL,
  `Criteria` VARCHAR(1000) DEFAULT NULL,
  `Evidence` VARCHAR(1000) DEFAULT NULL,
  UNIQUE KEY (`IssuedId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
