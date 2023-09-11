DROP TABLE D2L_ACTIVITY_FEED_POST_OBJECT;
CREATE TABLE D2L_ACTIVITY_FEED_POST_OBJECT (
  OrgUnitId NUMBER(10) DEFAULT NULL,
  PostId VARCHAR2(36) NOT NULL,
  PostType NVARCHAR2(20) DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  DropboxId NUMBER(20) DEFAULT NULL,
  Content NVARCHAR2(3840) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  CommentCount NUMBER(10) DEFAULT NULL,
  AttachmentCount NUMBER(10) DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ACTIVITY_FEED_POST_OBJECT_PK ON D2L_ACTIVITY_FEED_POST_OBJECT (PostId);
QUIT;
