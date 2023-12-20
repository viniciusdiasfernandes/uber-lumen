drop schema uber;
create schema uber;
create table uber.account
(
    account_id         VARCHAR(120) PRIMARY KEY,
    name               varchar(60),
    email              varchar(60),
    cpf                varchar(60),
    car_plate          varchar(60) null,
    is_passenger       boolean,
    is_driver          boolean,
    status             varchar(64),
    password           varchar(60),
    password_algorithm varchar(60) null,
    salt               varchar(60) null,
    verification_code  varchar(120)
);
create table uber.ride
(
    ride_id      VARCHAR(120) PRIMARY KEY,
    passenger_id VARCHAR(120),
    constraint ride_passenger_id_foreign
        foreign key (passenger_id) references account (account_id),
    driver_id    varchar(120) NULL,
    constraint ride_driver_id_foreign
        foreign key (driver_id) references account (account_id),
    status       varchar(60),
    fare         decimal,
    distance     decimal,
    from_lat     varchar(60),
    from_long    varchar(60),
    to_lat       varchar(60),
    to_long      varchar(60),
    date         integer
);
create table uber.position
(
    position_id varchar(120) primary key,
    ride_id     varchar(120),
    constraint position_ride_id_foreign
        foreign key (ride_id) references ride (ride_id),
    latitude    varchar(60),
    longitude   varchar(60),
    date        integer
);
