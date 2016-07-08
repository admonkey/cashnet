DROP TABLE IF EXISTS `cashnet_lineitems`;
DROP TABLE IF EXISTS `cashnet_transactions`;

CREATE TABLE IF NOT EXISTS `cashnet_transactions` (
  `uid` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `result` SMALLINT,
  `respmessage` VARCHAR(255),
  `itemcnt` SMALLINT,
  `batchno` SMALLINT,
  `tx` SMALLINT,
  `cctype` VARCHAR(255),
  `effdate` DATE NULL,
  `failedtx` SMALLINT,
  `ccerrorcode` SMALLINT,
  `CARDNAME_G` VARCHAR(255),
  `ADDR_G` VARCHAR(255),
  `CITY_G` VARCHAR(255),
  `STATE_G` VARCHAR(255),
  `ZIP_G` VARCHAR(255),
  `EMAIL_G` VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `cashnet_lineitems` (
  `lid` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `tid` INT NOT NULL,
  `itemcode` VARCHAR(255),
  `amount` DECIMAL(15,2),
  `qty` SMALLINT,
  `gl` VARCHAR(255),
  CONSTRAINT `fk_cashnet_lineitems` FOREIGN KEY (`tid`)
  REFERENCES `cashnet_transactions`(`uid`)
);
