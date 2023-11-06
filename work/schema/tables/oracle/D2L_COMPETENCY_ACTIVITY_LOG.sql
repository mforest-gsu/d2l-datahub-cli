DROP TABLE D2L_COMPETENCY_ACTIVITY_LOG;
CREATE TABLE D2L_COMPETENCY_ACTIVITY_LOG (
  ActivityId NUMBER(20) NOT NULL,
  ActivityLogId NUMBER(20) NOT NULL,
  LogTypeId NUMBER(10) DEFAULT NULL,
  LogTypeName VARCHAR2(38 CHAR) DEFAULT NULL,
  LogDateTime TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ModifiedBy NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_COMPETENCY_ACTIVITY_LOG_PK ON D2L_COMPETENCY_ACTIVITY_LOG (ActivityId,ActivityLogId);
QUIT;
