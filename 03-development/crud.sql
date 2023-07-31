-- CREATE
-- account
insert into account (username,password,type) values (?,?,?);
-- album
insert into album (title,art,approval,price) values (?,?,?,?);
insert into artist_album (artist_id,album_id) values (?,?);
-- purchase
insert into purchase (customer_id,payment_id,album_id,card_holder_name,card_number,card_expiration_date,card_cvv) values (?,?,?,?,?,?,?);
-- track
insert into track (title,number,file,album_id) values (?,?,?,?);
-- READ
-- account (single)
select * from account where username = ?;
-- album (single)
select album.* from artist_album inner join album on artist_album.album_id = album._id where artist_album.artist_id = (select _id from account where username = ? and type = 1) and album.title = ?;
-- album (multiple)
select album.* from artist_album inner join album on artist_album.album_id = album._id where artist_album.artist_id = (select _id from account where username = ? and type = 1);
-- purchase (single)
select * from purchase where customer_id = (select _id from account where type = 2 and username = ?) and album_id = ?;
-- purchase (multiple)
select album._id as album_id,album.title as album_title,album.art as album_art,album.approval as album_approval,album.price as album_price,purchase.payment_id as purchase_payment_id,purchase.date as purchase_date,purchase.price as purchase_price,purchase.card_holder_name as purchase_card_holder_name,purchase.card_number as purchase_card_number,purchase.card_expiration_date as purchase_card_expiration_date,purchase.card_cvv as purchase_card_cvv from purchase inner join account on purchase.customer_id = account._id inner join album on purchase.album_id = album._id where customer_id = (select _id from account where type = 2 and username = ?);
-- track (single)
select * from track where album_id = ? and title = ?;
-- track (multiple)
select * from track where album_id = ?;
-- UPDATE
-- account
update account set username = ?,password = ?,type = ? where username = ?;
-- album
update album set title = ?,art = ?,approval = ?,price = ? where _id = ?;
-- purchase
-- TODO: no update allowed at present for a completed purchase
-- track
update track set title = ?,number = ?,file = ?,album_id = ? where _id = ?;
-- DELETE
-- account
-- album
-- purchase
-- track
