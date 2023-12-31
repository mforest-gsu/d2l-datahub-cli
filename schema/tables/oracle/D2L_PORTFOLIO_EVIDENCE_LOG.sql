DROP TABLE D2L_PORTFOLIO_EVIDENCE_LOG;
CREATE TABLE D2L_PORTFOLIO_EVIDENCE_LOG (
  LogId VARCHAR2(36) NOT NULL,
  ParentObjectId VARCHAR2(36) DEFAULT NULL,
  ObjectId VARCHAR2(36) DEFAULT NULL,
  ObjectType NVARCHAR2(80) DEFAULT NULL,
  UserId NUMBER(10) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Action NVARCHAR2(32) DEFAULT NULL,
  IsMobile NUMBER(1) DEFAULT NULL,
  ActionDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_PORTFOLIO_EVIDENCE_LOG_PK ON D2L_PORTFOLIO_EVIDENCE_LOG (LogId);
QUIT;
