drop database if exists tolist;
create database tolist;
use tolist;

create table tarefas(
    id          int             auto_increment      primary key,
    descricao   varchar(255)    not null,
    concluida   tinyint(1)
);   