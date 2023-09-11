DROP TABLE D2L_ATTENDANCE_REGISTER;
CREATE TABLE D2L_ATTENDANCE_REGISTER (
  AttendanceRegisterId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Name NVARCHAR2(160) DEFAULT NULL,
  Description NVARCHAR2(1250) DEFAULT NULL,
  SchemeId NUMBER(20) DEFAULT NULL,
  IsVisible NUMBER(1) DEFAULT NULL,
  IncludeAllUsers NUMBER(1) DEFAULT NULL,
  CauseForConcern DECIMAL(19, 9) DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ATTENDANCE_REGISTER_PK ON D2L_ATTENDANCE_REGISTER (AttendanceRegisterId);
QUIT;
