/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2013/5/11 14:56:51                           */
/*==============================================================*/


drop table if exists sta_Comment;

drop table if exists sta_Game;

drop table if exists sta_UnderVerifiedGame;

drop table if exists sta_UserAndGame;

drop table if exists sta_user;

/*==============================================================*/
/* Table: sta_Comment                                           */
/*==============================================================*/
create table sta_Comment
(
   comment_id           int not null auto_increment,
   game_id              int,
   user_id              int,
   content              varchar(1024),
   status               int not null,
   primary key (comment_id)
)
engine = InnoDB charset = UTF8;

/*==============================================================*/
/* Table: sta_Game                                              */
/*==============================================================*/
create table sta_Game
(
   game_id              int not null auto_increment,
   user_id              int,
   name                 varchar(128) not null,
   alias                varchar(128),
   price                double,
   deploy_url           varchar(256) not null,
   tags                 varchar(256),
   summary              varchar(1024),
   description          varchar(4096),
   params               varchar(1024),
   primary key (game_id)
)
engine = InnoDB charset = UTF8;

/*==============================================================*/
/* Table: sta_UnderVerifiedGame                                 */
/*==============================================================*/
create table sta_UnderVerifiedGame
(
   game_id              int not null auto_increment,
   user_id              int,
   name                 varchar(30) not null,
   tags                 varchar(256),
   summary              varchar(1024),
   content              varchar(4096),
   download_url         varchar(256),
   params               varchar(1024),
   primary key (game_id)
)
engine = InnoDB charset = UTF8;

/*==============================================================*/
/* Table: sta_UserAndGame                                       */
/*==============================================================*/
create table sta_UserAndGame
(
   user_id              int not null,
   game_id              int not null,
   primary key (user_id, game_id)
)
engine = InnoDB charset = UTF8;

/*==============================================================*/
/* Table: sta_user                                              */
/*==============================================================*/
create table sta_user
(
   user_id              int not null auto_increment,
   username             varchar(20) not null,
   password             varchar(128) not null,
   nickname             varchar(20) not null,
   email                varchar(128) not null,
   wallet               double not null,
   params               varchar(1024),
   primary key (user_id)
)
engine = InnoDB charset = UTF8;

alter table sta_Comment add constraint FK_HasCommemt foreign key (game_id)
      references sta_Game (game_id) on delete restrict on update restrict;

alter table sta_Comment add constraint FK_OwnComment foreign key (user_id)
      references sta_user (user_id) on delete restrict on update restrict;

alter table sta_Game add constraint FK_developer foreign key (user_id)
      references sta_user (user_id) on delete restrict on update restrict;

alter table sta_UnderVerifiedGame add constraint FK_IsDeveloper foreign key (user_id)
      references sta_user (user_id) on delete restrict on update restrict;

alter table sta_UserAndGame add constraint FK_sta_GameOwnUser foreign key (game_id)
      references sta_Game (game_id) on delete restrict on update restrict;

alter table sta_UserAndGame add constraint FK_sta_UserOwnGame foreign key (user_id)
      references sta_user (user_id) on delete restrict on update restrict;

