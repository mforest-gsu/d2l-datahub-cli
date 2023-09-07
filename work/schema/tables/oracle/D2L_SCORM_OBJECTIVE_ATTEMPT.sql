DROP TABLE D2L_SCORM_OBJECTIVE_ATTEMPT;
CREATE TABLE D2L_SCORM_OBJECTIVE_ATTEMPT (
  VisitId VARCHAR2(16) NOT NULL,
  ObjectiveId VARCHAR2(16) NOT NULL,
  AttemptNumber NUMBER(10) NOT NULL,
  Score FLOAT(24) DEFAULT NULL,
  ScoreRaw FLOAT(24) DEFAULT NULL,
  Success NVARCHAR2(100) DEFAULT NULL,
  Completion NVARCHAR2(100) DEFAULT NULL,
  Progress FLOAT(24) DEFAULT NULL,
  LastModified DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_SCORM_OBJECTIVE_ATTEMPT_PK ON D2L_SCORM_OBJECTIVE_ATTEMPT (VisitId,ObjectiveId,AttemptNumber);
QUIT;
