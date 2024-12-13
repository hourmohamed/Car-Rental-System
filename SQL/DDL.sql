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


CREATE TABLE rental(
    rental_id INT PRIMARY KEY,
    customer_id INT,
    rental_date DATE,
    return_date DATE,
    car_id INT


);

CREATE TABLE employee(
    employee_id INT PRIMARY KEY,
    office_number INT,
    `name` varchar(10),
    mgr_id INT

    date


);

-- for foreign key 
ALTER TABLE rental
ADD FOREIGN KEY (car_id) REFERENCES car (car_id),
ADD FOREIGN KEY (customer_id) REFERENCES customer(customer_id);



    DDL.sql