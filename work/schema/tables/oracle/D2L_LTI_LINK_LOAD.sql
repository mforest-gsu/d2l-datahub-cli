DROP TABLE D2L_LTI_LINK_LOAD;
CREATE TABLE D2L_LTI_LINK_LOAD (
  LtiLinkId NUMBER(20) NOT NULL,
  OrgUnitId NUMBER(10) NOT NULL,
  Title NVARCHAR2(200) NOT NULL,
  LinkType NUMBER(10) NOT NULL,
  LTIVersion VARCHAR2(12) NOT NULL,
  Url NVARCHAR2(1000) DEFAULT NULL,
  Description NVARCHAR2(1000) DEFAULT NULL,
  IsVisible NUMBER(1) NOT NULL,
  SendTCInfo NUMBER(1) NOT NULL,
  SendContextInfo NUMBER(1) NOT NULL,
  SendCourseInfo NUMBER(1) NOT NULL,
  SendOrgUnitInfo NUMBER(1) DEFAULT NULL,
  SendUserId NUMBER(1) NOT NULL,
  SendUserName NUMBER(1) NOT NULL,
  SendUserEmail NUMBER(1) NOT NULL,
  SendLinkTitle NUMBER(1) NOT NULL,
  SendLinkDescription NUMBER(1) NOT NULL,
  SendD2LUserName NUMBER(1) NOT NULL,
  SendD2LOrgDefinedId NUMBER(1) NOT NULL,
  SendD2LOrgRoleId NUMBER(1) NOT NULL,
  SendBrightspaceUserId NUMBER(1) DEFAULT NULL,
  Anonymous NUMBER(1) DEFAULT NULL,
  Shared NUMBER(1) DEFAULT NULL,
  UseToolProviderSecuritySettings NUMBER(1) NOT NULL,
  LastModifiedDate DATE DEFAULT NULL,
  OuAvailabilitySetId NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_LTI_LINK_LOAD_PK ON D2L_LTI_LINK_LOAD (LtiLinkId);
QUIT;
