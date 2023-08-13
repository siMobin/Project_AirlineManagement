use airTest


CREATE TABLE driver_info (
    DID INT PRIMARY KEY NOT NULL,--random 5/6/8 digit
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone INT NOT NULL,
    roll VARCHAR(255) NOT NULL--pilot or hostess
);
-----temp value of driver
INSERT INTO driver_info (DID, name, email, phone, roll)
VALUES
    (12345, 'John Doe', 'johndoe@example.com', 1234567890, 'pilot'),
    (23456, 'Jane Smith', 'janesmith@example.com', 2345678901, 'hostess'),
    (34567, 'Bob Johnson', 'bobjohnson@example.com', 3456789012, 'pilot'),
    (45678, 'Alice Brown', 'alicebrown@example.com', 4567890123, 'hostess'),
    (56789, 'Charlie Davis', 'charliedavis@example.com', 5678901234, 'pilot'),
    (67890, 'Dave Evans', 'daveevans@example.com', 6789012345, 'hostess'),
    (78901, 'Emily Foster', 'emilyfoster@example.com', 7890123456, 'pilot'),
    (89012, 'Frank Green', 'frankgreen@example.com', 8901234567, 'hostess'),
    (90123, 'Grace Hall', 'gracehall@example.com', 9012345678, 'pilot'),
    (123456, 'Henry Ives', 'henryives@example.com', 1234567890, 'hostess');
---------------------------------------------------


CREATE TABLE flight_assign (
    id INT PRIMARY KEY NOT NULL,--from bookings
    pilot INT NOT NULL,--did
    co_pilot INT,--did
    hostess INT NOT NULL,--did
    co_hostess INT,--did
    co_hostess_secondary INT,--did 
    date DATE, NOT NULL,--from bookings
);

-- driver login info
create table driver(
    DID INT PRIMARY KEY NOT NULL,--random 5/6/8 digit from driver_info
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone INT NOT NULL,
    password char(60) not null--set
);

CREATE TABLE driver_schedules (
   id INT PRIMARY KEY NOT NULL,--from bookings
   date DATE, NOT NULL,--from bookings
   [from] NVARCHAR(255),
   [to] NVARCHAR(255),
);