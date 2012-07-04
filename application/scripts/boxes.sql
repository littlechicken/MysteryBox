DROP TABLE IF EXISTS boxes;

CREATE TABLE boxes ( 
	boxId VARCHAR(38) NOT NULL, 
	deviceId TEXT NULL, 
	messageTitle TEXT NULL, 
	messageBody TEXT NULL, 
	riddleQuestion TEXT NULL, 
	riddleAnswer TEXT NULL, 
	fileName TEXT NULL, 
	amazonFileName TEXT NULL, 
	unlockDate DATETIME NOT NULL, 
	PRIMARY KEY (boxId) );
 	
'INSERT INTO boxes VALUES ('1a3138d6-6b8d-4648-b818-4cc8e4debf8c', '421e75005bc2b3a701ae544c1aca9a4ba5ad444f', 'Testint title', 'Test body', 'What color of the sky?', '', 'test.mp3', 'amazonGuid', '2013-01-01 23:59:59');