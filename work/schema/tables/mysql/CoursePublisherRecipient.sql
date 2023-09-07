DROP TABLE IF EXISTS `CoursePublisherRecipient`;

CREATE TABLE `CoursePublisherRecipient` (
  `RecipientID` VARCHAR(16) NOT NULL,
  `Name` VARCHAR(256) NOT NULL,
  `CreatedAt` DATETIME NOT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`RecipientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
