DROP TABLE <PREFIX>_members;

CREATE TABLE <PREFIX>_members (
  phm_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  phm_create datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
  phm_wp_id bigint(20) unsigned,
  PRIMARY KEY  (phm_id)
) <CHARSET_COLLATE>;