create table if not exists news(
	id int not null auto_increment key,
	title char(50) not null,
	author varchar(20) not null,
	`from` varchar(20) not null,
	content text not null,
	dateline int not null default 0
);

create table if not exists user(
	id int(11) not null auto_increment key,
	username varchar(50) not null,
	password varchar(32) not null,
	email varchar(50),
	membership varchar(20) not null,default 'user';
	regtime int not null default 0);