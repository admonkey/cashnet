IF EXISTS (
	SELECT  *
	FROM    sys.objects
	WHERE   name = 'cashnet_userdata'
)
BEGIN
	DROP TABLE "cashnet_userdata";
END

IF EXISTS (
	SELECT  *
	FROM    sys.objects
	WHERE   name = 'cashnet_lineitems'
)
BEGIN
	DROP TABLE "cashnet_lineitems";
END

IF EXISTS (
	SELECT  *
	FROM    sys.objects
	WHERE   name = 'cashnet_transactions'
)
BEGIN
	DROP TABLE "cashnet_transactions";
END

CREATE TABLE "cashnet_transactions" (
  "UID" INT IDENTITY(1,1) NOT NULL,
  "created" DATETIME DEFAULT GETDATE(),
  "store" NVARCHAR(255) NOT NULL,
  "result" INT DEFAULT NULL,
  "respmessage" NVARCHAR(255) DEFAULT NULL,
  "merchant" NVARCHAR(255) DEFAULT NULL,
  "custcode" NVARCHAR(255) DEFAULT NULL,
  "operator" NVARCHAR(255) DEFAULT NULL,
  "station" NVARCHAR(255) DEFAULT NULL,
  "itemcnt" INT DEFAULT NULL,
  "pmtcode" NVARCHAR(255) DEFAULT NULL,
  "pmttype" NVARCHAR(255) DEFAULT NULL,
  "batchno" INT DEFAULT NULL,
  "tx" INT DEFAULT NULL,
  "cctype" NVARCHAR(255) DEFAULT NULL,
  "effdate" date DEFAULT NULL,
  "failedtx" INT DEFAULT NULL,
  "ccerrorcode" INT DEFAULT NULL,
  PRIMARY KEY ("UID")
);

CREATE TABLE "cashnet_lineitems" (
  "lid" INT IDENTITY(1,1) NOT NULL,
  "tid" INT NOT NULL,
  "created" DATETIME DEFAULT GETDATE(),
  "from_cashnet" BIT NOT NULL,
  "itemcode" NVARCHAR(255) NOT NULL,
  "amount" DECIMAL(15,2) NOT NULL,
  "qty" INT DEFAULT 1,
  "gl" NVARCHAR(255) DEFAULT NULL,
  PRIMARY KEY ("lid"),
  CONSTRAINT "fk_cashnet_lineitems" FOREIGN KEY ("tid") REFERENCES "cashnet_transactions" ("UID")
);

CREATE TABLE "cashnet_userdata" (
  "did" INT IDENTITY(1,1) NOT NULL,
  "tid" INT NOT NULL,
  "created" DATETIME DEFAULT GETDATE(),
  "from_cashnet" BIT NOT NULL,
  "CARDNAME_G" NVARCHAR(255) DEFAULT NULL,
  "ADDR_G" NVARCHAR(255) DEFAULT NULL,
  "CITY_G" NVARCHAR(255) DEFAULT NULL,
  "STATE_G" NVARCHAR(255) DEFAULT NULL,
  "ZIP_G" NVARCHAR(255) DEFAULT NULL,
  "EMAIL_G" NVARCHAR(255) DEFAULT NULL,
  PRIMARY KEY ("did"),
  CONSTRAINT "fk_cashnet_userdata" FOREIGN KEY ("tid") REFERENCES "cashnet_transactions" ("UID")
);
