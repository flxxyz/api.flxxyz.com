create table monitor
(
  id int(10) auto_increment
    primary key,
  ip varchar(15) default '0.0.0.0' not null,
  user_agent text null,
  type varchar(32) null,
  time int(10) not null,
  constraint qq_id_uindex
  unique (id)
)
;

create table qrcode
(
  id int auto_increment
    primary key,
  name varchar(24) not null,
  value varchar(512) null,
  nick varchar(32) null,
  created_at int(10) default '0' null,
  updated_at int(10) default '0' null,
  constraint qrcode_id_uindex
  unique (id),
  constraint qrcode_name_uindex
  unique (name),
  constraint qrcode_nick_uindex
  unique (nick)
)
;