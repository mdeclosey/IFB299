CREATE TABLE TENANT(
    tenantID INT NOT NULL AUTO_INCREMENT,
    fName varchar(40) NOT NULL,
    lname varchar(40) NOT NULL,
    email varchar(60) NOT NULL,
    phone INT NOT NULL,
    propertyRented INT NOT NULL,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    dayOfPayments INT NOT NULL,
    paymentFrequency varchar(40) NOT NULL,
    isStaff BOOLEAN NOT NULL,
);

INSERT INTO tenant (fname, lname, email, phone, propertyRented, startDate, endDate, dayOfPayments,
    paymentFrequency, isStaff) VALUES ("David", "Jones", davidJones@example.com, 55444444, 14, 
    01/02/2017, 01/01/2018, 1, "Fortnightly", False);
