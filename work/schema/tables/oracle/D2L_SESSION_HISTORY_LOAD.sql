DROP TABLE D2L_SESSION_HISTORY_LOAD;
CREATE TABLE D2L_SESSION_HISTORY_LOAD (
  SessionId NUMBER(20) DEFAULT NULL,
  OrgId NUMBER(10) DEFAULT NULL,
  UserId NUMBER(10) DEFAULT NULL,
  DateStarted TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  DateEnded TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastAccessed TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  TimedOut NUMBER(1) DEFAULT NULL,
  HistoryID NUMBER(20) NOT NULL
);
CREATE UNIQUE INDEX D2L_SESSION_HISTORY_LOAD_PK ON D2L_SESSION_HISTORY_LOAD (HistoryID);
QUIT;
