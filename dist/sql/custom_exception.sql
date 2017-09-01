-- -----------------------------------------------------
-- Table `ci_exceptions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ci_exceptions` (
  `id`           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `file`         VARCHAR(255)     NULL     DEFAULT NULL,
  `line`         INT(11)          NULL     DEFAULT NULL,
  `message`      VARCHAR(255)     NULL     DEFAULT NULL,
  `method`       VARCHAR(45)      NULL     DEFAULT NULL,
  `get`          TEXT             NULL     DEFAULT NULL,
  `post`         TEXT             NULL     DEFAULT NULL,
  `files`        TEXT             NULL     DEFAULT NULL,
  `is_ajax`      TINYINT(4)       NULL     DEFAULT NULL,
  `is_cli`       TINYINT(4)       NULL     DEFAULT NULL,
  `user_agent`   TEXT             NULL     DEFAULT NULL,
  `session_data` TEXT             NULL     DEFAULT NULL,
  `stack_trace`  TEXT             NULL     DEFAULT NULL,
  `sql_query`    TEXT             NULL     DEFAULT NULL,
  `sql_error`    TEXT             NULL     DEFAULT NULL,
  `created_time` TIMESTAMP        NULL     DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8;