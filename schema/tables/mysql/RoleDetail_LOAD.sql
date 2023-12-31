DROP TABLE IF EXISTS `RoleDetail_LOAD`;

CREATE TABLE `RoleDetail_LOAD` (
  `RoleId` INT NOT NULL,
  `OrgId` INT DEFAULT NULL,
  `RoleName` VARCHAR(60) DEFAULT NULL,
  `Description` VARCHAR(200) DEFAULT NULL,
  `IsCascading` TINYINT DEFAULT NULL,
  `InClassList` TINYINT DEFAULT NULL,
  `ClassListRoleName` VARCHAR(60) DEFAULT NULL,
  `ClassListShowGroups` TINYINT DEFAULT NULL,
  `ClassListShowSections` TINYINT DEFAULT NULL,
  `ClassListDisplayRole` TINYINT DEFAULT NULL,
  `AccessInactiveCO` TINYINT DEFAULT NULL,
  `HasSpecialAccess` TINYINT DEFAULT NULL,
  `AddToCourseOfferingGroups` TINYINT DEFAULT NULL,
  `CanBeAutoEnrolledIntoGroups` TINYINT DEFAULT NULL,
  `AddToCourseOfferingSections` TINYINT DEFAULT NULL,
  `CanBeAutoEnrolledIntoSections` TINYINT DEFAULT NULL,
  `ClassListDisplayRoleCategory` TINYINT DEFAULT NULL,
  `ClassListRoleCategory` VARCHAR(50) DEFAULT NULL,
  `ClassListRoleCategoryOrder` INT DEFAULT NULL,
  `AccessPastCourses` TINYINT DEFAULT NULL,
  `AccessFutureCourses` TINYINT DEFAULT NULL,
  `SortOrder` INT DEFAULT NULL,
  `ShowInContent` TINYINT DEFAULT NULL,
  `ShowInDiscussionAssess` TINYINT DEFAULT NULL,
  `ShowInDiscussionStats` TINYINT DEFAULT NULL,
  `ShowInGrades` TINYINT DEFAULT NULL,
  `ShowInAttendance` TINYINT DEFAULT NULL,
  `AllowSelfEnrollInGroups` TINYINT DEFAULT NULL,
  `ShowInRegistration` TINYINT DEFAULT NULL,
  `ShowInUserProgress` TINYINT DEFAULT NULL,
  `RoleAlias` VARCHAR(60) DEFAULT NULL,
  `Version` BIGINT DEFAULT NULL,
  `RoleCode` VARCHAR(50) DEFAULT NULL,
  UNIQUE KEY (`RoleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
