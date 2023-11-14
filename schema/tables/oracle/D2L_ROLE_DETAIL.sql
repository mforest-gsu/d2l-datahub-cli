DROP TABLE D2L_ROLE_DETAIL;
CREATE TABLE D2L_ROLE_DETAIL (
  RoleId NUMBER(10) NOT NULL,
  OrgId NUMBER(10) DEFAULT NULL,
  RoleName NVARCHAR2(120) DEFAULT NULL,
  Description NVARCHAR2(400) DEFAULT NULL,
  IsCascading NUMBER(1) DEFAULT NULL,
  InClassList NUMBER(1) DEFAULT NULL,
  ClassListRoleName NVARCHAR2(120) DEFAULT NULL,
  ClassListShowGroups NUMBER(1) DEFAULT NULL,
  ClassListShowSections NUMBER(1) DEFAULT NULL,
  ClassListDisplayRole NUMBER(1) DEFAULT NULL,
  AccessInactiveCO NUMBER(1) DEFAULT NULL,
  HasSpecialAccess NUMBER(1) DEFAULT NULL,
  AddToCourseOfferingGroups NUMBER(1) DEFAULT NULL,
  CanBeAutoEnrolledIntoGroups NUMBER(1) DEFAULT NULL,
  AddToCourseOfferingSections NUMBER(1) DEFAULT NULL,
  CanBeAutoEnrolledIntoSections NUMBER(1) DEFAULT NULL,
  ClassListDisplayRoleCategory NUMBER(1) DEFAULT NULL,
  ClassListRoleCategory NVARCHAR2(100) DEFAULT NULL,
  ClassListRoleCategoryOrder NUMBER(10) DEFAULT NULL,
  AccessPastCourses NUMBER(1) DEFAULT NULL,
  AccessFutureCourses NUMBER(1) DEFAULT NULL,
  SortOrder NUMBER(10) DEFAULT NULL,
  ShowInContent NUMBER(1) DEFAULT NULL,
  ShowInDiscussionAssess NUMBER(1) DEFAULT NULL,
  ShowInDiscussionStats NUMBER(1) DEFAULT NULL,
  ShowInGrades NUMBER(1) DEFAULT NULL,
  ShowInAttendance NUMBER(1) DEFAULT NULL,
  AllowSelfEnrollInGroups NUMBER(1) DEFAULT NULL,
  ShowInRegistration NUMBER(1) DEFAULT NULL,
  ShowInUserProgress NUMBER(1) DEFAULT NULL,
  RoleAlias NVARCHAR2(120) DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL,
  RoleCode NVARCHAR2(100) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_ROLE_DETAIL_PK ON D2L_ROLE_DETAIL (RoleId);
QUIT;