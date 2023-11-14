DROP TABLE D2L_RUBRIC_ASSESSMENT;
CREATE TABLE D2L_RUBRIC_ASSESSMENT (
  RubricId NUMBER(20) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  UserId NUMBER(10) NOT NULL,
  Score DECIMAL(36, 2) DEFAULT NULL,
  AssessedByUserId NUMBER(10) DEFAULT NULL,
  AssessmentDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsCompleted NUMBER(1) DEFAULT NULL,
  ActivityType NVARCHAR2(100) DEFAULT NULL,
  ActivityObjectId NUMBER(20) DEFAULT NULL,
  DateCreated TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  AssessmentId NUMBER(20) NOT NULL,
  LevelAchievedId NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_RUBRIC_ASSESSMENT_PK ON D2L_RUBRIC_ASSESSMENT (UserId,AssessmentId);
QUIT;