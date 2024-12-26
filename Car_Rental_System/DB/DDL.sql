CREATE DATABASE car_rental_system;
USE car_rental_system;

CREATE TABLE car(
    plate_number INT PRIMARY KEY,
    car_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL ,
    color varchar(50),
    model varchar(50),
    `year` INT,
    car_status varchar(50),
    price INT,

    );
    
    
CREATE TABLE customer(
    customer_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    address varchar(50),
    email varchar(50),
    password varchar(50) NOT NULL,
    license_number INT ,
    customer_name varchar(50),
    phone_number INT NOT NULL
    );


CREATE TABLE rental(
    rental_id INT PRIMARY AUTO_INCREMENT NOT NULL,
    customer_id INT,
    rental_date DATE,
    return_date DATE,
    car_id INT


);

CREATE TABLE admin(
   
    admin_id INT PRIMARY AUTO_INCREMENT NOT NULL,
    email varchar(10) NOT NULL,
    password varchar(50)NOT NULL

);

CREATE TABLE payment(
    rental_id INT,
    payment_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    method varchar(50),
    date DATE,
    amount INT

);


CREATE TABLE office(
    rental_id INT,
    admin_id INT,
    car_id INT,
    method varchar(50),
    date DATE,
    office_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL

);


-- for foreign key 
ALTER TABLE rental
ADD FOREIGN KEY (car_id) REFERENCES car (car_id),
ADD FOREIGN KEY (customer_id) REFERENCES customer(customer_id);

ALTER TABLE office
ADD FOREIGN KEY (car_id) REFERENCES car (car_id),
ADD FOREIGN KEY (rental_id) REFERENCES rental(rental_id),
ADD FOREIGN KEY (admin_id) REFERENCES admin (admin_id);

ALTER TABLE payment
ADD FOREIGN KEY (rental_id) REFERENCES rental (rental_id),


