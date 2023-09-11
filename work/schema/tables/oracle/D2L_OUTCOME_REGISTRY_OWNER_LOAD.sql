DROP TABLE D2L_OUTCOME_REGISTRY_OWNER_LOAD;
CREATE TABLE D2L_OUTCOME_REGISTRY_OWNER_LOAD (
  OwnerType NUMBER(10) NOT NULL,
  OwnerId NVARCHAR2(318) NOT NULL,
  RegistryId VARCHAR2(36) NOT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOME_REGISTRY_OWNER_LOAD_PK ON D2L_OUTCOME_REGISTRY_OWNER_LOAD (OwnerType,OwnerId,RegistryId);
QUIT;
