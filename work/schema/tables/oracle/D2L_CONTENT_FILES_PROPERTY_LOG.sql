DROP TABLE D2L_CONTENT_FILES_PROPERTY_LOG;
CREATE TABLE D2L_CONTENT_FILES_PROPERTY_LOG (
  OrgUnitId NUMBER(10) NOT NULL,
  ContentObjectId NUMBER(10) NOT NULL,
  Action NVARCHAR2(20) DEFAULT NULL,
  FilePath NVARCHAR2(4000) DEFAULT NULL,
  FileName NVARCHAR2(1024) DEFAULT NULL,
  FileExtension NVARCHAR2(1024) DEFAULT NULL,
  FileSizeBytes NUMBER(20) DEFAULT NULL,
  UploadDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE NOT NULL
);
CREATE UNIQUE INDEX D2L_CONTENT_FILES_PROPERTY_LOG_PK ON D2L_CONTENT_FILES_PROPERTY_LOG (OrgUnitId,ContentObjectId,LastModified);
QUIT;
