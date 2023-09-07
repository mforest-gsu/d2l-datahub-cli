DROP TABLE D2L_SCORM_INTERACTION_LOAD;
CREATE TABLE D2L_SCORM_INTERACTION_LOAD (
  InteractionId VARCHAR2(16) NOT NULL,
  ActivityId VARCHAR2(16) NOT NULL,
  InternalId NVARCHAR2(255) DEFAULT NULL,
  InteractionType NVARCHAR2(100) NOT NULL,
  Description NVARCHAR2(250) DEFAULT NULL,
  Weighting FLOAT(24) DEFAULT NULL,
  CorrectResponses NVARCHAR2(2000) DEFAULT NULL,
  LastModified DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_SCORM_INTERACTION_LOAD_PK ON D2L_SCORM_INTERACTION_LOAD (InteractionId);
QUIT;
