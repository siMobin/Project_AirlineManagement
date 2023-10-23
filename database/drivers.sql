use PrivateJet


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
    date DATE NOT NULL,--from bookings
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
    id int not null,
    did int not null,
    role varchar(255),
    checkin_date date not null,
    checkout_date date not null,
    room_no varchar(20),
    hotel varchar(255),
    PRIMARY KEY (id,did)
);

-- driver login info
create table driver(
    DID INT PRIMARY KEY NOT NULL,--random 5/6/8 digit from driver_info
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    password char(60) not null--set
);
