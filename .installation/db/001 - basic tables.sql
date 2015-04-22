# Create table users
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  email VARCHAR(50) NOT NULL
);

# Create new user admin/admin
INSERT INTO users (id, username, password, email) VALUES (null, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@admin.com');

# Create table authentications
CREATE TABLE IF NOT EXISTS authentications (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  user_id INT UNSIGNED NOT NULL, FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  hash VARCHAR(100) NOT NULL UNIQUE,
  expiry_date DATETIME NOT NULL
);

# Create table galleries
CREATE TABLE IF NOT EXISTS galleries (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  name VARCHAR(100) NOT NULL,
  url VARCHAR(100) NOT NULL UNIQUE
);

# Create table files
CREATE TABLE IF NOT EXISTS files (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  filename VARCHAR(100) NOT NULL UNIQUE,
  original_filename VARCHAR(100) NOT NULL
);
/*
# Create table images
CREATE TABLE IF NOT EXISTS images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  file_id INT UNSIGNED NOT NULL, FOREIGN KEY (file_id) REFERENCES files(id) ON DELETE CASCADE,
  title VARCHAR(100) NOT NULL,
  author VARCHAR(100) NOT NULL,
  other_info TEXT
);
*/
# Create table layouts
CREATE TABLE IF NOT EXISTS layouts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  image_id INT UNSIGNED NOT NULL, FOREIGN KEY (image_id) REFERENCES files(id) ON DELETE CASCADE,
  gallery_id INT UNSIGNED NOT NULL, FOREIGN KEY (gallery_id) REFERENCES galleries(id) ON DELETE CASCADE,
  size_x INT UNSIGNED DEFAULT 100,
  size_y INT UNSIGNED DEFAULT 100,
  position_x INT UNSIGNED DEFAULT 0,
  position_y INT UNSIGNED DEFAULT 0
);
