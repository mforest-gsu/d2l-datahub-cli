DROP TABLE D2L_RUBRIC_OBJECT_CRITERIA;
CREATE TABLE D2L_RUBRIC_OBJECT_CRITERIA (
  RubricId NUMBER(20) NOT NULL,
  CriterionId NUMBER(20) NOT NULL,
  Name NVARCHAR2(256) NOT NULL,
  SortOrder NUMBER(10) NOT NULL,
  CriteriaGroupId NUMBER(20) NOT NULL,
  GroupName NVARCHAR2(256) NOT NULL,
  GroupSortOrder NUMBER(10) NOT NULL,
  LevelSetId NUMBER(20) NOT NULL,
  IsDeleted NUMBER(1) NOT NULL
);
CREATE UNIQUE INDEX D2L_RUBRIC_OBJECT_CRITERIA_PK ON D2L_RUBRIC_OBJECT_CRITERIA (CriterionId);
QUIT;
