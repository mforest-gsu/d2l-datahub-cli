DROP TABLE IF EXISTS `ContentFilePropertyLog`;

CREATE TABLE `ContentFilePropertyLog` (
  `OrgUnitId` INT NOT NULL,
  `ContentObjectId` INT NOT NULL,
  `Action` VARCHAR(10) DEFAULT NULL,
  `FilePath` VARCHAR(9999) DEFAULT NULL,
  `FileName` VARCHAR(512) DEFAULT NULL,
  `FileExtension` VARCHAR(512) DEFAULT NULL,
  `FileSizeBytes` BIGINT DEFAULT NULL,
  `UploadDate` DATETIME DEFAULT NULL,
  `LastModifiedBy` INT DEFAULT NULL,
  `LastModified` DATETIME NOT NULL,
  UNIQUE KEY (`OrgUnitId`, `ContentObjectId`, `LastModified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
