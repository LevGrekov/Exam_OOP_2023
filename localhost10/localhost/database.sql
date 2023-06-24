/*Этот код нужно внести в SQL В phpMyAdmin*/
 
CREATE DATABASE MyDataBaseForExam;

CREATE TABLE IntegralGraph (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data MEDIUMBLOB,
    dateOfCreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);