CREATE DATABASE IF NOT EXISTS codeigniter_crud;

USE codeigniter_crud;

DROP TABLE IF EXISTS aircrafts;

CREATE TABLE aircrafts (
	id int NOT NULL AUTO_INCREMENT,
    model VARCHAR(50) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    numberOfEngines INT NOT NULL,
    createdAt DATETIME DEFAULT current_timestamp,
    updatedAt DATETIME DEFAULT current_timestamp,
    PRIMARY KEY (id)
);

INSERT INTO aircrafts (model, brand, type, numberOfEngines) VALUES
('A320', 'Airbus', 'airplane', 2),
('747', 'Boeing', 'airplane', 4),
('AH-64 Apache', 'Boeing', 'helicopter', 1);