DROP TABLE D2L_INTELLIGENT_AGENT_OBJECT;
CREATE TABLE D2L_INTELLIGENT_AGENT_OBJECT (
  AgentId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  AgentName NVARCHAR2(160) DEFAULT NULL,
  Description NVARCHAR2(1250) DEFAULT NULL,
  Enabled NUMBER(1) DEFAULT NULL,
  SpecificRoles NVARCHAR2(1250) DEFAULT NULL,
  LoginConditionEnabled NUMBER(1) DEFAULT NULL,
  LoginConditionThreshold NUMBER(10) DEFAULT NULL,
  LoginConditionType NVARCHAR2(17) DEFAULT NULL,
  AccessConditionEnabled NUMBER(1) DEFAULT NULL,
  AccessConditionThreshold NUMBER(10) DEFAULT NULL,
  AccessConditionType NVARCHAR2(25) DEFAULT NULL,
  ResultId NUMBER(20) DEFAULT NULL,
  RepeatType NVARCHAR2(12) DEFAULT NULL,
  EmailWhenSatisfied NUMBER(1) DEFAULT NULL,
  EnableSchedule NUMBER(1) DEFAULT NULL,
  ScheduleType NVARCHAR2(10) DEFAULT NULL,
  ScheduleRepeatsEvery NUMBER(10) DEFAULT NULL,
  StartDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  EndDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_INTELLIGENT_AGENT_OBJECT_PK ON D2L_INTELLIGENT_AGENT_OBJECT (AgentId);
QUIT;
