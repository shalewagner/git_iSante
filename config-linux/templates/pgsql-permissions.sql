
CREATE USER clinlims PASSWORD '[% itechappPassword %]';
CREATE USER admin CREATEUSER PASSWORD '[% adminPassword %]';
CREATE USER cirgadmin SUPERUSER PASSWORD '[% cirgPasswordHashPgsql %]';
CREATE DATABASE clinlims OWNER clinlims encoding 'UTF-8';
