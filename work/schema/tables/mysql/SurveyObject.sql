DROP TABLE IF EXISTS `SurveyObject`;

CREATE TABLE `SurveyObject` (
  `SurveyId` BIGINT NOT NULL,
  `SurveyName` VARCHAR(1000) NOT NULL,
  `CategoryId` BIGINT DEFAULT NULL,
  `OrgUnitId` INT NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `DescriptionEnabled` TINYINT NOT NULL,
  `HasInstantFeedback` TINYINT NOT NULL,
  `IsAnonymous` TINYINT NOT NULL,
  `IsVisible` TINYINT NOT NULL,
  `SubmissionMessage` VARCHAR(1000) DEFAULT NULL,
  `Footer` VARCHAR(1000) DEFAULT NULL,
  `FooterIsDisplayed` TINYINT NOT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `EndDate` DATETIME DEFAULT NULL,
  `DisplayInCalendar` TINYINT NOT NULL,
  `ResultId` BIGINT DEFAULT NULL,
  `AttemptsAllowed` INT DEFAULT NULL,
  `SortOrder` INT NOT NULL,
  `CreatedBy` INT NOT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `LastModified` DATETIME NOT NULL,
  `LastModifiedBy` INT NOT NULL,
  `Version` BIGINT NOT NULL,
  `CategoryName` VARCHAR(256) DEFAULT NULL,
  UNIQUE KEY (`SurveyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
