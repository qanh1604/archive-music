ALTER TABLE users
ADD identity_card varchar(255);

ALTER TABLE users
ADD business_license varchar(255);

ALTER TABLE users
ADD started_at TIMESTAMP

ALTER TABLE users
ADD finished_at TIMESTAMP

ALTER TABLE sellers
ADD discount DOUBLE(20, 2)

ALTER TABLE seller_packages
ADD discount_type varchar(10);