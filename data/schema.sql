drop table if exists `user`;
create table `user` (
  id int unsigned not null auto_increment,
  username varchar(64) not null,
  first_name varchar(64) not null,
  last_name varchar(64) not null,
  email varchar(128) not null,
  password varchar(255) not null,
  is_staff boolean not null,
  is_active boolean not null,
  date_joined datetime not null default current_timestamp,
  primary key (id)
);

insert into `user` (username, first_name, last_name, email, password, is_staff, is_active, date_joined)
values (
        'rbinz',
        'Ramon',
        'Binz',
        'ramon.binz@bbcag.ch',
        sha2('ramon', 256),
        0,
        1,
        current_timestamp()
);

insert into `user` (username, first_name, last_name, email, password, is_staff, is_active, date_joined)
values (
        'swicky',
        'Samuel',
        'Wicky',
        'samuel.wicky@bbcag.ch',
        sha2('samuel', 256),
        0,
        1,
        current_timestamp()
);

drop table if exists `post`;
create table `post` (
    id int unsigned not null auto_increment,
    user_id integer,
    title varchar(255),
    text text,
    created_at datetime not null default current_timestamp,
    is_approved boolean,
    foreign key (user_id) references user(id)
);

insert into `post` (user_id, text, created_at, is_approved)
values (
    1,
    ''
);


