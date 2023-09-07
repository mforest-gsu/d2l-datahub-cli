DROP TABLE D2L_ACTIVITY_FEED_POST_OBJECT_LOAD;
CREATE TABLE D2L_ACTIVITY_FEED_POST_OBJECT_LOAD (
  OrgUnitId NUMBER(10) NOT NULL,
  PostId VARCHAR2(16) NOT NULL,
  PostType NVARCHAR2(16) NOT NULL,
  LastModifiedBy NUMBER(10) NOT NULL,
  LastModified DATE NOT NULL,
  DropboxId NUMBER(20) DEFAULT NULL,
  Content NVARCHAR2(3072) DEFAULT NULL,
  IsDeleted NUMBER(1) NOT NULL,
  CommentCount NUMBER(10) NOT NULL,
  AttachmentCount NUMBER(10) DEFAULT NULL,
  Version NUMBER(20) NOT NULL
);
CREATE UNIQUE INDEX D2L_ACTIVITY_FEED_POST_OBJECT_LOAD_PK ON D2L_ACTIVITY_FEED_POST_OBJECT_LOAD (PostId);
QUIT;
