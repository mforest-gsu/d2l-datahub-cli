DROP TABLE D2L_SIS_COURSE_MERGE_LOG;
CREATE TABLE D2L_SIS_COURSE_MERGE_LOG (
  BatchId VARCHAR2(36) NOT NULL,
  JobType NVARCHAR2(64) DEFAULT NULL,
  Status NVARCHAR2(64) DEFAULT NULL,
  OriginalTargetOrgUnitId NUMBER(20) DEFAULT NULL,
  OriginalSourceOrgUnitId NUMBER(20) NOT NULL,
  SourceSystemId NUMBER(20) DEFAULT NULL,
  NumberOfCoursesInBatch NUMBER(10) DEFAULT NULL,
  UserId NUMBER(20) DEFAULT NULL,
  ErrorType NVARCHAR2(96) DEFAULT NULL,
  Timestamp TIMESTAMP WITH LOCAL TIME ZONE NOT NULL
);
CREATE UNIQUE INDEX D2L_SIS_COURSE_MERGE_LOG_PK ON D2L_SIS_COURSE_MERGE_LOG (BatchId,OriginalSourceOrgUnitId,Timestamp);
QUIT;
