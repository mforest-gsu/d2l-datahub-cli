DROP TABLE D2L_QUESTION_RELATIONSHIP_LOAD;
CREATE TABLE D2L_QUESTION_RELATIONSHIP_LOAD (
  CollectionId NUMBER(20) NOT NULL,
  QuestionId NUMBER(20) DEFAULT NULL,
  QuestionVersionId NUMBER(20) DEFAULT NULL,
  D2LOrder NUMBER(20) NOT NULL,
  SectionId NUMBER(20) DEFAULT NULL,
  IsQuestionPool NUMBER(1) NOT NULL,
  CreationDate DATE NOT NULL,
  CreatedBy NUMBER(20) DEFAULT NULL,
  LastModified DATE NOT NULL,
  LastModifiedBy NUMBER(20) DEFAULT NULL,
  Points NUMBER(19, 9) DEFAULT NULL,
  Difficulty NUMBER(10) DEFAULT NULL,
  IsBonus NUMBER(1) DEFAULT NULL,
  IsMandatory NUMBER(1) DEFAULT NULL,
  IsDeleted NUMBER(1) NOT NULL,
  Version NUMBER(20) DEFAULT NULL,
  ObjectId NUMBER(20) NOT NULL
);
QUIT;
