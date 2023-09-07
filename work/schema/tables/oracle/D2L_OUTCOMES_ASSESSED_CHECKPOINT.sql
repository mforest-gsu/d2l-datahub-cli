DROP TABLE D2L_OUTCOMES_ASSESSED_CHECKPOINT;
CREATE TABLE D2L_OUTCOMES_ASSESSED_CHECKPOINT (
  CheckpointId VARCHAR2(16) NOT NULL,
  DemonstrationId VARCHAR2(16) NOT NULL,
  Feedback NVARCHAR2(1000) NOT NULL,
  ConfigDecayRate NUMBER(10) NOT NULL,
  ConfigAggregationMethod NUMBER(10) NOT NULL,
  ConfigIncludedActivities NUMBER(10) NOT NULL,
  ConfigMultipleAttemptStrategy NUMBER(10) NOT NULL,
  ConfigRecentlyAssessedActivityCount NUMBER(10) NOT NULL,
  ConfigTieBreaker NUMBER(10) NOT NULL,
  LastModifiedDate DATE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) NOT NULL
);
CREATE UNIQUE INDEX D2L_OUTCOMES_ASSESSED_CHECKPOINT_PK ON D2L_OUTCOMES_ASSESSED_CHECKPOINT (CheckpointId,DemonstrationId);
QUIT;
