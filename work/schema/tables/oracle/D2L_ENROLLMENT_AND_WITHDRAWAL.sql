DROP TABLE D2L_ENROLLMENT_AND_WITHDRAWAL;
CREATE TABLE D2L_ENROLLMENT_AND_WITHDRAWAL (
  LogId NUMBER(20) NOT NULL,
  UserId NUMBER(10) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  RoleId NUMBER(10) DEFAULT NULL,
  Action VARCHAR2(62 CHAR) DEFAULT NULL,
  EnrollmentType VARCHAR2(62 CHAR) DEFAULT NULL,
  ModifiedByUserId NUMBER(10) DEFAULT NULL,
  EnrollmentDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ENROLLMENT_AND_WITHDRAWAL_PK ON D2L_ENROLLMENT_AND_WITHDRAWAL (LogId);
QUIT;
