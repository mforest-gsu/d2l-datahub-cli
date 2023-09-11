DROP TABLE D2L_DISCUSSION_POST_LOAD;
CREATE TABLE D2L_DISCUSSION_POST_LOAD (
  OrgUnitId NUMBER(10) DEFAULT NULL,
  TopicId NUMBER(20) DEFAULT NULL,
  UserId NUMBER(10) DEFAULT NULL,
  PostId NUMBER(20) NOT NULL,
  ThreadId NUMBER(20) DEFAULT NULL,
  IsReply NUMBER(1) DEFAULT NULL,
  ParentPostId NUMBER(20) DEFAULT NULL,
  NumReplies NUMBER(10) DEFAULT NULL,
  DatePosted TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  RatingSum NUMBER(20) DEFAULT NULL,
  NumRatings NUMBER(20) DEFAULT NULL,
  Score DECIMAL(19, 9) DEFAULT NULL,
  LastEditDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  SortOrder NUMBER(10) DEFAULT NULL,
  Depth NUMBER(10) DEFAULT NULL,
  Thread NVARCHAR2(500) DEFAULT NULL,
  WordCount NUMBER(10) DEFAULT NULL,
  AttachmentCount NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_DISCUSSION_POST_LOAD_PK ON D2L_DISCUSSION_POST_LOAD (PostId);
QUIT;
