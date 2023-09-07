DROP TABLE IF EXISTS `AssignmentSubmissionDetail`;

CREATE TABLE `AssignmentSubmissionDetail` (
  `SubmissionId` BIGINT NOT NULL,
  `DropboxId` BIGINT NOT NULL,
  `UserId` BIGINT DEFAULT NULL,
  `GroupId` BIGINT DEFAULT NULL,
  `NumberOfFilesSubmitted` INT DEFAULT NULL,
  `TotalFileSize` BIGINT NOT NULL,
  `SubmittedByUserId` INT NOT NULL,
  `DateSubmitted` DATETIME DEFAULT NULL,
  `Comments` VARCHAR(1000) DEFAULT NULL,
  `IsTurnItInExempt` TINYINT DEFAULT NULL,
  `IsDeleted` TINYINT NOT NULL,
  `IsPreview` TINYINT NOT NULL,
  UNIQUE KEY (`SubmissionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
