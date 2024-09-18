CREATE DATABASE todolist;
USE todolist;

CREATE TABLE todos (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
    status ENUM('pendende', 'em progresso', 'completa') DEFAULT 'pendende',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

select * from todos;

insert into todos (name) VALUES ('tarefa 1');


CREATE TABLE users(
	id INT auto_increment primary KEY,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    jwt_token varchar(512) DEFAULT NULL
);
