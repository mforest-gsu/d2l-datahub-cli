DROP TABLE D2L_PREREQUISITE_CONDITION_MET;
CREATE TABLE D2L_PREREQUISITE_CONDITION_MET (
  PreRequisiteId NUMBER(10) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  DateMet DATE DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_PREREQUISITE_CONDITION_MET_PK ON D2L_PREREQUISITE_CONDITION_MET (PreRequisiteId,UserId);
QUIT;
