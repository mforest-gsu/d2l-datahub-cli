DROP TABLE D2L_OUTCOMES_PROGRAM_DETAIL;
CREATE TABLE D2L_OUTCOMES_PROGRAM_DETAIL (
  ProgramId NUMBER(20) NOT NULL,
  ProgramName NVARCHAR2(2000) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOMES_PROGRAM_DETAIL_PK ON D2L_OUTCOMES_PROGRAM_DETAIL (ProgramId);
QUIT;
