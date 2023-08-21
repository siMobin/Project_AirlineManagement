create database PrivetJet;
use PrivetJet;

-- admin login
-- Create the admin_login table
CREATE TABLE admin_login (
    id INT PRIMARY KEY IDENTITY(1,1),
    username NVARCHAR(255) NOT NULL,
    password NVARCHAR(255) NOT NULL
);

-- Insert a row with the default username and password
INSERT INTO admin_login (username, password)
VALUES ('ADMIN', 'airAdmin');

--//////////////////////////////////////////////////////////////////////////--

--create location table!
CREATE TABLE locations (
    id INT PRIMARY KEY IDENTITY(1,1),
    destination VARCHAR(255) NOT NULL,
    latitude float(53) not null,
    longitude float(53) not null,
    hotel varchar(255)
);

-----temp value of locations(only for test!!!)
-- INSERT INTO locations (destination)
-- VALUES
-- ('USA - Hartsfield�Jackson Atlanta International Airport'),
-- ('China - Beijing Capital International Airport'),
-- ('UAE - Dubai International Airport'),
-- ('USA - Los Angeles International Airport'),
-- ('Japan - Tokyo Haneda Airport'),
-- ('Bangladesh - Hazrat Shahjalal International Airport'),
-- ('UK - London Heathrow Airport'),
-- ('Hong Kong - Hong Kong International Airport'),
-- ('China - Shanghai Pudong International Airport'),
-- ('France - Paris-Charles de Gaulle Airport');
-- add more locations as needed
