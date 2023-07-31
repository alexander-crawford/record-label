-- CREATE
drop database record_label;
create database record_label;
use record_label;
create table account(
  _id int unsigned primary key auto_increment,
  username varchar(255) index not null unique,
  password varchar(255) not null,
  type tinyint not null
);
insert into account (username,password,type)values ("test_user_admin","test_password_admin",0);
insert into account (username,password,type)values ("test_user_artist","test_password_artist",1);
insert into account (username,password,type)values ("test_user_customer","test_password_customer",2);
-- TODO: album.title is not indexed, could result in slower queries later on
create table album(
  _id int unsigned primary key auto_increment,
  title varchar(255) not null,
  art varchar(255) unique,
  approval boolean default false,
  price decimal(5,2) unsigned default 0.00
);
insert into album (title) values ("test_album_1");
insert into album (title) values ("test_album_2");
create table artist_album(
  artist_id int unsigned,
  foreign key (artist_id) references account(_id),
  album_id int unsigned,
  foreign key (album_id) references album(_id),
  primary key (artist_id,album_id)
);
insert into artist_album (artist_id,album_id) values (2,1);
insert into artist_album (artist_id,album_id) values (2,2);
-- TODO: track.title not indexed
create table track(
  _id int unsigned primary key auto_increment,
  title varchar(255) index not null unique,
  number tinyint unsigned not null unique,
  file varchar(255) not null unique,
  album_id int unsigned,
  foreign key (album_id) references album(_id)
);
insert into track (title,number,file,album_id) values ("test_track",1,"/folder/folder/file.mp3",1);
create table purchase(
  customer_id int unsigned,
  foreign key (customer_id) references account(_id),
  payment_id int unsigned default 0,
  album_id int unsigned,
  foreign key (album_id) references album(_id),
  date datetime default current_timestamp,
  price decimal(5,2) unsigned not null,
  card_holder_name varchar(255) not null,
  card_number varchar(16) not null,
  card_expiration_date date not null,
  card_cvv varchar(3) not null,
  primary key (customer_id,album_id)
);
insert into purchase (customer_id,payment_id,album_id,card_holder_name,card_number,card_expiration_date,card_cvv) values (3,0,1,"test_cardholder_name","0000000000000000","100/01/01","123");
-- READ
select album.& from account inner join artist_album on account._id = artist_album.artist_id inner join album on artist_album.album_id = album._id where account.username = ?;
-- UPDATE
-- DELETE
