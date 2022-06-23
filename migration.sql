create table product_types (
                               type_id int PRIMARY KEY,
                               type_name varchar(30)
)

insert into product_types (type_id,type_name) values
(1,"DVD"),
(2,"Furniture"),
(3,"Book")

create table products (
                          sku varchar(13) PRIMARY KEY,
                          type_id int,
                          name varchar(30) not null,
                          price int not null,
                          unique key(sku,type_id),
                          FOREIGN KEY (type_id) REFERENCES product_types (type_id)
)

create table dvd (
                     sku varchar(13) PRIMARY KEY,
                     type_id int,
                     size int not null,
                     FOREIGN KEY (sku,type_id) REFERENCES products(sku,type_id) ON DELETE CASCADE
)

create table furniture (
                           sku varchar(13) PRIMARY KEY,
                           type_id int,
                           width int not null,
                           length int not null,
                           height int not null,
                           FOREIGN KEY (sku,type_id) REFERENCES products(sku,type_id) ON DELETE CASCADE
)

create table book (
                      sku varchar(13) PRIMARY KEY,
                      type_id int,
                      weight int not null,
                      FOREIGN KEY (sku,type_id) REFERENCES products(sku,type_id) ON DELETE CASCADE
)