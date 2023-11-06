DROP TABLE D2L_VIRTUAL_CLASSROOM_USAGE_LOAD;
CREATE TABLE D2L_VIRTUAL_CLASSROOM_USAGE_LOAD (
  OrgUnitId NUMBER(10) DEFAULT NULL,
  CourseName NVARCHAR2(510) DEFAULT NULL,
  MeetingId NVARCHAR2(72) NOT NULL,
  MeetingName NVARCHAR2(510) DEFAULT NULL,
  CreationUserId NUMBER(10) DEFAULT NULL,
  CreationDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ScheduledDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  ScheduledDuration NUMBER(10) DEFAULT NULL,
  IsPublished NUMBER(1) DEFAULT NULL,
  ExternalLinksEnabled NUMBER(1) DEFAULT NULL,
  WholeClassInvited NUMBER(1) DEFAULT NULL,
  IsCancelled NUMBER(1) DEFAULT NULL,
  StartDateTime TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  EndDateTime TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  IsRecorded NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_VIRTUAL_CLASSROOM_USAGE_LOAD_PK ON D2L_VIRTUAL_CLASSROOM_USAGE_LOAD (MeetingId);
QUIT;
