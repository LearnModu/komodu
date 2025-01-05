create table users (
    id int primary key auto_increment,
    username varchar(50) unique not null,
    email varchar(150) unique not null,
    passhash varchar(255) not null,
    created_at timestamp default current_timestamp
);

create table comments (
    id int primary key auto_increment,
    site_code varchar(16) not null,
    author_name varchar(150) not null,
    content text not null,
    upvotes int default 0,
    downvotes int default 0,
    parent_id int default null,
    created_at timestamp default current_timestamp,
    foreign key (parent_id) references comments(id)
);

create table sites (
    id int primary key auto_increment,
    user_id int not null,
    embed_code varchar(16) not null,
    site_url varchar(255) not null,
    created_at timestamp default current_timestamp,
    foreign key (user_id) references users(id)
);


