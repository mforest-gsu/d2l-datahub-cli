DROP TABLE D2L_INTELLIGENT_AGENT_RUN_USER;
CREATE TABLE D2L_INTELLIGENT_AGENT_RUN_USER (
  AgentId NUMBER(20) NOT NULL,
  AgentRunId NUMBER(20) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  OrgUnitId NUMBER(10) NOT NULL,
  ActionTypeName NVARCHAR2(50) DEFAULT NULL,
  ActionHasError NUMBER(1) NOT NULL,
  ActionHasInfo NUMBER(1) NOT NULL,
  ActionHasWarning NUMBER(1) NOT NULL,
  ShouldRetry NUMBER(1) NOT NULL
);
CREATE UNIQUE INDEX D2L_INTELLIGENT_AGENT_RUN_USER_PK ON D2L_INTELLIGENT_AGENT_RUN_USER (AgentId,AgentRunId,UserId);
QUIT;
