DROP TABLE IF EXISTS `TurnItInSubmission`;

CREATE TABLE `TurnItInSubmission` (
  `DropboxId` BIGINT DEFAULT NULL,
  `SubmissionId` BIGINT NOT NULL,
  `FileId` BIGINT NOT NULL,
  `LastSubmissionDate` DATETIME DEFAULT NULL,
  `SubmissionStatus` SMALLINT DEFAULT NULL,
  `SubmissionErrorType` SMALLINT DEFAULT NULL,
  `ErrorMessage` VARCHAR(255) DEFAULT NULL,
  `SubmittedBy` INT DEFAULT NULL,
  `LastRefreshDate` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`SubmissionId`, `FileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
