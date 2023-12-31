DROP TABLE D2L_COMPETENCY_OBJECT_LOAD;
CREATE TABLE D2L_COMPETENCY_OBJECT_LOAD (
  ObjectId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Name NVARCHAR2(512) DEFAULT NULL,
  Type VARCHAR2(512 CHAR) DEFAULT NULL,
  ReadyForEvaluation NUMBER(1) DEFAULT NULL,
  Status VARCHAR2(18 CHAR) DEFAULT NULL,
  Description NVARCHAR2(2000) DEFAULT NULL,
  NeedReevaluation NUMBER(1) DEFAULT NULL,
  ReevaluationIfAchieved NUMBER(1) DEFAULT NULL,
  ReevaluationIfNotAchieved NUMBER(1) DEFAULT NULL,
  AdditionalIdentifier NVARCHAR2(1024) DEFAULT NULL,
  IsHidden NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_COMPETENCY_OBJECT_LOAD_PK ON D2L_COMPETENCY_OBJECT_LOAD (ObjectId);
QUIT;
