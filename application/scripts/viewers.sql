DROP TABLE IF EXISTS viewers;

CREATE TABLE viewers ( 
	viewerId VARCHAR(38) NOT NULL,
	boxId VARCHAR(38) NOT NULL,	
	isViewed BOOL,
	PRIMARY KEY (viewerId) );
	
'INSERT INTO viewers VALUES ('v03138d6-6b8d-4648-b818-4cc8e4debf8v', '1a3138d6-6b8d-4648-b818-4cc8e4debf8c', 0);