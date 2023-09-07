DROP TABLE D2L_COMPETENCY_STRUCTURE_LOAD;
CREATE TABLE D2L_COMPETENCY_STRUCTURE_LOAD (
  ObjectId NUMBER(20) NOT NULL,
  ParentObjectId NUMBER(20) NOT NULL,
  BaseObjectID NUMBER(20) NOT NULL,
  Depth NUMBER(10) NOT NULL,
  EntryTime NUMBER(10) NOT NULL
);
CREATE UNIQUE INDEX D2L_COMPETENCY_STRUCTURE_LOAD_PK ON D2L_COMPETENCY_STRUCTURE_LOAD (ObjectId,ParentObjectId,BaseObjectID,EntryTime);
QUIT;
