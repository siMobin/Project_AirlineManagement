create database PrivateJet;
use PrivateJet;
use PrivateJet;

-- admin login
-- Create the admin_login table
CREATE TABLE admin_login (
    id INT PRIMARY KEY IDENTITY(1,1),
    admin_name VARCHAR(255) NOT NULL,
    password char(60) NOT NULL
);

-- Insert a row with the default admin_name and password
INSERT INTO admin_login (admin_name, password)
VALUES ('ADMIN', 'airAdmin');

--//////////////////////////////////////////////////////////////////////////--

--create location table!
CREATE TABLE locations (
    id INT PRIMARY KEY IDENTITY(1,1),
    destination VARCHAR(255) NOT NULL,
    latitude float(53) not null,
    longitude float(53) not null,
    hotel varchar(255),
    hotline varchar(255)
);
