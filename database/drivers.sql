use PrivetJet


CREATE TABLE driver_info (
    DID INT PRIMARY KEY NOT NULL,--random 5/6/8 digit
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    role VARCHAR(255) NOT NULL--pilot or hostess
);

CREATE TABLE flight_assign (
    id INT NOT NULL,--from bookings
    pilot INT NOT NULL,--did
    co_pilot INT,--did
    hostess INT NOT NULL,--did
    co_hostess INT,--did
    co_hostess_secondary INT,--did 
    date DATE, NOT NULL,--from bookings
);

/*
in flight_assign table,
    pilot INT NOT NULL,
    co_pilot INT,
    hostess INT NOT NULL,
    co_hostess INT,
    co_hostess_secondary INT,
    did is the same DID that in driver_info and driver table's "DID".
    and "id" in flight assign table and the "id" of bookings table are same
    
    */

create table hotel_assign(
    id int,
    did int,
    role varchar(255),
    checkin_date date not null,
    checkout_date date not null,
    room_no varchar(20),
    hotel varchar(255)
);

-- driver login info
create table driver(
    DID INT PRIMARY KEY NOT NULL,--random 5/6/8 digit from driver_info
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    password char(60) not null--set
);

CREATE TABLE driver_schedules (
   id INT NOT NULL,--from bookings
   date DATE, NOT NULL,--from bookings
   [from] NVARCHAR(255),
   [to] NVARCHAR(255),
);


-----temp value of driver(only for test!!!)
-- INSERT INTO driver_info (DID, name, email, phone, role)
-- VALUES
--     (12345, 'John Doe', 'johndoe@example.com', 1234567890, 'pilot'),
--     (23456, 'Jane Smith', 'janesmith@example.com', 2345678901, 'hostess'),
--     (34567, 'Bob Johnson', 'bobjohnson@example.com', 3456789012, 'pilot'),
--     (45678, 'Alice Brown', 'alicebrown@example.com', 4567890123, 'hostess'),
--     (56789, 'Charlie Davis', 'charliedavis@example.com', 5678901234, 'pilot'),
--     (67890, 'Dave Evans', 'daveevans@example.com', 6789012345, 'hostess'),
--     (78901, 'Emily Foster', 'emilyfoster@example.com', 7890123456, 'pilot'),
--     (89012, 'Frank Green', 'frankgreen@example.com', 8901234567, 'hostess'),
--     (90123, 'Grace Hall', 'gracehall@example.com', 9012345678, 'pilot'),
--     (123456, 'Henry Ives', 'henryives@example.com', 1234567890, 'hostess');
---------------------------------------------------