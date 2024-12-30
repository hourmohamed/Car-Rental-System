-- USE DATABASE
USE car_rental_system;

-- INSERT SAMPLE DATA INTO car TABLE
INSERT INTO car (plate_number, color, model, year, car_status, price, seating_capacity)
VALUES 
(12345, 'Red', 'Toyota Corolla', 2020, 'Available', 500, 5),
(67890, 'Blue', 'Honda Civic', 2021, 'Unavailable', 600, 5),
(11223, 'Black', 'Ford Escape', 2019, 'Available', 700, 7),
(44556, 'White', 'Chevrolet Malibu', 2022, 'Unavailable', 550, 5);

-- INSERT SAMPLE DATA INTO customer TABLE
INSERT INTO customer (address, email, password, license_number, customer_name, phone_number)
VALUES 
('123 Main St', 'omar@gmail.com', '123', 987654, 'Omar', 5551234),
('456 Elm St', 'jane@gmail.com', '11', 123456, 'Jane', 5555678),
('789 Oak St', 'mike@gmail.com', '12', 112233, 'Mike', 5559876);
('somuha', 'nad@gmail.com', '156', 125786, 'Nad', 5545679),
('smouha', 'tas@gmail.com', '158', 134233, 'Tas', 5570653)
('kafr abdo', 'hour@gmail.com', '19', 120056, 'Hour', 5435678),




-- INSERT SAMPLE DATA INTO rental TABLE
INSERT INTO rental (customer_id, rental_date, return_date, car_id)
VALUES 
(1, '2024-12-01', '2024-12-10', 2),
(2, '2024-12-05', '2024-12-15', 3);
(3, '2024-12-05', '2024-12-15', 4);
(6, '2024-12-05', '2024-12-15', 1);

-- INSERT SAMPLE DATA INTO admin TABLE
INSERT INTO admin (email, password)
VALUES 
('admin1@gmail.com', '123'),
('admin2@gmail.com', '12');

-- INSERT SAMPLE DATA INTO payment TABLE
INSERT INTO payment (rental_id, method, date, amount)
VALUES 
(1, 'Credit Card', '2024-12-01', 6000),
(2, 'Cash', '2024-12-05', 7000);

-- INSERT SAMPLE DATA INTO office TABLE
INSERT INTO office (rental_id, admin_id, car_id, method, date)
VALUES 
(1, 1, 2, 'Visa', '2024-12-01'),
(2, 2, 3, 'Cash', '2024-12-05');