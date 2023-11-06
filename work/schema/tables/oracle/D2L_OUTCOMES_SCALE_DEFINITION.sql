DROP TABLE D2L_OUTCOMES_SCALE_DEFINITION;
CREATE TABLE D2L_OUTCOMES_SCALE_DEFINITION (
  ScaleId VARCHAR2(36) NOT NULL,
  Name NVARCHAR2(2000) DEFAULT NULL,
  IsDefault NUMBER(1) DEFAULT NULL,
  UsePercentages NUMBER(1) DEFAULT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  RegistryId VARCHAR2(36) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOMES_SCALE_DEFINITION_PK ON D2L_OUTCOMES_SCALE_DEFINITION (ScaleId);
QUIT;
