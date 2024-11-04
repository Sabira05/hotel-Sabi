CREATE TABLE users (
  id INT IDENTITY(1,1) PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Бөлмелер кестесі
CREATE TABLE rooms (
  id INT IDENTITY(1,1) PRIMARY KEY,
  type VARCHAR(50) NOT NULL,
  price DECIMAL(10, 2) NOT NULL
);

-- Брондаулар кестесі
CREATE TABLE bookings (
  id INT IDENTITY(1,1) PRIMARY KEY,
  user_id INT,
  room_id INT,
  checkin_date DATE,
  checkout_date DATE,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (room_id) REFERENCES rooms(id)
);