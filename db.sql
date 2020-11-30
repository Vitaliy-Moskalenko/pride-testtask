// ToDo: check phones datatype
         write foreign keys

--
-- Table `client`
--
CREATE TABLE IF NOT EXISTS `client` (
	`cl_id`    INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,   
	`cl_hexid` VARCHAR(32)      	NOT NULL,		
	`cl_name`  VARCHAR(128)         NOT NULL,
	`cl_age`   INT UNSIGNED         NOT NULL,
	`cl_city`  INT UNSIGNED         NOT NULL,
	`cl_membership_date` TIMESTAMP  NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

--
-- Table `phone`
--
CREATE TABLE IF NOT EXISTS `phone`(
	`p_id`       INT         PRIMARY KEY AUTO_INCREMENT,
	`p_clientId` INT         NOT NULL,
	`p_number`   VARCHAR(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

--
-- Table `city`
--
CREATE TABLE IF NOT EXISTS `city`(
	`c_id`   INT          PRIMARY KEY AUTO_INCREMENT,
	`c_name` VARCHAR(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=UTF8;

