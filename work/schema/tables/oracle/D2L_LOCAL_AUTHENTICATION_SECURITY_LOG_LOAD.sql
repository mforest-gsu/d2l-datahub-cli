DROP TABLE D2L_LOCAL_AUTHENTICATION_SECURITY_LOG_LOAD;
CREATE TABLE D2L_LOCAL_AUTHENTICATION_SECURITY_LOG_LOAD (
  UserId NUMBER(10) NOT NULL,
  Action NVARCHAR2(70) NOT NULL,
  ModifiedBy NUMBER(10) NOT NULL,
  ModifiedDate DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_LOCAL_AUTHENTICATION_SECURITY_LOG_LOAD_PK ON D2L_LOCAL_AUTHENTICATION_SECURITY_LOG_LOAD (UserId,Action,ModifiedBy,ModifiedDate);
QUIT;
