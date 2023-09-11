DROP TABLE D2L_ACCOMMODATION_PROFILE_LOG;
CREATE TABLE D2L_ACCOMMODATION_PROFILE_LOG (
  AccommodatedUserId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(20) NOT NULL,
  QuizTimeLimitMultiplier DECIMAL(5,2) DEFAULT NULL,
  QuizTimeLimitExtraTime NUMBER(10) DEFAULT NULL,
  QuizControlAlwaysAllowRightClick NUMBER(1) DEFAULT NULL,
  ModifiedBy NUMBER(20) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE NOT NULL
);
CREATE UNIQUE INDEX D2L_ACCOMMODATION_PROFILE_LOG_PK ON D2L_ACCOMMODATION_PROFILE_LOG (AccommodatedUserId,OrgUnitId,LastModified);
QUIT;
