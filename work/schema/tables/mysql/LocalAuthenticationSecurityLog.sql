DROP TABLE IF EXISTS `LocalAuthenticationSecurityLog`;

CREATE TABLE `LocalAuthenticationSecurityLog` (
  `UserId` INT NOT NULL,
  `Action` VARCHAR(70) NOT NULL,
  `ModifiedBy` INT NOT NULL,
  `ModifiedDate` DATETIME NOT NULL,
  UNIQUE KEY (`UserId`, `Action`, `ModifiedBy`, `ModifiedDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
