DROP DATABASE if exists ECO;

CREATE DATABASE Eco;

USE Eco;

CREATE TABLE Usuário 
( 
 ID_Usuário INT AUTO_INCREMENT PRIMARY KEY,  
 Nome_Usuário varchar(45),  
 Telefone_Usuário varchar(12),  
 Email_Usuário varchar(100)  
); 

CREATE TABLE Administrador 
( 
 ID_Adm INT PRIMARY KEY,  
 Nome_Adm varchar(45),  
 Função_Adm varchar(100),  
 Email_Adm varchar(100)
); 

CREATE TABLE Sensores 
( 
 ID_Sensor INT PRIMARY KEY,  
 Nome_Sensor varchar(45),  
 Tipo_Sensor varchar(45),  
 Ativo_Desativado boolean 
); 

CREATE TABLE Dados
( 
 Cod_Dados INT PRIMARY KEY
); 

CREATE TABLE Temperatura
( 
 ID_Temp INT PRIMARY KEY,  
 Cod_Dados INT,  
 Valor_Temp FLOAT,  
 Data_Temp DATE,
 FOREIGN KEY (Cod_Dados) REFERENCES Dados(Cod_Dados)
); 

CREATE TABLE Umidade
( 
 ID_Umi INT PRIMARY KEY,  
 Cod_Dados INT,  
 Valor_Umi INT,  
 Data_Umi DATE,
 FOREIGN KEY (Cod_Dados) REFERENCES Dados(Cod_Dados)
); 

CREATE TABLE Velocidade_Ar
( 
 ID_Ar INT PRIMARY KEY,  
 Cod_Dados INT,  
 Valor_Velo FLOAT,  
 Data_Velo DATE,
 FOREIGN KEY (Cod_Dados) REFERENCES Dados(Cod_Dados)
);

CREATE TABLE Pesquisa 
( 
 Cod_Dados INT,  
 ID_Usuário INT,  
 PRIMARY KEY (Cod_Dados, ID_Usuário),  
 FOREIGN KEY (Cod_Dados) REFERENCES Dados (Cod_Dados),  
 FOREIGN KEY (ID_Usuário) REFERENCES Usuário (ID_Usuário)  
); 

CREATE TABLE Envio 
( 
 ID_Sensor INT,  
 Cod_Dados INT,  
 PRIMARY KEY (ID_Sensor, Cod_Dados),  
 FOREIGN KEY (ID_Sensor) REFERENCES Sensores (ID_Sensor),  
 FOREIGN KEY (Cod_Dados) REFERENCES Dados (Cod_Dados)  
); 

CREATE TABLE Análise 
( 
 Cod_Dados INT,  
 ID_Adm INT,  
 PRIMARY KEY (Cod_Dados, ID_Adm),  
 FOREIGN KEY (Cod_Dados) REFERENCES Dados (Cod_Dados),  
 FOREIGN KEY (ID_Adm) REFERENCES Administrador (ID_Adm)  
); 

CREATE TABLE Manutenção 
( 
 Descrição_Relatório VARCHAR(255),  
 Data_Manutenção_Sensor DATE,  
 ID_Adm INT,  
 ID_Sensor INT,  
 PRIMARY KEY (ID_Adm, ID_Sensor),  
 FOREIGN KEY (ID_Adm) REFERENCES Administrador (ID_Adm),  
 FOREIGN KEY (ID_Sensor) REFERENCES Sensores (ID_Sensor)  
);
