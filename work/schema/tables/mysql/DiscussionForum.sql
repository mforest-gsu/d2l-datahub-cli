DROP TABLE IF EXISTS `DiscussionForum`;

CREATE TABLE `DiscussionForum` (
  `OrgUnitId` INT NOT NULL,
  `ForumId` BIGINT NOT NULL,
  `Name` VARCHAR(400) NOT NULL,
  `Description` VARCHAR(1000) DEFAULT NULL,
  `MustPostToParticipate` TINYINT NOT NULL,
  `AllowAnon` TINYINT NOT NULL,
  `IsHidden` TINYINT NOT NULL,
  `RequiresApproval` TINYINT NOT NULL,
  `SortOrder` INT NOT NULL,
  `IsDeleted` TINYINT DEFAULT NULL,
  `DeletedDate` DATETIME DEFAULT NULL,
  `DeletedByUserId` INT DEFAULT NULL,
  `ResultId` INT DEFAULT NULL,
  `StartDate` DATETIME DEFAULT NULL,
  `StartDateAvailabilityType` VARCHAR(2) DEFAULT NULL,
  `EndDate` DATETIME NOT NULL,
  `EndDateAvailabilityType` VARCHAR(2) DEFAULT NULL,
  UNIQUE KEY (`ForumId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
