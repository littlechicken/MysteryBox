DROP TABLE IF EXISTS boxes;

CREATE TABLE boxes ( 
	boxId INT, 
	deviceId TEXT NULL, 
	messageTitle TEXT NULL, 
	messageBody TEXT NULL, 
	riddleQuestion TEXT NULL, 
	riddleAnswer TEXT NULL, 
	fileName TEXT NULL, 
	unlockDate DATETIME NOT NULL, 
	PRIMARY KEY (boxId) );
 
'CREATE INDEX id ON boxes (id);