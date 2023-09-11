DROP TABLE D2L_LTI_LINK_SHARED_LOAD;
CREATE TABLE D2L_LTI_LINK_SHARED_LOAD (
  OuAvailabilitySetId NUMBER(20) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  SharingType VARCHAR2(11 CHAR) DEFAULT NULL,
  DescendantTypeId NUMBER(10) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL
);
QUIT;
