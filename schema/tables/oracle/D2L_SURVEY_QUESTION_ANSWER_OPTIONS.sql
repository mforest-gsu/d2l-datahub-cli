DROP TABLE D2L_SURVEY_QUESTION_ANSWER_OPTIONS;
CREATE TABLE D2L_SURVEY_QUESTION_ANSWER_OPTIONS (
  AnswerId NUMBER(20) NOT NULL,
  AnswerText NVARCHAR2(2000) DEFAULT NULL,
  Weight DECIMAL(19, 9) DEFAULT NULL,
  QuestionId NUMBER(20) NOT NULL,
  QuestionVersionId NUMBER(20) NOT NULL,
  SurveyObjectId NUMBER(20) NOT NULL,
  AnswerOptionId NUMBER(20) NOT NULL
);
CREATE UNIQUE INDEX D2L_SURVEY_QUESTION_ANSWER_OPTIONS_PK ON D2L_SURVEY_QUESTION_ANSWER_OPTIONS (AnswerId,QuestionId,QuestionVersionId,SurveyObjectId,AnswerOptionId);
QUIT;
