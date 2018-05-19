/* Clean */

-- alter table <PREFIX>_member drop foreign key IF EXISTS fk_members_contact_info;
-- alter table <PREFIX>_referent drop foreign key IF EXISTS fk_referent_contact_inf
-- alter table <PREFIX>_member_referents drop foreign key IF EXISTS fk_member_referents_members;
-- alter table <PREFIX>_member_referents drop foreign key IF EXISTS fk_member_referents_referent;
-- alter table <PREFIX>_entity drop foreign key IF EXISTS fk_entity_contact_info;
-- alter table <PREFIX>_entity_referents drop foreign key IF EXISTS fk_entity_referents_entity;
-- alter table <PREFIX>_entity_referents drop foreign key IF EXISTS fk_entity_ref
-- alter table <PREFIX>_category drop foreign key IF EXISTS fk_category_entity;
-- alter table <PREFIX>_category drop foreign key IF EXISTS fk_category_season;
-- alter table <PREFIX>_category_members drop foreign key IF EXISTS fk_category_members_category;
-- alter table <PREFIX>_category_members drop foreign key IF EXISTS fk_category_members_member;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS <PREFIX>_contact_info;
DROP TABLE IF EXISTS <PREFIX>_member;
DROP TABLE IF EXISTS <PREFIX>_referent;
DROP TABLE IF EXISTS <PREFIX>_member_referents;
DROP TABLE IF EXISTS <PREFIX>_entity;
DROP TABLE IF EXISTS <PREFIX>_entity_referents;
DROP TABLE IF EXISTS <PREFIX>_season;
DROP TABLE IF EXISTS <PREFIX>_category;
DROP TABLE IF EXISTS <PREFIX>_category_members;
SET FOREIGN_KEY_CHECKS = 1;

/* Create */

-- contact_info
CREATE TABLE <PREFIX>_contact_info (
  cif_id int unsigned NOT NULL AUTO_INCREMENT,
  cif_create datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,

  cif_gsm varchar(16),
  cif_email varchar(128),

  cif_address varchar(256),
  cif_postal_code varchar(16),
  cif_city varchar(64),
  cif_country varchar(64),

  PRIMARY KEY  (cif_id)

) <CHARSET_COLLATE>;

-- members
CREATE TABLE <PREFIX>_member (
  mem_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  mem_create datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,

  mem_first_name varchar(32)  NOT NULL,
  mem_last_name varchar(32)  NOT NULL,

  mem_birth_date datetime  NOT NULL,
  mem_birth_place varchar(256)  NOT NULL,

  mem_gender boolean,

  mem_cif_id int unsigned,

  mem_wp_id bigint(20) unsigned,

  PRIMARY KEY  (mem_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_member
ADD CONSTRAINT fk_members_contact_info FOREIGN KEY (mem_cif_id) REFERENCES <PREFIX>_contact_info(cif_id);

-- referent
CREATE TABLE <PREFIX>_referent (
  ref_id int unsigned NOT NULL AUTO_INCREMENT,
  ref_create datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,

  ref_first_name varchar(32)  NOT NULL,
  ref_last_name varchar(32)  NOT NULL,

  ref_cif_id int unsigned NOT NULL,

  PRIMARY KEY  (ref_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_referent
ADD CONSTRAINT fk_referent_contact_info FOREIGN KEY (ref_cif_id) REFERENCES <PREFIX>_contact_info(cif_id);

-- member_referents
CREATE TABLE <PREFIX>_member_referents (
  mrf_member_id bigint(20) unsigned NOT NULL,
  mrf_referent_id int unsigned NOT NULL,

  mrf_role varchar(64),

  PRIMARY KEY  (mrf_member_id, mrf_referent_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_member_referents
ADD CONSTRAINT fk_member_referents_members FOREIGN KEY (mrf_member_id) REFERENCES <PREFIX>_member(mem_id);

ALTER TABLE <PREFIX>_member_referents
ADD CONSTRAINT fk_member_referents_referent FOREIGN KEY (mrf_referent_id) REFERENCES <PREFIX>_referent(ref_id);

-- Entity
CREATE TABLE <PREFIX>_entity (
  ent_id int unsigned NOT NULL AUTO_INCREMENT,
  ent_create datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,

  ent_name varchar(64)  NOT NULL,

  ent_cif_id int unsigned,

  PRIMARY KEY  (ent_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_entity
ADD CONSTRAINT fk_entity_contact_info FOREIGN KEY (ent_cif_id) REFERENCES <PREFIX>_contact_info(cif_id);

-- entity_referents
CREATE TABLE <PREFIX>_entity_referents (
  etf_ent_id int unsigned NOT NULL,
  etf_ref_id int unsigned NOT NULL,

  etf_role varchar(64),

  PRIMARY KEY  (etf_ent_id, etf_ref_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_entity_referents
ADD CONSTRAINT fk_entity_referents_entity FOREIGN KEY (etf_ent_id) REFERENCES <PREFIX>_entity(ent_id);

ALTER TABLE <PREFIX>_entity_referents
ADD CONSTRAINT fk_entity_referents_referent FOREIGN KEY (etf_ent_id) REFERENCES <PREFIX>_referent(ref_id);

-- season
CREATE TABLE <PREFIX>_season (
  sea_id int unsigned NOT NULL AUTO_INCREMENT,

  sea_start_date datetime NOT NULL,
  sea_end_date datetime NOT NULL,

  PRIMARY KEY (sea_id)

) <CHARSET_COLLATE>;

-- category
CREATE TABLE <PREFIX>_category (
  cat_id int unsigned NOT NULL AUTO_INCREMENT,

  cat_ent_id int unsigned NOT NULL,
  cat_sea_id int unsigned NOT NULL,

  PRIMARY KEY (cat_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_category
ADD CONSTRAINT fk_category_entity FOREIGN KEY (cat_ent_id) REFERENCES <PREFIX>_entity(ent_id);

ALTER TABLE <PREFIX>_category
ADD CONSTRAINT fk_category_season FOREIGN KEY (cat_sea_id) REFERENCES <PREFIX>_season(sea_id);

-- 
CREATE TABLE <PREFIX>_category_members (
  ctm_cat_id int unsigned NOT NULL,
  ctm_mem_id bigint(20) unsigned NOT NULL,

  PRIMARY KEY (ctm_cat_id, ctm_mem_id)

) <CHARSET_COLLATE>;

ALTER TABLE <PREFIX>_category_members
ADD CONSTRAINT fk_category_members_category FOREIGN KEY (ctm_cat_id) REFERENCES <PREFIX>_category(cat_id);

ALTER TABLE <PREFIX>_category_members
ADD CONSTRAINT fk_category_members_member FOREIGN KEY (ctm_mem_id) REFERENCES <PREFIX>_member(mem_id);
