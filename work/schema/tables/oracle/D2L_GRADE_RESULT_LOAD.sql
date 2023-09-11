DROP TABLE D2L_GRADE_RESULT_LOAD;
CREATE TABLE D2L_GRADE_RESULT_LOAD (
  GradeObjectId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  PointsNumerator DECIMAL(19, 9) DEFAULT NULL,
  PointsDenominator DECIMAL(19, 9) DEFAULT NULL,
  WeightedNumerator DECIMAL(19, 9) DEFAULT NULL,
  WeightedDenominator DECIMAL(19, 9) DEFAULT NULL,
  IsReleased NUMBER(1) DEFAULT NULL,
  IsDropped NUMBER(1) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  Comments NVARCHAR2(1250) DEFAULT NULL,
  PrivateComments NVARCHAR2(1250) DEFAULT NULL,
  IsExempt NUMBER(1) DEFAULT NULL,
  GradeText NVARCHAR2(62) DEFAULT NULL,
  GradeReleasedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_GRADE_RESULT_LOAD_PK ON D2L_GRADE_RESULT_LOAD (GradeObjectId,OrgUnitId,UserId);
QUIT;
