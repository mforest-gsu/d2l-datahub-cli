DROP TABLE D2L_CONTENT_OBJECT_LOAD;
CREATE TABLE D2L_CONTENT_OBJECT_LOAD (
  ContentObjectId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Title NVARCHAR2(187) DEFAULT NULL,
  ContentObjectType VARCHAR2(7 CHAR) DEFAULT NULL,
  CompletionType VARCHAR2(8 CHAR) DEFAULT NULL,
  ParentContentObjectId NUMBER(10) DEFAULT NULL,
  Location NVARCHAR2(1280) DEFAULT NULL,
  StartDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  EndDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  DueDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ObjectId1 NUMBER(10) DEFAULT NULL,
  ObjectId2 NUMBER(10) DEFAULT NULL,
  ObjectId3 NUMBER(10) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  SortOrder NUMBER(10) DEFAULT NULL,
  Depth NUMBER(10) DEFAULT NULL,
  ToolId NUMBER(10) DEFAULT NULL,
  IsHidden NUMBER(1) DEFAULT NULL,
  ResultId NUMBER(10) DEFAULT NULL,
  DeletedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  DeletedBy NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_CONTENT_OBJECT_LOAD_PK ON D2L_CONTENT_OBJECT_LOAD (ContentObjectId);
QUIT;
