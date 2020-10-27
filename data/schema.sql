drop table if exists `user`;
create table `user`
(
    id          integer unsigned not null auto_increment,
    username    varchar(64)  not null,
    first_name  varchar(64)  not null,
    last_name   varchar(64)  not null,
    email       varchar(128) not null,
    password    varchar(255) not null,
    is_staff    boolean      not null,
    is_active   boolean      not null,
    date_joined datetime     not null default current_timestamp,
    primary key (id)
);

insert into `user` (username, first_name, last_name, email, password, is_staff, is_active, date_joined)
values ('rbinz',
        'Ramon',
        'Binz',
        'ramon.binz@bbcag.ch',
        sha2('ramon', 256),
        0,
        1,
        current_timestamp());

insert into `user` (username, first_name, last_name, email, password, is_staff, is_active, date_joined)
values ('swicky',
        'Samuel',
        'Wicky',
        'samuel.wicky@bbcag.ch',
        sha2('samuel', 256),
        0,
        1,
        current_timestamp);

drop table if exists `post`;
create table `post`
(
    id          integer unsigned not null auto_increment,
    user_id     integer unsigned not null,
    title       varchar(255),
    text        text,
    created_at  datetime         not null default current_timestamp,
    is_approved boolean,
    primary key (id),
    foreign key (user_id) references user (id)
);

# Post ID 1
insert into post (user_id, title, text, created_at, is_approved)
values (1,
        'Aus was entsteht Luft?',
        'Trockene Luft besteht hauptsächlich aus den zwei Gasen Stickstoff (rund 78,08 Vol. -%) und Sauerstoff (rund 20,95 Vol. ... Daneben gibt es noch die Komponenten Argon (0,93 Vol. -%), Kohlenstoffdioxid (0,04 Vol.',
        current_timestamp,
        1);

# Post ID 2
insert into post (user_id, title, text, created_at, is_approved)
values (2,
        'Aus welchem Material ist eine Holzeisenbahn?',
        'Holzeisenbahnen. Unter dem Begriff Holzeisenbahn werden die Spielzeugeisenbahnen verstanden, bei denen außer den Fahrzeugen auch die Schienen und das Zubehör aus Holz bestehen.',
        current_timestamp,
        1);

# Post ID 3
insert into post (user_id, title, text, created_at, is_approved)
values (1,
        'Existieren wir wirklich?',
        'Bisher ist nicht wirklich von der Hand zu weisen, dass die Welt um uns herum gar nicht real ist. Vielleicht sind wir ja nur Figuren in einem realistisch programmierten Computerspiel? Diese Forscher können dich beruhigen. Glauben sie zumindest.',
        current_timestamp,
        1);

# Post ID 4
insert into post (user_id, title, text, created_at, is_approved)
values (2,
        'Für was sind Gefühle?',
        'Gefühl ist ein psychologischer Terminus, der als Oberbegriff für unterschiedlichste psychische Erfahrungen und Reaktionen dient wie u. a. Angst, Ärger, Komik, Ironie sowie Mitleid, Eifersucht, Furcht, Freude und Liebe die sich (potenziell) beschreiben und damit auch versprachlichen lassen.',
        current_timestamp,
        1);

drop table if exists `comment`;
create table  `comment`
(
    id          integer unsigned not null auto_increment,
    user_id     integer unsigned not null,
    text        text,
    created_at  datetime         not null default current_timestamp,
    is_approved boolean,
    post_id integer unsigned not null,
    primary key (id),
    foreign key (user_id) references user (id),
    foreign key (post_id) references post (id)
);

# Comment ID 1
insert into comment (user_id, text, created_at, is_approved, post_id)
values (2,
        'Wir können nicht mehr als wahrnehmen, das wir wahrnehmen?',
        current_timestamp,
        1,
        1);


# Comment ID 2
insert into comment (user_id, text, created_at, is_approved, post_id)
values (2,
        'Luft besteht aus Luft, was denn sonst?',
        current_timestamp,
        1,
        2);

drop table if exists `reply`;
create table `reply`
(
    id          integer unsigned not null auto_increment,
    user_id     integer unsigned not null,
    text        text,
    created_at  datetime         not null default current_timestamp,
    is_approved boolean,
    comment_id integer unsigned not null,
    primary key (id),
    foreign key (user_id) references user (id),
    foreign key (comment_id) references comment (id)
);