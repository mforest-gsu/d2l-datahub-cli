DROP TABLE IF EXISTS `AccommodationsProfileLog`;

CREATE TABLE `AccommodationsProfileLog` (
  `AccommodatedUserId` BIGINT NOT NULL,
  `OrgUnitId` BIGINT NOT NULL,
  `QuizTimeLimitMultiplier` DECIMAL(5,2) DEFAULT NULL,
  `QuizTimeLimitExtraTime` INT DEFAULT NULL,
  `QuizControlAlwaysAllowRightClick` TINYINT DEFAULT NULL,
  `ModifiedBy` BIGINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`AccommodatedUserId`, `OrgUnitId`, `LastModified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
