DROP TABLE D2L_QUIZ_ATTEMPT_LOG;
CREATE TABLE D2L_QUIZ_ATTEMPT_LOG (
  LogId NUMBER(20) NOT NULL,
  AttemptId NUMBER(20) DEFAULT NULL,
  EventTypeId NUMBER(10) DEFAULT NULL,
  Name NVARCHAR2(512) DEFAULT NULL,
  Description NVARCHAR2(512) DEFAULT NULL,
  EventTime TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IPAddress VARCHAR2(30 CHAR) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_QUIZ_ATTEMPT_LOG_PK ON D2L_QUIZ_ATTEMPT_LOG (LogId);
QUIT;
