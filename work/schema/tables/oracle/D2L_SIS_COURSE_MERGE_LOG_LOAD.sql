DROP TABLE D2L_SIS_COURSE_MERGE_LOG_LOAD;
CREATE TABLE D2L_SIS_COURSE_MERGE_LOG_LOAD (
  BatchId VARCHAR2(16) NOT NULL,
  JobType NVARCHAR2(32) NOT NULL,
  Status NVARCHAR2(32) NOT NULL,
  OriginalTargetOrgUnitId NUMBER(20) NOT NULL,
  OriginalSourceOrgUnitId NUMBER(20) NOT NULL,
  SourceSystemId NUMBER(20) NOT NULL,
  NumberOfCoursesInBatch NUMBER(10) DEFAULT NULL,
  UserId NUMBER(20) NOT NULL,
  ErrorType NVARCHAR2(48) DEFAULT NULL,
  Timestamp DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_SIS_COURSE_MERGE_LOG_LOAD_PK ON D2L_SIS_COURSE_MERGE_LOG_LOAD (BatchId,OriginalSourceOrgUnitId,Timestamp);
QUIT;
