DROP TABLE IF EXISTS `ContentFilePropertyLog`;

CREATE TABLE `ContentFilePropertyLog` (
  `OrgUnitId` INT NOT NULL,
  `ContentObjectId` INT NOT NULL,
  `Action` VARCHAR(10) NOT NULL,
  `FilePath` TEXT(10000) NOT NULL,
  `FileName` VARCHAR(512) NOT NULL,
  `FileExtension` VARCHAR(512) NOT NULL,
  `FileSizeBytes` BIGINT NOT NULL,
  `UploadDate` DATETIME NOT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `ContentObjectId`, `LastModified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
