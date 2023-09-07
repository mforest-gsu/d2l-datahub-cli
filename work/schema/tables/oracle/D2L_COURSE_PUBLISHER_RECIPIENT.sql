DROP TABLE D2L_COURSE_PUBLISHER_RECIPIENT;
CREATE TABLE D2L_COURSE_PUBLISHER_RECIPIENT (
  RecipientID VARCHAR2(16) NOT NULL,
  Name NVARCHAR2(256) NOT NULL,
  CreatedAt DATE NOT NULL,
  LastModified DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_COURSE_PUBLISHER_RECIPIENT_PK ON D2L_COURSE_PUBLISHER_RECIPIENT (RecipientID);
QUIT;
