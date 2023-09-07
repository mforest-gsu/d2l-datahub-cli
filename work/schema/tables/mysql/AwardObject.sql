DROP TABLE IF EXISTS `AwardObject`;

CREATE TABLE `AwardObject` (
  `AwardId` BIGINT NOT NULL,
  `Name` VARCHAR(256) NOT NULL,
  `AwardTypeId` INT NOT NULL,
  `Type` VARCHAR(128) NOT NULL,
  `Description` VARCHAR(512) NOT NULL,
  `ExpiryCalculationType` VARCHAR(128) NOT NULL,
  `ExpiryNotificationType` VARCHAR(128) NOT NULL,
  `ExpiryDate` DATETIME NOT NULL,
  `ImagePath` VARCHAR(1000) DEFAULT NULL,
  `CreatedByUserId` BIGINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `Criteria` VARCHAR(1000) DEFAULT NULL,
  UNIQUE KEY (`AwardId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
