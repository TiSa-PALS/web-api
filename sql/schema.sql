CREATE TABLE IF NOT EXISTS `type` (
  `type_id` INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name`    VARCHAR(256) NOT NULL
);

CREATE TABLE IF NOT EXISTS `producer` (
  `producer_id` INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name`        VARCHAR(256) NOT NULL
);

CREATE TABLE IF NOT EXISTS `product` (
  `product_id`              INT(11)        NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `producer_id`             INT(11)        NOT NULL,
  `type_id`                 INT(11)        NOT NULL,
  `order_number`            VARCHAR(256)   NOT NULL,
  `spec`                    VARCHAR(256)   NULL     DEFAULT NULL,
  `datasheet`               VARCHAR(256)   NULL     DEFAULT NULL,
  `size`                    VARCHAR(256)   NULL     DEFAULT NULL,
  `thickness`               DECIMAL(12, 2) NULL     DEFAULT NULL,
  `coating`                 VARCHAR(256)   NULL     DEFAULT NULL,
  `material`                VARCHAR(256)   NULL     DEFAULT NULL,
  `surface_type`            VARCHAR(256)   NULL     DEFAULT NULL,

  `wavelength_from`         INT(11)        NULL     DEFAULT NULL,
  `wavelength_to`           INT(11)        NULL     DEFAULT NULL,
  `wavelength_note`         VARCHAR(256)   NULL     DEFAULT NULL,

  `incidence_angle`         DECIMAL(12, 2) NULL     DEFAULT NULL,

  `length_difference`       VARCHAR(32)    NULL     DEFAULT NULL,
  `transmission_wavelength` VARCHAR(256)   NULL     DEFAULT NULL,
  `transmission`            DECIMAL(12, 2) NULL     DEFAULT NULL,
  `optical_density`         DECIMAL(12, 2) NULL     DEFAULT NULL,
  `angle`                   VARCHAR(256)   NULL     DEFAULT NULL,
  `angle_tolerance`         VARCHAR(256)   NULL     DEFAULT NULL,
  `reflectivity`            VARCHAR(256)   NULL     DEFAULT NULL,
  `focus`                   INTEGER(11)    NULL     DEFAULT NULL,
  `polarization`            VARCHAR(256)   NULL     DEFAULT NULL,
  `surface`                 VARCHAR(256)   NULL     DEFAULT NULL,
  `note`                    TEXT           NULL     DEFAULT NULL,

  INDEX fk_item_type_idx (`type_id` ASC),
  INDEX fk_item_producer_idx (`producer_id` ASC),
  UNIQUE (`order_number`),
  FOREIGN KEY (`type_id`)
  REFERENCES `type` (`type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  FOREIGN KEY (`producer_id`)
  REFERENCES `producer` (`producer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE IF NOT EXISTS `grant` (
  `grant_id` INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name`     VARCHAR(256) NOT NULL
);

CREATE TABLE IF NOT EXISTS `item` (
  `item_id`    INT(11)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id`         INT(11)     NOT NULL,
  `EUIN`       VARCHAR(64) NULL     DEFAULT NULL,
  `product_id` INT(11)     NOT NULL,
  `has_box`    TINYINT(1)  NULL     DEFAULT NULL,
  `exist`      TINYINT(1)  NULL     DEFAULT NULL,
  `state`      varchar(32) NULL     DEFAULT NULL,
  `grant_id`   INT(11)     NOT NULL,
  `arrived`    DATETIME    NULL     DEFAULT NULL,
  `placement`  VARCHAR(256),
  `note`       TEXT,
  INDEX fk_item_product_idx (`product_id` ASC),
  INDEX fk_item_grant_idx (`grant_id` ASC),
  CONSTRAINT `fk_item_product_1`
  FOREIGN KEY (`product_id`)
  REFERENCES `product` (`product_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  FOREIGN KEY (`grant_id`)
  REFERENCES `grant` (`grant_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);
