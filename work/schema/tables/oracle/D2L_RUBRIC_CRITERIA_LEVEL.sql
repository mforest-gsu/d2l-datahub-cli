DROP TABLE D2L_RUBRIC_CRITERIA_LEVEL;
CREATE TABLE D2L_RUBRIC_CRITERIA_LEVEL (
  RubricId NUMBER(20) NOT NULL,
  CriterionId NUMBER(20) NOT NULL,
  Description NVARCHAR2(1250) DEFAULT NULL,
  Feedback NVARCHAR2(1250) DEFAULT NULL,
  Value DECIMAL(19, 9) DEFAULT NULL,
  LevelId NUMBER(20) NOT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_RUBRIC_CRITERIA_LEVEL_PK ON D2L_RUBRIC_CRITERIA_LEVEL (RubricId,CriterionId,LevelId);
QUIT;
