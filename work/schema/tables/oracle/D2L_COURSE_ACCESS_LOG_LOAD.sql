DROP TABLE D2L_COURSE_ACCESS_LOG_LOAD;
CREATE TABLE D2L_COURSE_ACCESS_LOG_LOAD (
  OrgUnitId NUMBER(10) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  Timestamp TIMESTAMP WITH LOCAL TIME ZONE NOT NULL,
  Source NVARCHAR2(40) NOT NULL
);
CREATE UNIQUE INDEX D2L_COURSE_ACCESS_LOG_LOAD_PK ON D2L_COURSE_ACCESS_LOG_LOAD (OrgUnitId,UserId,Timestamp,Source);
QUIT;
