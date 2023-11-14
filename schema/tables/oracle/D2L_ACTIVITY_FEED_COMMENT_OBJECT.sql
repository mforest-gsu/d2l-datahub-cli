DROP TABLE D2L_ACTIVITY_FEED_COMMENT_OBJECT;
CREATE TABLE D2L_ACTIVITY_FEED_COMMENT_OBJECT (
  OrgUnitId NUMBER(10) DEFAULT NULL,
  CommentId VARCHAR2(36) NOT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  Content NVARCHAR2(4000) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  PostId VARCHAR2(36) DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ACTIVITY_FEED_COMMENT_OBJECT_PK ON D2L_ACTIVITY_FEED_COMMENT_OBJECT (CommentId);
QUIT;