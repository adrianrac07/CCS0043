CREATE DATABASE db_userprivileges;
USE db_userprivileges;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    middlename VARCHAR(50),
    contactno VARCHAR(20),
    email VARCHAR(100),
    birthday DATE,
    username VARCHAR(50),
    password VARCHAR(50),
    accesslevel VARCHAR(20),
    status VARCHAR(20),
    image VARCHAR(255)
);

INSERT INTO users (firstname, lastname, middlename, contactno, email, birthday, username, password, accesslevel, status, image)
VALUES
('Juan', 'Dela Cruz', 'Santos', '09171234567', 'juan@example.com', '1995-05-12', 'admin', 'admin123', 'admin', 'active', 'default.png'),
('Maria', 'Santos', 'Reyes', '09181234567', 'maria@example.com', '1998-03-21', 'maria', 'maria123', 'user', 'active', 'default.png'),
('Pedro', 'Garcia', 'Lopez', '09191234567', 'pedro@example.com', '1997-07-09', 'pedro', 'pedro123', 'user', 'active', 'default.png'),
('Ana', 'Ramos', 'Torres', '09201234567', 'ana@example.com', '1999-11-30', 'ana', 'ana123', 'user', 'disable', 'default.png'),
('Jose', 'Fernandez', 'Cruz', '09211234567', 'jose@example.com', '1996-01-15', 'jose', 'jose123', 'user', 'active', 'default.png');
