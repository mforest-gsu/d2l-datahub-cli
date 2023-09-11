DROP TABLE D2L_PORTFOLIO_CATEGORY;
CREATE TABLE D2L_PORTFOLIO_CATEGORY (
  CategoryId VARCHAR2(36) NOT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  Name NVARCHAR2(320) DEFAULT NULL,
  IsRetired NUMBER(1) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  LastModified TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  LastModifiedBy NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_PORTFOLIO_CATEGORY_PK ON D2L_PORTFOLIO_CATEGORY (CategoryId);
QUIT;
