DROP TABLE IF EXISTS `AssignmentSubmission_LOAD`;

CREATE TABLE `AssignmentSubmission_LOAD` (
  `DropboxId` BIGINT NOT NULL,
  `OrgUnitId` INT DEFAULT NULL,
  `SubmitterId` BIGINT NOT NULL,
  `SubmitterType` VARCHAR(5) DEFAULT NULL,
  `FileSubmissionCount` INT DEFAULT NULL,
  `TotalFileSize` BIGINT DEFAULT NULL,
  `FeedbackUserId` INT DEFAULT NULL,
  `FeedbackIsRead` TINYINT DEFAULT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `IsGraded` TINYINT DEFAULT NULL,
  `LastSubmissionDate` DATETIME DEFAULT NULL,
  `Feedback` VARCHAR(1000) DEFAULT NULL,
  `FeedbackLastModified` DATETIME DEFAULT NULL,
  `FeedbackReadDate` DATETIME DEFAULT NULL,
  `CompletionDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`DropboxId`, `SubmitterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
