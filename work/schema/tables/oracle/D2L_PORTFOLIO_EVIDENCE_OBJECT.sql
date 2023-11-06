DROP TABLE D2L_PORTFOLIO_EVIDENCE_OBJECT;
CREATE TABLE D2L_PORTFOLIO_EVIDENCE_OBJECT (
  EvidenceId VARCHAR2(36) NOT NULL,
  OwnerId NUMBER(10) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  EvidenceType NVARCHAR2(60) DEFAULT NULL,
  Title NVARCHAR2(2000) DEFAULT NULL,
  IsApproved NUMBER(1) DEFAULT NULL,
  IsSpotlighted NUMBER(1) DEFAULT NULL,
  IsSharedToParents NUMBER(1) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  IsRecoverableByInstructor NUMBER(1) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsSharedWithInstructor NUMBER(1) DEFAULT NULL,
  DateSharedWithInstructor TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_PORTFOLIO_EVIDENCE_OBJECT_PK ON D2L_PORTFOLIO_EVIDENCE_OBJECT (EvidenceId);
QUIT;
