DROP TABLE IF EXISTS boxes;

CREATE TABLE boxes ( 
	boxId VARCHAR(38) NOT NULL, 
	deviceId TEXT NULL, 
	messageTitle TEXT NULL, 
	messageBody TEXT NULL, 
	riddleQuestion TEXT NULL, 
	riddleAnswer TEXT NULL, 
	fileName TEXT NULL, 
	unlockDate DATETIME NOT NULL, 
	PRIMARY KEY (boxId) );
 
'CREATE INDEX id ON boxes (id);