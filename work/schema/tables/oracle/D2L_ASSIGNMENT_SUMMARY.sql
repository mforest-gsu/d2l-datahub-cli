DROP TABLE D2L_ASSIGNMENT_SUMMARY;
CREATE TABLE D2L_ASSIGNMENT_SUMMARY (
  DropboxId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) NOT NULL,
  Name NVARCHAR2(128) NOT NULL,
  Category NVARCHAR2(128) DEFAULT NULL,
  Type VARCHAR2(10) NOT NULL,
  GradeItemId NUMBER(20) DEFAULT NULL,
  PossibleScore NUMBER(19, 9) DEFAULT NULL,
  StartDate DATE DEFAULT NULL,
  EndDate DATE DEFAULT NULL,
  DueDate DATE DEFAULT NULL,
  IsRestricted NUMBER(1) NOT NULL,
  IsDeleted NUMBER(1) NOT NULL,
  TurnItInEnabled NUMBER(1) NOT NULL,
  IsHidden NUMBER(1) NOT NULL,
  SortOrder NUMBER(10) NOT NULL,
  SubmissionType VARCHAR2(18) NOT NULL,
  CompletionType VARCHAR2(27) NOT NULL,
  ResultId NUMBER(10) DEFAULT NULL,
  CategoryId NUMBER(20) DEFAULT NULL,
  Version NUMBER(20) NOT NULL,
  StartDateAvailabilityType NUMBER(5) DEFAULT NULL,
  EndDateAvailabilityType NUMBER(5) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ASSIGNMENT_SUMMARY_PK ON D2L_ASSIGNMENT_SUMMARY (DropboxId);
QUIT;
