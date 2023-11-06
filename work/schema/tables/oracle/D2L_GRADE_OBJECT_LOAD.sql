DROP TABLE D2L_GRADE_OBJECT_LOAD;
CREATE TABLE D2L_GRADE_OBJECT_LOAD (
  GradeObjectId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  ParentGradeObjectId NUMBER(10) DEFAULT NULL,
  Name NVARCHAR2(256) DEFAULT NULL,
  TypeName VARCHAR2(100 CHAR) DEFAULT NULL,
  StartDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  EndDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsAutoPointed NUMBER(1) DEFAULT NULL,
  IsFormula NUMBER(1) DEFAULT NULL,
  IsBonus NUMBER(1) DEFAULT NULL,
  MaxPoints DECIMAL(19, 9) DEFAULT NULL,
  CanExceedMaxGrade NUMBER(1) DEFAULT NULL,
  ExcludeFromFinalGradeCalc NUMBER(1) DEFAULT NULL,
  GradeSchemeId NUMBER(20) DEFAULT NULL,
  Weight DECIMAL(19, 9) DEFAULT NULL,
  NumLowestGradesToDrop NUMBER(10) DEFAULT NULL,
  NumHighestGradesToDrop NUMBER(10) DEFAULT NULL,
  WeightDistributionType VARCHAR2(16 CHAR) DEFAULT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ToolName NVARCHAR2(100) DEFAULT NULL,
  AssociatedToolItemId NUMBER(20) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ShortName NVARCHAR2(256) DEFAULT NULL,
  GradeObjectTypeId NUMBER(10) DEFAULT NULL,
  SortOrder NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  DeletedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  DeletedByUserId NUMBER(10) DEFAULT NULL,
  ResultId NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_GRADE_OBJECT_LOAD_PK ON D2L_GRADE_OBJECT_LOAD (GradeObjectId);
QUIT;
