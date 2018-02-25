/**
 * Database schema required by \yii\rbac\DbManager.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @since 2.0
 */
create SCHEMA auth;

drop table if exists auth.assignment;
drop table if exists auth.item_child;
drop table if exists auth.item;
drop table if exists auth.rule;


create table auth.rule
(
    "name"  varchar(64) not null,
    "data"  bytea,
    "created_at"           integer,
    "updated_at"           integer,
    primary key ("name")
);

create table auth.item
(
   "name"                 varchar(64) not null,
   "type"                 smallint not null,
   "description"          text,
   "rule_name"            varchar(64),
   "data"                 bytea,
   "created_at"           integer,
   "updated_at"           integer,
   primary key ("name"),
   foreign key ("rule_name") references auth.rule ("name") on delete set null on update cascade
);

create index auth_item_type_idx on auth.item ("type");

create table auth.item_child
(
   "parent"               varchar(64) not null,
   "child"                varchar(64) not null,
   primary key ("parent","child"),
   foreign key ("parent") references auth.item ("name") on delete cascade on update cascade,
   foreign key ("child") references auth.item ("name") on delete cascade on update cascade
);

create table auth.assignment
(
   "item_name"            varchar(64) not null,
   "user_id"              varchar(64) not null,
   "created_at"           integer,
   primary key ("item_name","user_id"),
   foreign key ("item_name") references auth.item ("name") on delete cascade on update cascade
);

create index auth_assignment_user_id_idx on auth.assignment ("user_id");
