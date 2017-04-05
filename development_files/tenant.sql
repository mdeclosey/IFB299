CREATE TABLE Staff(
    staffID INT NOT NULL AUTO_INCREMENT,
    fName varchar(40) NOT NULL,
    lname varchar(40) NOT NULL,
    email varchar(60) NOT NULL,
    phone INT NOT NULL,
    propertiesOwned NOT NULL,

);

INSERT INTO Staff (fname, lname, email, phone) VALUES (Bob, Jones, bobby@example.com, 55555555);
INSERT INTO Staff (fname, lname, email, phone) VALUES (David, Allen, DavidAllen@example.com, 55555556);
INSERT INTO Staff (fname, lname, email, phone) VALUES (Greg, Davies, Greg@example.com, 55555557);
INSERT INTO Staff (fname, lname, email, phone) VALUES (Bob, Jones, bobby@example.com, 55555558);
INSERT INTO Staff (fname, lname, email, phone) VALUES (Bob, Jones, bobby@example.com, 55555559);
