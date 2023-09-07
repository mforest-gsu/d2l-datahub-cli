DROP TABLE D2L_GRADE_OBJECT;
CREATE TABLE D2L_GRADE_OBJECT (
  GradeObjectId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  ParentGradeObjectId NUMBER(10) DEFAULT NULL,
  Name NVARCHAR2(128) NOT NULL,
  TypeName VARCHAR2(50) DEFAULT NULL,
  StartDate DATE DEFAULT NULL,
  EndDate DATE DEFAULT NULL,
  IsAutoPointed NUMBER(1) NOT NULL,
  IsFormula NUMBER(1) NOT NULL,
  IsBonus NUMBER(1) NOT NULL,
  MaxPoints NUMBER(19, 9) NOT NULL,
  CanExceedMaxGrade NUMBER(1) NOT NULL,
  ExcludeFromFinalGradeCalc NUMBER(1) NOT NULL,
  GradeSchemeId NUMBER(20) DEFAULT NULL,
  Weight NUMBER(19, 9) DEFAULT NULL,
  NumLowestGradesToDrop NUMBER(10) NOT NULL,
  NumHighestGradesToDrop NUMBER(10) NOT NULL,
  WeightDistributionType VARCHAR2(8) DEFAULT NULL,
  CreatedDate DATE DEFAULT NULL,
  ToolName NVARCHAR2(50) DEFAULT NULL,
  AssociatedToolItemId NUMBER(20) DEFAULT NULL,
  LastModified DATE NOT NULL,
  ShortName NVARCHAR2(128) DEFAULT NULL,
  GradeObjectTypeId NUMBER(10) NOT NULL,
  SortOrder NUMBER(10) NOT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  DeletedDate DATE DEFAULT NULL,
  DeletedByUserId NUMBER(10) DEFAULT NULL,
  ResultId NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_GRADE_OBJECT_PK ON D2L_GRADE_OBJECT (GradeObjectId);
QUIT;
