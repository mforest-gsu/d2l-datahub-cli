DROP TABLE D2L_LTI_LINK_LOAD;
CREATE TABLE D2L_LTI_LINK_LOAD (
  LtiLinkId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Title NVARCHAR2(400) DEFAULT NULL,
  LinkType NUMBER(10) DEFAULT NULL,
  LTIVersion VARCHAR2(24 CHAR) DEFAULT NULL,
  Url NVARCHAR2(2000) DEFAULT NULL,
  Description NVARCHAR2(2000) DEFAULT NULL,
  IsVisible NUMBER(1) DEFAULT NULL,
  SendTCInfo NUMBER(1) DEFAULT NULL,
  SendContextInfo NUMBER(1) DEFAULT NULL,
  SendCourseInfo NUMBER(1) DEFAULT NULL,
  SendOrgUnitInfo NUMBER(1) DEFAULT NULL,
  SendUserId NUMBER(1) DEFAULT NULL,
  SendUserName NUMBER(1) DEFAULT NULL,
  SendUserEmail NUMBER(1) DEFAULT NULL,
  SendLinkTitle NUMBER(1) DEFAULT NULL,
  SendLinkDescription NUMBER(1) DEFAULT NULL,
  SendD2LUserName NUMBER(1) DEFAULT NULL,
  SendD2LOrgDefinedId NUMBER(1) DEFAULT NULL,
  SendD2LOrgRoleId NUMBER(1) DEFAULT NULL,
  SendBrightspaceUserId NUMBER(1) DEFAULT NULL,
  Anonymous NUMBER(1) DEFAULT NULL,
  Shared NUMBER(1) DEFAULT NULL,
  UseToolProviderSecuritySettings NUMBER(1) DEFAULT NULL,
  LastModifiedDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  OuAvailabilitySetId NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_LTI_LINK_LOAD_PK ON D2L_LTI_LINK_LOAD (LtiLinkId);
QUIT;
