CREATE TABLE users(
	id BIGSERIAL PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lasstname VARCHAR(30) NOT NULL,
	mobile_number VARCHAR(20) NOT NULL,
	id_number VARCHAR(15) NOT UNIQUE,
	address TEXT NULL,
	birthday DATE NULL,
	email VARCHAR(200) NOT NULL UNIQUE,
	password TEXT NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE,
	created_at TIMESTAMPZ NOT NULL DEFAULT now(),
	updated_at TIMESTAMPZ NOT NULL DEFAULT now(),
	delated_at TIMESTAMPZ NOT NULL
);
INSERT INTO users(firstname, last name, mobile_number, password)
VALUES ('Joan C', 'Ayala', '3005658989', 'joan@mail', '1234');