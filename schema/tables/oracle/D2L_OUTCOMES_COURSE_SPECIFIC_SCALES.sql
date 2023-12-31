DROP TABLE D2L_OUTCOMES_COURSE_SPECIFIC_SCALES;
CREATE TABLE D2L_OUTCOMES_COURSE_SPECIFIC_SCALES (
  OrgUnitId NUMBER(10) NOT NULL,
  RegistryId VARCHAR2(36) DEFAULT NULL,
  ScaleId VARCHAR2(36) DEFAULT NULL,
  AchievementThreshold VARCHAR2(36) DEFAULT NULL,
  CreatedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOMES_COURSE_SPECIFIC_SCALES_PK ON D2L_OUTCOMES_COURSE_SPECIFIC_SCALES (OrgUnitId);
QUIT;
