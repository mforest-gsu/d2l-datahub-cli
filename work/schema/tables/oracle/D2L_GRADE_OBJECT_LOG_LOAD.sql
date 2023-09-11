DROP TABLE D2L_GRADE_OBJECT_LOG_LOAD;
CREATE TABLE D2L_GRADE_OBJECT_LOG_LOAD (
  LogId NUMBER(20) NOT NULL,
  Name NVARCHAR2(62) DEFAULT NULL,
  GradeObjectId NUMBER(10) DEFAULT NULL,
  UserId NUMBER(10) DEFAULT NULL,
  GradeSymbolString NVARCHAR2(62) DEFAULT NULL,
  PointsDenominator DECIMAL(19, 9) DEFAULT NULL,
  PointsNumerator DECIMAL(19, 9) DEFAULT NULL,
  WeightedDenominator DECIMAL(19, 9) DEFAULT NULL,
  WeightedNumerator DECIMAL(19, 9) DEFAULT NULL,
  Modified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ModifiedBy NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_GRADE_OBJECT_LOG_LOAD_PK ON D2L_GRADE_OBJECT_LOG_LOAD (LogId);
QUIT;
