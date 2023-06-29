/* list of all users with accounts */
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    name CHAR(50) NULL,
    address VARCHAR(50) NULL,
    email VARCHAR(50) NULL,
    phone CHAR(10) NULL,
    PRIMARY KEY (id)
);
# create user info table?

/* list of all employees with accounts */
CREATE TABLE employees (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    name CHAR(50) NULL,
    address VARCHAR(50) NULL,
    email VARCHAR(50) NULL,
    phone CHAR(10) NULL,
    PRIMARY KEY (id)
);
# create employee info table?

/* list of all items/products in inventory */
CREATE TABLE inventory (
    item_id INT NOT NULL AUTO_INCREMENT,
    item_img VARCHAR(250) NULL,
    item_name CHAR(10) NOT NULL,    # arabica, robusta, liberica, excelsa
    item_code VARCHAR(250) NOT NULL,
    item_type CHAR(15) NOT NULL,    # light, medium, medium-dark, dark
    item_size CHAR(10) NOT NULL,    # 16oz, 32oz
    item_price double(10,2) NOT NULL,     # price of each product variation
    item_qty INT NOT NULL,          # quantity of each product in inventory
    PRIMARY KEY (item_id),
    UNIQUE KEY (item_code)
);
/* fill up inventory with products */
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Arabica', 'CB-AL16', 'Light', '16oz', '19.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Arabica', 'CB-AL32', 'Light', '32oz', '25.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Arabica', 'CB-AM16', 'Medium', '16oz', '19.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Arabica', 'CB-AM32', 'Medium', '32oz', '25.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Arabica', 'CB-AMD16', 'Medium-Dark', '16oz', '19.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Arabica', 'CB-AMD32', 'Medium-Dark', '32oz', '25.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Arabica', 'CB-AD16', 'Dark', '16oz', '19.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Arabica', 'CB-AD32', 'Dark', '32oz', '25.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Excelsa', 'CB-EL16', 'Light', '16oz', '17.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Excelsa', 'CB-EL32', 'Light', '32oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Excelsa', 'CB-EM16', 'Medium', '16oz', '17.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Excelsa', 'CB-EM32', 'Medium', '32oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Excelsa', 'CB-EMD16', 'Medium-Dark', '16oz', '17.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Excelsa', 'CB-EMD32', 'Medium-Dark', '32oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Excelsa', 'CB-ED16', 'Dark', '16oz', '17.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Excelsa', 'CB-ED32', 'Dark', '32oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Liberica', 'CB-LL16', 'Light', '16oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Liberica', 'CB-LL32', 'Light', '32oz', '28.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Liberica', 'CB-LM16', 'Medium', '16oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Liberica', 'CB-LM32', 'Medium', '32oz', '28.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Liberica', 'CB-LMD16', 'Medium-Dark', '16oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Liberica', 'CB-LMD32', 'Medium-Dark', '32oz', '28.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Liberica', 'CB-LD16', 'Dark', '16oz', '22.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Liberica', 'CB-LD32', 'Dark', '32oz', '28.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Robusta', 'CB-RL16', 'Light', '16oz', '24.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Light.jpg', 'Robusta', 'CB-RL32', 'Light', '32oz', '30.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Robusta', 'CB-RM16', 'Medium', '16oz', '24.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium.jpg', 'Robusta', 'CB-RM32', 'Medium', '32oz', '30.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Robusta', 'CB-RMD16', 'Medium-Dark', '16oz', '24.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Medium-Dark.jpg', 'Robusta', 'CB-RMD32', 'Medium-Dark', '32oz', '30.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Robusta', 'CB-RD16', 'Dark', '16oz', '24.99', '100');
INSERT INTO inventory (item_img, item_name, item_code, item_type, item_size, item_price, item_qty)
            VALUES ('../images/Dark.jpg', 'Robusta', 'CB-RD32', 'Dark', '32oz', '30.99', '100');

CREATE TABLE orders (
  order_id INT NOT NULL AUTO_INCREMENT,
  cust_id VARCHAR(50) NULL,
  cust_name CHAR(50) NOT NULL,
  cust_email VARCHAR(50) NOT NULL,
  cust_address VARCHAR(100) NOT NULL,
  cust_billing VARCHAR(100) NOT NULL,
  order_code VARCHAR(250) NOT NULL,
  order_qty INT NOT NULL,
  order_total double(10,2) NOT NULL,
  order_status CHAR(25) DEFAULT 'Processing',
  PRIMARY KEY (order_id)
);
