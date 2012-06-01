DROP TABLE IF EXISTS viewers;

CREATE TABLE viewers ( 
	viewerId VARCHAR(128),
	boxId INT,	
	isViewed BOOL,
	PRIMARY KEY (viewerId) );