use PrivetJet;

-- user login info
create table users(
U_ID int primary key not null,
username varchar(50) not null,
email varchar(50) not null,
phone varchar(16) not null,
password char(60) not null
);

--create bookings table!
CREATE TABLE bookings (
    id INT primary key not null,
    [from] VARCHAR(255),
    [to] VARCHAR(255),
    date DATE,
    return_date DATE,
    class VARCHAR(255),
    passengers INT,
    email VARCHAR(255),
    phone VARCHAR(255),
    trip VARCHAR(255),
    cost FLOAT,
    confirm int
);
