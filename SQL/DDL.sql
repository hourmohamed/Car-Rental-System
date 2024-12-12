CREATE DATABASE car_rental_system;
USE car_rental_system;

CREATE TABLE car(
    plate_number INT PRIMARY KEY,
    car_id INT PRIMARY KEY,
    color varchar(50),
    model varchar(50),
    `year` INT,
    car_status varchar(50)
    );
    
    
CREATE TABLE customer(
    customer_id INT PRIMARY KEY,
    license_number INT PRIMARY KEY,
    customer_name varchar(50),
    phone_number INT
    );
    
    DDL.sql