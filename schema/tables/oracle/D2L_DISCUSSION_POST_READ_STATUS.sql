DROP TABLE D2L_DISCUSSION_POST_READ_STATUS;
CREATE TABLE D2L_DISCUSSION_POST_READ_STATUS (
  TopicId NUMBER(20) DEFAULT NULL,
  UserId NUMBER(10) NOT NULL,
  PostId NUMBER(20) NOT NULL,
  IsRead NUMBER(1) DEFAULT NULL,
  FirstReadDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastReadDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_DISCUSSION_POST_READ_STATUS_PK ON D2L_DISCUSSION_POST_READ_STATUS (UserId,PostId);
QUIT;