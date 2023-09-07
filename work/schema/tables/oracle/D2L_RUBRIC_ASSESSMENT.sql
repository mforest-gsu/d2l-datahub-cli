DROP TABLE D2L_RUBRIC_ASSESSMENT;
CREATE TABLE D2L_RUBRIC_ASSESSMENT (
  RubricId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  Score NUMBER(36, 2) DEFAULT NULL,
  AssessedByUserId NUMBER(10) DEFAULT NULL,
  AssessmentDate DATE NOT NULL,
  IsCompleted NUMBER(1) NOT NULL,
  ActivityType NVARCHAR2(50) DEFAULT NULL,
  ActivityObjectId NUMBER(20) DEFAULT NULL,
  DateCreated DATE NOT NULL,
  AssessmentId NUMBER(20) NOT NULL,
  LevelAchievedId NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_RUBRIC_ASSESSMENT_PK ON D2L_RUBRIC_ASSESSMENT (UserId,AssessmentId);
QUIT;
