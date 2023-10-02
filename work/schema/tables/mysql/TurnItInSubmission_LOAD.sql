DROP TABLE IF EXISTS `TurnItInSubmission_LOAD`;

CREATE TABLE `TurnItInSubmission_LOAD` (
  `DropboxId` BIGINT DEFAULT NULL,
  `SubmissionId` BIGINT NOT NULL,
  `FileId` BIGINT NOT NULL,
  `LastSubmissionDate` DATETIME DEFAULT NULL,
  `SubmissionStatus` VARCHAR(2) DEFAULT NULL,
  `SubmissionErrorType` VARCHAR(2) DEFAULT NULL,
  `ErrorMessage` VARCHAR(255) DEFAULT NULL,
  `SubmittedBy` INT DEFAULT NULL,
  `LastRefreshDate` DATETIME DEFAULT NULL,
  `LastModified` DATETIME DEFAULT NULL,
  UNIQUE KEY (`SubmissionId`, `FileId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
