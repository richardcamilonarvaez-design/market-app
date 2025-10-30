CREATE TABLE users(
	id BIGSERIAL PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	mobile_number VARCHAR(20) NOT NULL,
	id_number VARCHAR(15) NUll UNIQUE,
	address TEXT NULL,
	birthday DATE NULL,
	email VARCHAR(200) NOT NULL UNIQUE,
	password TEXT NOT NULL,
	status BOOLEAN NOT NULL DEFAULT TRUE,
	id_city_birthday VARCHAR(15) NUll UNIQUE, --
	id_city_document VARCHAR(15) NUll UNIQUE, --
	created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
	updated_at TIMESTAMPTZ NOT NULL DEFAULT now(),
	delated_at TIMESTAMPTZ NULL
);
INSERT INTO users(firstname, lastname, mobile_number, email, password)
VALUES ('Joan C', 'Ayala', '3005658989', 'joan@mail', '1234');

CREATE TABLE country(
	id BIGSERIAL PRIMARY KEY,
	name VARCHAR(30) NOT NULL,
	abbrev VARCHAR(20),
	code VARCHAR(15) NUll UNIQUE,
	status BOOLEAN NOT NULL DEFAULT TRUE,
	created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
	updated_at TIMESTAMPTZ NOT NULL DEFAULT now(),
	delated_at TIMESTAMPTZ NULL
);
CREATE TABLE regions (
    id INT PRIMARY KEY,
    name VARCHAR(255),
    abbrev VARCHAR(10),
    code VARCHAR(10) NUll UNIQUE,
    status BOOLEAN NOT NULL DEFAULT TRUE
    id_country INT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
	updated_at TIMESTAMPTZ NOT NULL DEFAULT now(),
	delated_at TIMESTAMPTZ NULL,
    FOREIGN KEY (id_country) REFERENCES countries(id)
);
CREATE TABLE city (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    abbrev VARCHAR(20),
    code VARCHAR(15) NULL UNIQUE,
    status BOOLEAN NOT NULL DEFAULT TRUE,
    id_region BIGINT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    deleted_at TIMESTAMPTZ NULL,
    FOREIGN KEY (id_region) REFERENCES region(id)
);

