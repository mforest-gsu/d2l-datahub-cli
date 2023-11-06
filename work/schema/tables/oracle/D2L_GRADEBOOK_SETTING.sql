DROP TABLE D2L_GRADEBOOK_SETTING;
CREATE TABLE D2L_GRADEBOOK_SETTING (
  OrgUnitId NUMBER(10) NOT NULL,
  GradeSchemeId NUMBER(20) NOT NULL,
  GradingSystem VARCHAR2(16 CHAR) DEFAULT NULL,
  UngradedItems VARCHAR2(50 CHAR) DEFAULT NULL,
  IsAdjustedFinalGradeReleased NUMBER(1) DEFAULT NULL,
  IsCalculatedFinalGradeReleased NUMBER(1) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_GRADEBOOK_SETTING_PK ON D2L_GRADEBOOK_SETTING (OrgUnitId,GradeSchemeId);
QUIT;
