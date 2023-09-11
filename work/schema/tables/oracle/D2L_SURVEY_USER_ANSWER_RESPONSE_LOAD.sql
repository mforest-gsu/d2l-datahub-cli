DROP TABLE D2L_SURVEY_USER_ANSWER_RESPONSE_LOAD;
CREATE TABLE D2L_SURVEY_USER_ANSWER_RESPONSE_LOAD (
  AttemptId NUMBER(20) NOT NULL,
  AttemptNumber NUMBER(10) DEFAULT NULL,
  QuestionId NUMBER(20) NOT NULL,
  QuestionVersionId NUMBER(20) NOT NULL,
  AnswerId NUMBER(20) NOT NULL,
  SortOrder NUMBER(20) DEFAULT NULL,
  IsCorrect NUMBER(1) DEFAULT NULL,
  UserSelection NUMBER(20) DEFAULT NULL,
  UserAnswer NVARCHAR2(1250) DEFAULT NULL,
  FileSetId NUMBER(20) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_SURVEY_USER_ANSWER_RESPONSE_LOAD_PK ON D2L_SURVEY_USER_ANSWER_RESPONSE_LOAD (AttemptId,QuestionId,QuestionVersionId,AnswerId);
QUIT;
