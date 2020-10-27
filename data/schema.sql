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

INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (1,"Curabitur consequat, lectus sit amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id","2020-08-11 01:55:52",1,1),(1,"sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat","2020-06-05 01:38:50",1,1),(2,"Suspendisse aliquet, sem ut cursus luctus, ipsum leo elementum sem, vitae aliquam eros turpis non","2020-04-01 01:00:13",1,1),(1,"sem. Pellentesque ut ipsum ac mi eleifend egestas. Sed pharetra, felis eget varius ultrices,","2020-02-16 12:22:58",1,1),(2,"tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem","2020-08-17 19:17:17",1,1),(2,"Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida mauris ut","2020-07-19 08:11:14",1,1),(2,"augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor","2019-11-11 04:21:27",1,1),(2,"nec, euismod in, dolor. Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing","2020-02-20 07:17:53",1,1),(2,"ipsum sodales purus, in molestie tortor nibh sit amet orci. Ut sagittis lobortis mauris. Suspendisse aliquet molestie tellus. Aenean","2021-07-21 20:45:01",1,1),(2,"arcu. Morbi sit amet massa. Quisque porttitor eros nec tellus. Nunc","2020-06-15 22:10:00",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (1,"tortor at risus. Nunc ac sem ut dolor dapibus gravida. Aliquam","2021-08-26 02:28:55",1,1),(1,"ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque.","2020-11-15 03:38:11",1,1),(2,"Sed pharetra, felis eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem","2020-05-13 08:50:22",1,1),(1,"Proin mi. Aliquam gravida mauris ut mi. Duis risus odio, auctor vitae, aliquet nec, imperdiet","2021-02-10 21:12:10",1,2),(2,"tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada","2020-07-09 04:57:50",1,2),(1,"eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque","2021-09-26 05:29:54",1,1),(2,"mus. Donec dignissim magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu","2021-08-29 12:05:37",1,1),(1,"semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac","2021-10-23 06:08:45",1,1),(1,"gravida sit amet, dapibus id, blandit at, nisi. Cum sociis","2021-04-05 07:30:37",1,2),(1,"Nunc ac sem ut dolor dapibus gravida. Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum","2021-05-09 05:16:55",1,2);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (2,"Nulla facilisis. Suspendisse commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus","2021-03-16 20:36:11",1,2),(1,"Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula","2020-03-21 14:33:57",1,1),(2,"facilisis eget, ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque","2020-03-22 11:00:35",1,2),(2,"eget magna. Suspendisse tristique neque venenatis lacus. Etiam bibendum fermentum","2020-03-24 08:28:49",1,2),(2,"ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget","2020-08-29 20:29:45",1,2),(1,"ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi metus. Vivamus euismod urna.","2020-10-12 07:08:36",1,2),(2,"risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien","2021-10-21 20:48:06",1,2),(1,"Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus","2020-08-13 17:56:16",1,2),(2,"Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas.","2021-04-11 05:48:00",1,2),(1,"vel turpis. Aliquam adipiscing lobortis risus. In mi pede, nonummy","2021-03-12 00:04:55",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (2,"dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse","2020-06-30 05:38:35",1,2),(2,"Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque","2021-02-04 04:36:38",1,1),(2,"orci, adipiscing non, luctus sit amet, faucibus ut, nulla. Cras eu tellus eu augue porttitor","2021-05-24 14:54:01",1,1),(1,"ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc. In at pede. Cras","2020-04-24 06:17:38",1,2),(1,"nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula","2020-09-29 07:43:41",1,2),(2,"et, magna. Praesent interdum ligula eu enim. Etiam imperdiet dictum","2020-08-03 06:41:33",1,1),(1,"convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu,","2021-09-17 00:24:39",1,2),(2,"ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin","2021-01-13 13:34:17",1,1),(1,"vel pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas","2020-11-24 20:19:22",1,2),(1,"In at pede. Cras vulputate velit eu sem. Pellentesque ut ipsum ac","2020-03-02 02:29:21",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (2,"Cras pellentesque. Sed dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor","2020-03-13 03:28:14",1,2),(1,"bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare","2020-01-18 03:28:24",1,2),(2,"arcu. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis.","2020-02-03 05:59:53",1,1),(2,"vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim","2021-09-28 02:11:24",1,1),(1,"eget varius ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec","2020-01-29 11:58:20",1,1),(2,"dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam,","2020-08-19 14:15:23",1,2),(2,"risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi","2021-05-17 13:36:58",1,1),(2,"Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque. Sed dictum. Proin","2020-09-05 19:17:55",1,1),(2,"odio semper cursus. Integer mollis. Integer tincidunt aliquam arcu. Aliquam","2021-01-30 01:19:49",1,1),(2,"ultrices iaculis odio. Nam interdum enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque","2021-01-24 21:26:00",1,2);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (2,"Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.","2021-07-06 22:53:43",1,1),(2,"Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est.","2021-10-08 07:35:39",1,1),(1,"sed tortor. Integer aliquam adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque","2021-04-18 05:39:28",1,2),(2,"at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus","2020-11-29 21:27:33",1,2),(1,"dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et","2021-02-28 08:46:32",1,2),(1,"arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed, facilisis vitae, orci.","2019-11-20 16:44:37",1,1),(2,"ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo","2020-10-25 22:08:50",1,1),(1,"erat. Sed nunc est, mollis non, cursus non, egestas a, dui. Cras pellentesque.","2021-03-24 06:07:03",1,1),(2,"ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque.","2021-04-09 13:35:02",1,2),(2,"vel, faucibus id, libero. Donec consectetuer mauris id sapien. Cras dolor","2021-03-20 06:29:11",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (1,"facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc","2020-03-10 20:50:08",1,1),(1,"ultricies adipiscing, enim mi tempor lorem, eget mollis lectus pede et risus. Quisque libero lacus, varius et,","2020-06-08 11:00:50",1,2),(1,"lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer","2020-07-13 20:02:53",1,1),(1,"lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede.","2020-05-11 13:19:43",1,1),(1,"enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium","2020-12-22 22:00:16",1,1),(2,"fringilla cursus purus. Nullam scelerisque neque sed sem egestas blandit.","2020-07-22 21:14:59",1,1),(2,"risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam","2021-06-20 20:04:06",1,1),(2,"mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus.","2019-11-05 13:21:38",1,2),(1,"natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin","2020-07-13 13:12:01",1,2),(1,"id, ante. Nunc mauris sapien, cursus in, hendrerit consectetuer, cursus","2021-09-02 22:15:38",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (1,"vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc","2020-01-04 08:23:13",1,1),(1,"malesuada augue ut lacus. Nulla tincidunt, neque vitae semper egestas, urna justo","2021-04-30 17:51:10",1,2),(1,"tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at,","2020-02-04 20:02:25",1,1),(2,"amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor diam dictum sapien. Aenean massa.","2020-02-02 03:20:03",1,2),(2,"convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus","2021-01-08 00:59:44",1,2),(1,"conubia nostra, per inceptos hymenaeos. Mauris ut quam vel sapien","2021-06-02 10:30:50",1,2),(2,"elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat","2020-11-07 04:11:45",1,1),(1,"mi pede, nonummy ut, molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi.","2019-12-27 16:43:23",1,2),(1,"magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros","2020-03-18 17:10:23",1,2),(2,"fringilla purus mauris a nunc. In at pede. Cras vulputate velit eu sem. Pellentesque ut","2021-01-21 19:32:17",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (1,"nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam","2020-06-08 07:48:56",1,1),(2,"amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae","2021-01-26 15:14:24",1,1),(2,"lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam","2020-12-27 05:21:27",1,2),(2,"velit. Sed malesuada augue ut lacus. Nulla tincidunt, neque vitae semper","2020-11-12 14:53:01",1,1),(2,"Suspendisse dui. Fusce diam nunc, ullamcorper eu, euismod ac, fermentum vel, mauris. Integer sem","2020-07-30 06:50:14",1,1),(1,"congue. In scelerisque scelerisque dui. Suspendisse ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc","2020-09-05 16:38:30",1,1),(2,"diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna.","2020-06-07 17:23:42",1,1),(2,"ut erat. Sed nunc est, mollis non, cursus non, egestas a,","2020-05-03 18:40:36",1,2),(2,"facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius","2019-11-13 01:45:40",1,2),(2,"mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec","2019-12-19 07:19:27",1,1);
INSERT INTO reply (user_id,text,created_at,is_approved,comment_id) VALUES (2,"lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo.","2020-11-10 11:11:01",1,1),(2,"sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor","2020-03-04 10:53:50",1,1),(2,"Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim nisl elementum purus, accumsan","2020-12-13 20:44:42",1,1),(2,"libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis","2021-10-05 15:32:30",1,1),(2,"vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer","2021-10-04 06:23:08",1,2),(1,"egestas hendrerit neque. In ornare sagittis felis. Donec tempor, est ac mattis semper, dui","2019-12-04 07:55:35",1,2),(2,"a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero","2021-07-03 18:55:47",1,2),(1,"amet, dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus","2021-01-09 14:25:24",1,2),(1,"mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed","2020-03-30 01:39:16",1,2),(1,"adipiscing lacus. Ut nec urna et arcu imperdiet ullamcorper. Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a, malesuada","2020-01-30 00:20:27",1,2);
