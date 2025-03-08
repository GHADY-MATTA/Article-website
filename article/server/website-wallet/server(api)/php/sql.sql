-- Create the database
CREATE DATABASE usersignupwallet;

-- Use the created database
USE usersignupwallet;

-- Create the usersMail table
CREATE TABLE  usersMail(
    id INT AUTO_INCREMENT PRIMARY KEY,         -- ID for each user, auto-incrementing
    username VARCHAR (255) NOT NULL,             -- Username, not allowing null values
    email VARCHAR (255) UNIQUE NOT NULL,         -- Email, must be unique and not null
    password_hash VARCHAR (255) NOT NULL,        -- Password hash, not allowing null values
    news_letter VARCHAR(255) DEFAULT 'send-news',  -- Newsletter preference, defaulting to 'send-news'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp when the record was created, default to current timestamp
);

-- Example query to check if the table was created successfully
-- SELECT *
-- FROM usersMail;
