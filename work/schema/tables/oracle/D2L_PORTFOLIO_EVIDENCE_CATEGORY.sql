DROP TABLE D2L_PORTFOLIO_EVIDENCE_CATEGORY;
CREATE TABLE D2L_PORTFOLIO_EVIDENCE_CATEGORY (
  CategoryId VARCHAR2(36) NOT NULL,
  EvidenceId VARCHAR2(36) NOT NULL,
  D2LGroup NVARCHAR2(37) NOT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_PORTFOLIO_EVIDENCE_CATEGORY_PK ON D2L_PORTFOLIO_EVIDENCE_CATEGORY (CategoryId,EvidenceId,D2LGroup);
QUIT;
