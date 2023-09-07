DROP TABLE D2L_GRADE_OBJECT_LOG_LOAD;
CREATE TABLE D2L_GRADE_OBJECT_LOG_LOAD (
  LogId NUMBER(20) NOT NULL,
  Name NVARCHAR2(50) DEFAULT NULL,
  GradeObjectId NUMBER(10) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  GradeSymbolString NVARCHAR2(50) DEFAULT NULL,
  PointsDenominator NUMBER(19, 9) DEFAULT NULL,
  PointsNumerator NUMBER(19, 9) DEFAULT NULL,
  WeightedDenominator NUMBER(19, 9) DEFAULT NULL,
  WeightedNumerator NUMBER(19, 9) DEFAULT NULL,
  Modified DATE NOT NULL,
  ModifiedBy NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_GRADE_OBJECT_LOG_LOAD_PK ON D2L_GRADE_OBJECT_LOG_LOAD (LogId);
QUIT;
