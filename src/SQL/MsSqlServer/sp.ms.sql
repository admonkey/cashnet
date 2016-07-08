IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = 'P' AND name = 'cashnet_create_transaction')
   exec('CREATE PROCEDURE [dbo].[cashnet_create_transaction] AS BEGIN SET NOCOUNT ON; END')
GO
ALTER PROCEDURE [dbo].[cashnet_create_transaction]
	@store NVARCHAR(255),
	@CARDNAME_G NVARCHAR(255) = NULL,
	@ADDR_G NVARCHAR(255) = NULL,
	@CITY_G NVARCHAR(255) = NULL,
	@STATE_G NVARCHAR(255) = NULL,
	@ZIP_G NVARCHAR(255) = NULL,
	@EMAIL_G NVARCHAR(255) = NULL
AS
BEGIN
	SET NOCOUNT ON;
	INSERT INTO "cashnet_transactions" ("store") VALUES (@store);
	DECLARE @tid INT;
	SET @tid = SCOPE_IDENTITY();
	INSERT INTO "cashnet_userdata" (
		"tid",
		"from_cashnet",
		"CARDNAME_G",
		"ADDR_G",
		"CITY_G",
		"STATE_G",
		"ZIP_G",
		"EMAIL_G"
	) VALUES (
		@tid,
		0,
		@CARDNAME_G,
		@ADDR_G,
		@CITY_G,
		@STATE_G,
		@ZIP_G,
		@EMAIL_G
	);
	SELECT @tid AS 'UID';
END
GO

IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = 'P' AND name = 'cashnet_create_lineitem')
   exec('CREATE PROCEDURE [dbo].[cashnet_create_lineitem] AS BEGIN SET NOCOUNT ON; END')
GO
ALTER PROCEDURE [dbo].[cashnet_create_lineitem]
	@tid INT,
	@from_cashnet BIT,
	@itemcode NVARCHAR(255),
	@amount DECIMAL(15,2),
	@qty INT = 1,
	@gl NVARCHAR(255) = NULL
AS
BEGIN
	SET NOCOUNT ON;
	INSERT INTO "cashnet_lineitems" (
		"tid",
		"from_cashnet",
		"itemcode",
		"amount",
		"qty",
		"gl"
	) VALUES (
		@tid,
		@from_cashnet,
		@itemcode,
		@amount,
		@qty,
		@gl
	);
END
