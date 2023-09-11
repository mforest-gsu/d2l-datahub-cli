DROP TABLE D2L_QUESTION_LIBRARY_LOAD;
CREATE TABLE D2L_QUESTION_LIBRARY_LOAD (
  QuestionId NUMBER(20) NOT NULL,
  QuestionVersionId NUMBER(20) NOT NULL,
  IsAutoGraded NUMBER(1) DEFAULT NULL,
  TemplateTypeId NUMBER(10) DEFAULT NULL,
  QuestionType VARCHAR2(35 CHAR) DEFAULT NULL,
  Name NVARCHAR2(320) DEFAULT NULL,
  Question NVARCHAR2(1250) DEFAULT NULL,
  D2LComment NVARCHAR2(1250) DEFAULT NULL,
  AnswerKey NVARCHAR2(1250) DEFAULT NULL,
  CreationDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  Version NUMBER(20) DEFAULT NULL,
  AllowsAttachments NUMBER(1) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_QUESTION_LIBRARY_LOAD_PK ON D2L_QUESTION_LIBRARY_LOAD (QuestionId,QuestionVersionId);
QUIT;
