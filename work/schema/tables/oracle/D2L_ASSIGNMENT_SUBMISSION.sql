DROP TABLE D2L_ASSIGNMENT_SUBMISSION;
CREATE TABLE D2L_ASSIGNMENT_SUBMISSION (
  DropboxId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  SubmitterId NUMBER(20) NOT NULL,
  SubmitterType VARCHAR2(6 CHAR) DEFAULT NULL,
  FileSubmissionCount NUMBER(10) DEFAULT NULL,
  TotalFileSize NUMBER(20) DEFAULT NULL,
  FeedbackUserId NUMBER(10) DEFAULT NULL,
  FeedbackIsRead NUMBER(1) DEFAULT NULL,
  Score DECIMAL(19, 9) DEFAULT NULL,
  IsGraded NUMBER(1) DEFAULT NULL,
  LastSubmissionDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  Feedback NVARCHAR2(1250) DEFAULT NULL,
  FeedbackLastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  FeedbackReadDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CompletionDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ASSIGNMENT_SUBMISSION_PK ON D2L_ASSIGNMENT_SUBMISSION (DropboxId,SubmitterId);
QUIT;
