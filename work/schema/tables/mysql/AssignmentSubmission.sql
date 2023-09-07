DROP TABLE IF EXISTS `AssignmentSubmission`;

CREATE TABLE `AssignmentSubmission` (
  `DropboxId` BIGINT NOT NULL,
  `OrgUnitId` INT NOT NULL,
  `SubmitterId` BIGINT NOT NULL,
  `SubmitterType` VARCHAR(5) DEFAULT NULL,
  `FileSubmissionCount` INT NOT NULL,
  `TotalFileSize` BIGINT NOT NULL,
  `FeedbackUserId` INT DEFAULT NULL,
  `FeedbackIsRead` TINYINT NOT NULL,
  `Score` DECIMAL(19, 9) DEFAULT NULL,
  `IsGraded` TINYINT NOT NULL,
  `LastSubmissionDate` DATETIME DEFAULT NULL,
  `Feedback` VARCHAR(1000) DEFAULT NULL,
  `FeedbackLastModified` DATETIME DEFAULT NULL,
  `FeedbackReadDate` DATETIME DEFAULT NULL,
  `CompletionDate` DATETIME DEFAULT NULL,
  UNIQUE KEY (`DropboxId`, `SubmitterId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
