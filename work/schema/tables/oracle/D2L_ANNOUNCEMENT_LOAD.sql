DROP TABLE D2L_ANNOUNCEMENT_LOAD;
CREATE TABLE D2L_ANNOUNCEMENT_LOAD (
  AnnouncementId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(20) DEFAULT NULL,
  Title NVARCHAR2(800) DEFAULT NULL,
  StartDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  EndDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsGlobal NUMBER(1) DEFAULT NULL,
  IsDraft NUMBER(1) DEFAULT NULL,
  NumAttachments NUMBER(10) DEFAULT NULL,
  DeletedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  DeletedByUserId NUMBER(10) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  CreatedBy NUMBER(10) DEFAULT NULL,
  IsAuthorInfoShown NUMBER(1) DEFAULT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ResultId NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ANNOUNCEMENT_LOAD_PK ON D2L_ANNOUNCEMENT_LOAD (AnnouncementId);
QUIT;
