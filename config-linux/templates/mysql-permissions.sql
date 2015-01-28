
/* administrator account */
GRANT ALL ON *.* TO 'admin'@'localhost' identified by '[% adminPassword %]' WITH GRANT OPTION;

/* read/write and read-only accounts for the application */
GRANT ALL ON *.* TO 'itechapp'@'localhost' identified by '[% itechappPassword %]';
GRANT SELECT ON *.* TO 'itechappselect'@'localhost' identified by '[% itechappPassword %]';

/* a user for CIRG people to use for administration */
GRANT ALL ON *.* TO 'cirgadmin'@'localhost' WITH GRANT OPTION;
UPDATE mysql.user SET Password = '[% cirgPasswordHashMysql %]' WHERE user = 'cirgadmin';

flush privileges;
