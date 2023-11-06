DROP TABLE D2L_QUIZ_ATTEMPT;
CREATE TABLE D2L_QUIZ_ATTEMPT (
  AttemptId NUMBER(20) NOT NULL,
  QuizId NUMBER(20) DEFAULT NULL,
  UserId NUMBER(10) DEFAULT NULL,
  OrgUnitId NUMBER(10) DEFAULT NULL,
  AttemptNumber NUMBER(10) DEFAULT NULL,
  TimeStarted TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  TimeCompleted TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  Score DECIMAL(19, 9) DEFAULT NULL,
  IsGraded NUMBER(1) DEFAULT NULL,
  OldAttemptNumber NUMBER(10) DEFAULT NULL,
  IsDeleted NUMBER(1) DEFAULT NULL,
  PossibleScore DECIMAL(19, 9) DEFAULT NULL,
  IsRetakeIncorrectOnly NUMBER(1) DEFAULT NULL,
  DueDate TIMESTAMP WITH LOCAL TIME ZONE DEFAULT NULL,
  TimeLimit NUMBER(10) DEFAULT NULL,
  TimeLimitEnforced NUMBER(1) DEFAULT NULL,
  GracePeriod NUMBER(10) DEFAULT NULL,
  GracePeriodExceededBehaviour NVARCHAR2(256) DEFAULT NULL,
  ExtendedDeadline NUMBER(10) DEFAULT NULL
);
CREATE UNIQUE INDEX D2L_QUIZ_ATTEMPT_PK ON D2L_QUIZ_ATTEMPT (AttemptId);
QUIT;
