DROP DATABASE IF EXISTS ECO;
CREATE DATABASE Eco;
USE Eco;

CREATE TABLE Usuario 
( 
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,  
    Nome_Usuario VARCHAR(45),  
    Telefone_Usuario VARCHAR(12),  
    Email_Usuario VARCHAR(100)  
); 

CREATE TABLE Sensores 
( 
    ID_Sensor INT PRIMARY KEY,  
    Nome_Sensor VARCHAR(45),  
    Tipo_Sensor VARCHAR(45),  
    Ativo_Desativado BOOLEAN 
); 

CREATE TABLE Dados
( 
    ID_Dados INT PRIMARY KEY,  
    ID_Sensor INT, 
    Valor_Dados VARCHAR(45),  
    Data_Dados DATE,
    FOREIGN KEY (ID_Sensor) REFERENCES Sensores(ID_Sensor) 
);

INSERT INTO Sensores (ID_Sensor, Nome_Sensor, Tipo_Sensor, Ativo_Desativado) 
VALUES (0, 'Api', 'Api_Sensor', 1);

UPDATE Sensores 
SET Nome_Sensor = 'Api', Tipo_Sensor = 'Api_Sensor', Ativo_Desativado = 1 
WHERE ID_Sensor = 0;

INSERT INTO `eco`.`sensores` (`ID_Sensor`, `Nome_Sensor`, `Tipo_Sensor`, `Ativo_Desativado`) VALUES ('1', 'Temp', 'Esp_Sensor', '1');
INSERT INTO `eco`.`sensores` (`ID_Sensor`, `Nome_Sensor`, `Tipo_Sensor`, `Ativo_Desativado`) VALUES ('2', 'Umi', 'Esp_Sensor', '1');







