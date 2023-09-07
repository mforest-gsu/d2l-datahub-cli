DROP TABLE D2L_ORGANIZATIONAL_UNIT_DESCENDANT_LOAD;
CREATE TABLE D2L_ORGANIZATIONAL_UNIT_DESCENDANT_LOAD (
  OrgUnitId NUMBER(10) NOT NULL,
  DescendantOrgUnitId NUMBER(10) NOT NULL
);
CREATE UNIQUE INDEX D2L_ORGANIZATIONAL_UNIT_DESCENDANT_LOAD_PK ON D2L_ORGANIZATIONAL_UNIT_DESCENDANT_LOAD (OrgUnitId,DescendantOrgUnitId);
QUIT;
