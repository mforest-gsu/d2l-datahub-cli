DROP TABLE D2L_PORTFOLIO_EVIDENCE_LOG;
CREATE TABLE D2L_PORTFOLIO_EVIDENCE_LOG (
  LogId VARCHAR2(16) NOT NULL,
  ParentObjectId VARCHAR2(16) DEFAULT NULL,
  ObjectId VARCHAR2(16) NOT NULL,
  ObjectType NVARCHAR2(40) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Action NVARCHAR2(16) NOT NULL,
  IsMobile NUMBER(1) NOT NULL,
  ActionDate DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_PORTFOLIO_EVIDENCE_LOG_PK ON D2L_PORTFOLIO_EVIDENCE_LOG (LogId);
QUIT;
