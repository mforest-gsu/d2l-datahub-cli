DROP TABLE IF EXISTS `CoursePublisherRecipient_LOAD`;

CREATE TABLE `CoursePublisherRecipient_LOAD` (
  `RecipientID` VARCHAR(36) NOT NULL,
  `Name` VARCHAR(256) DEFAULT NULL,
  `CreatedAt` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`RecipientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
