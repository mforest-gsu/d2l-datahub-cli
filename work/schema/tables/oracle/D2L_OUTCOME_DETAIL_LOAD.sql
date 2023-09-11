DROP TABLE D2L_OUTCOME_DETAIL_LOAD;
CREATE TABLE D2L_OUTCOME_DETAIL_LOAD (
  OutcomeId VARCHAR2(36) NOT NULL,
  OutcomeDefinitionSource NVARCHAR2(1250) DEFAULT NULL,
  OutcomeDefinitionId NVARCHAR2(160) DEFAULT NULL,
  ParentOutcomeId VARCHAR2(36) DEFAULT NULL,
  Description NVARCHAR2(1250) DEFAULT NULL,
  Notation NVARCHAR2(1250) DEFAULT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOME_DETAIL_LOAD_PK ON D2L_OUTCOME_DETAIL_LOAD (OutcomeId);
QUIT;
