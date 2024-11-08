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
 Valor_Dados FLOAT,  
 Data_Dados DATE,
 FOREIGN KEY (ID_Sensor) REFERENCES Sensores(ID_Sensor) 
);