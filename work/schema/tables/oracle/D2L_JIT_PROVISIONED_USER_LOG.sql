DROP TABLE D2L_JIT_PROVISIONED_USER_LOG;
CREATE TABLE D2L_JIT_PROVISIONED_USER_LOG (
  UserId NUMBER(10) NOT NULL,
  MappingField NVARCHAR2(32) NOT NULL,
  MappingFieldValue NVARCHAR2(270) NOT NULL,
  ProviderType NVARCHAR2(32) NOT NULL,
  ProviderId NVARCHAR2(1024) NOT NULL,
  RoleId NUMBER(10) NOT NULL,
  Timestamp DATE NOT NULL,
  Action NVARCHAR2(16) NOT NULL
);
CREATE UNIQUE INDEX D2L_JIT_PROVISIONED_USER_LOG_PK ON D2L_JIT_PROVISIONED_USER_LOG (UserId,Timestamp);
QUIT;
