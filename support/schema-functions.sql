SET GLOBAL log_bin_trust_function_creators=1;
DROP FUNCTION IF EXISTS digits;
DELIMITER |
CREATE FUNCTION itech.digits( str CHAR(32) ) RETURNS CHAR(32)
BEGIN
  DECLARE i, len SMALLINT DEFAULT 1;
  DECLARE ret CHAR(32) DEFAULT '';
  DECLARE c CHAR(1);

  IF str IS NULL
  THEN 
    RETURN "";
  END IF;

  SET len = CHAR_LENGTH( str );
  REPEAT
    BEGIN
      SET c = MID( str, i, 1 );
      IF c BETWEEN '0' AND '9' THEN 
        SET ret=CONCAT(ret,c);
      ELSEIF c = '.' OR c = ',' THEN
	SET ret=CONCAT(ret,'.');
      END IF;
      SET i = i + 1;
    END;
  UNTIL i > len END REPEAT;
  RETURN ret;
END |
DELIMITER ;

REVOKE ALL PRIVILEGES ON * . * FROM  'itechappselect'@'localhost';
REVOKE GRANT OPTION ON * . * FROM  'itechappselect'@'localhost';
GRANT SELECT , 
EXECUTE ON * . * 
TO  'itechappselect'@'localhost'
WITH MAX_QUERIES_PER_HOUR 0 
MAX_CONNECTIONS_PER_HOUR 0 
MAX_UPDATES_PER_HOUR 0 
MAX_USER_CONNECTIONS 0 ;

flush privileges;