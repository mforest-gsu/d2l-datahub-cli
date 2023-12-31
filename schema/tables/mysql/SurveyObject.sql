DROP TABLE IF EXISTS `SurveyObject`;

CREATE TABLE `SurveyObject` (
  `SurveyId` BIGINT NOT NULL,
  `SurveyName` VARCHAR(1000) DEFAULT NULL,
  `CategoryId` BIGINT DEFAULT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionEnabled` TINYINT DEFAULT NULL,
  `HasInstantFeedback` TINYINT DEFAULT NULL,
  `IsAnonymous` TINYINT DEFAULT NULL,
  `IsVisible` TINYINT DEFAULT NULL,
  `SubmissionMessage` VARCHAR(1000) DEFAULT NULL,
  `Footer` VARCHAR(1000) DEFAULT NULL,
  `FooterIsDisplayed` TINYINT DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `DisplayInCalendar` TINYINT DEFAULT NULL,
  `ResultId` BIGINT DEFAULT NULL,
  `AttemptsAllowed` INT DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `CreatedBy` INT DEFAULT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  `CategoryName` VARCHAR(256) DEFAULT NULL,
  UNIQUE KEY (`SurveyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
