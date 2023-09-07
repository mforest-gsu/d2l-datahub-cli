DROP TABLE IF EXISTS `TurnItInSubmission`;

CREATE TABLE `TurnItInSubmission` (
  `DropboxId` BIGINT NOT NULL,
  `SubmissionId` BIGINT NOT NULL,
  `FileId` BIGINT NOT NULL,
  `LastSubmissionDate` DATETIME DEFAULT NULL,
  `SubmissionStatus` VARCHAR(2) NOT NULL,
  `SubmissionErrorType` VARCHAR(2) NOT NULL,
  `ErrorMessage` VARCHAR(255) DEFAULT NULL,
  `SubmittedBy` INT DEFAULT NULL,
  `LastRefreshDate` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`SubmissionId`, `FileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
