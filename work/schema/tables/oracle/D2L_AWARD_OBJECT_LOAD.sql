DROP TABLE D2L_AWARD_OBJECT_LOAD;
CREATE TABLE D2L_AWARD_OBJECT_LOAD (
  AwardId NUMBER(20) NOT NULL,
  Name NVARCHAR2(320) DEFAULT NULL,
  AwardTypeId NUMBER(10) DEFAULT NULL,
  Type NVARCHAR2(160) DEFAULT NULL,
  Description NVARCHAR2(640) DEFAULT NULL,
  ExpiryCalculationType NVARCHAR2(160) DEFAULT NULL,
  ExpiryNotificationType NVARCHAR2(160) DEFAULT NULL,
  ExpiryDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ImagePath VARCHAR2(1250 CHAR) DEFAULT NULL,
  CreatedByUserId NUMBER(20) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  Criteria NVARCHAR2(1250) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_AWARD_OBJECT_LOAD_PK ON D2L_AWARD_OBJECT_LOAD (AwardId);
QUIT;
