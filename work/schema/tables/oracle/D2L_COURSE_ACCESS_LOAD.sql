DROP TABLE D2L_COURSE_ACCESS_LOAD;
CREATE TABLE D2L_COURSE_ACCESS_LOAD (
  OrgUnitId NUMBER(10) NOT NULL,
  UserId NUMBER(10) NOT NULL,
  DayAccessed TIMESTAMP WITH LOCAL TIME ZONE NOT NULL
);
CREATE UNIQUE INDEX D2L_COURSE_ACCESS_LOAD_PK ON D2L_COURSE_ACCESS_LOAD (OrgUnitId,UserId,DayAccessed);
QUIT;
