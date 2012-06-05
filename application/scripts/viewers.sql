DROP TABLE IF EXISTS viewers;

CREATE TABLE viewers ( 
	viewerId VARCHAR(38) NOT NULL,
	boxId VARCHAR(38) NOT NULL,	
	isViewed BOOL,
	PRIMARY KEY (viewerId) );