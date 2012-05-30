DROP TABLE IF EXISTS boxes;

CREATE TABLE boxes ( 
	id MEDIUMINT NOT NULL AUTO_INCREMENT, 
	deviceId TEXT NULL, 
	messageTitle TEXT NULL, 
	messageBody TEXT NULL, 
	riddleQuestion TEXT NULL, 
	riddleAnswer TEXT NULL, 
	fileName TEXT NULL, 
	unlockDate DATETIME NOT NULL, 
	PRIMARY KEY (id) );
 
CREATE INDEX id ON boxes (id);