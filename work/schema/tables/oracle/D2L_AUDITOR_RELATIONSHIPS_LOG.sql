DROP TABLE D2L_AUDITOR_RELATIONSHIPS_LOG;
CREATE TABLE D2L_AUDITOR_RELATIONSHIPS_LOG (
  AuditorId NUMBER(10) NOT NULL,
  UserToAuditId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) NOT NULL,
  Action NVARCHAR2(20) DEFAULT NULL,
  ModifiedBy NUMBER(10) DEFAULT NULL,
  ModifiedDate TIMESTAMP WITH LOCAL TIME ZONE NOT NULL
);
CREATE UNIQUE INDEX D2L_AUDITOR_RELATIONSHIPS_LOG_PK ON D2L_AUDITOR_RELATIONSHIPS_LOG (AuditorId,UserToAuditId,OrgUnitId,ModifiedDate);
QUIT;
