DROP TABLE D2L_OUTCOMES_ALIGNED_TO_TOOL_OBJECT;
CREATE TABLE D2L_OUTCOMES_ALIGNED_TO_TOOL_OBJECT (
  ObjectType NUMBER(10) NOT NULL,
  ObjectId NVARCHAR2(510) NOT NULL,
  OutcomeId VARCHAR2(36) NOT NULL,
  RegistryId VARCHAR2(36) NOT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOMES_ALIGNED_TO_TOOL_OBJECT_PK ON D2L_OUTCOMES_ALIGNED_TO_TOOL_OBJECT (ObjectType,ObjectId,OutcomeId,RegistryId);
QUIT;