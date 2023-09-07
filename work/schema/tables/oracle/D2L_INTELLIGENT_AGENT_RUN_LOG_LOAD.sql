DROP TABLE D2L_INTELLIGENT_AGENT_RUN_LOG_LOAD;
CREATE TABLE D2L_INTELLIGENT_AGENT_RUN_LOG_LOAD (
  AgentId NUMBER(20) NOT NULL,
  AgentRunId NUMBER(20) NOT NULL,
  IsPracticeRun NUMBER(1) NOT NULL,
  IsRunNow NUMBER(1) NOT NULL,
  NumUsers NUMBER(10) NOT NULL,
  NumUsersWithErrors NUMBER(10) NOT NULL,
  NumUsersWithInfos NUMBER(10) NOT NULL,
  NumUsersWithWarnings NUMBER(10) NOT NULL,
  RunUserId NUMBER(10) NOT NULL,
  RunDate DATE NOT NULL
);
CREATE UNIQUE INDEX D2L_INTELLIGENT_AGENT_RUN_LOG_LOAD_PK ON D2L_INTELLIGENT_AGENT_RUN_LOG_LOAD (AgentRunId);
QUIT;
