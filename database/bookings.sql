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
    [from] VARCHAR(255) NOT NULL,
    [to] VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    return_date DATE,
    class VARCHAR(255) NOT NULL,
    passengers INT NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(255),
    trip VARCHAR(255) NOT NULL,
    cost FLOAT NOT NULL,
    confirm int,
    printTime datetime2(3) NOT NULL
);

--Feedback table!
CREATE TABLE feedback (
    id INT PRIMARY KEY IDENTITY(1,1),
	submission_time DATETIME,
    category VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    country VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    ticket_number INT,
    journey_date DATE,
    ticket_file VARBINARY(MAX),
);
