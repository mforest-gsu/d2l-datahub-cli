DROP TABLE D2L_RUBRIC_EDIT;
CREATE TABLE D2L_RUBRIC_EDIT (
  AuditLogId VARCHAR2(36) NOT NULL,
  RubricId NUMBER(20) DEFAULT NULL,
  CriterionId NUMBER(20) DEFAULT NULL,
  LevelId NUMBER(20) DEFAULT NULL,
  ModifiedBy NUMBER(10) DEFAULT NULL,
  ModifiedObjectType NUMBER(10) DEFAULT NULL,
  CriteriaGroupId NUMBER(20) DEFAULT NULL,
  ModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  PreviousValue NVARCHAR2(4000) DEFAULT NULL,
  ModifiedValue NVARCHAR2(4000) DEFAULT NULL,
  IsLocked NUMBER(1) DEFAULT NULL,
  Version NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_RUBRIC_EDIT_PK ON D2L_RUBRIC_EDIT (AuditLogId);
QUIT;
