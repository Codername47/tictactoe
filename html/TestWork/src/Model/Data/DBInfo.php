<?php

namespace TestWork\Model\Data;

class DBInfo
{
    const SQL_CREATE_USER_TABLE_QUERY = "CREATE TABLE `tictactoe`.`user` (
  `id` INT NOT NULL,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `level` VARCHAR(45) NULL,
  `game_id` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `game_id_UNIQUE` (`game_id` ASC) VISIBLE,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  CONSTRAINT `game_id`
    FOREIGN KEY (`game_id`)
    REFERENCES `tictactoe`.`game` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

";
    const SQL_CREATE_GAME_TABLE_QUERY = "CREATE TABLE `tictactoe`.`game` (
  `id` INT NOT NULL,
  `field_1` VARCHAR(1) NULL,
  `field_2` VARCHAR(1) NULL,
  `field_3` VARCHAR(1) NULL,
  `field_4` VARCHAR(1) NULL,
  `field_5` VARCHAR(1) NULL,
  `field_6` VARCHAR(1) NULL,
  `field_7` VARCHAR(1) NULL,
  `field_8` VARCHAR(1) NULL,
  `field_9` VARCHAR(1) NULL,
  `statis` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));
";
    const SQL_CREATE_GUILD_TABLE_QUERY = "CREATE TABLE `tictactoe`.`guild` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `parent_guild` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) VISIBLE);
";
    const SQL_ADD_GUILD_PARENT_FK = "ALTER TABLE `tictactoe`.`guild` 
ADD INDEX `parent_guild_idx` (`parent_guild` ASC) VISIBLE;
ALTER TABLE `tictactoe`.`guild` 
ADD CONSTRAINT `parent_guild`
  FOREIGN KEY (`parent_guild`)
  REFERENCES `tictactoe`.`guild` (`id`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;
";
    const SQL_CREATE_GUILD_MEMBER = "CREATE TABLE `tictactoe`.`guild_member` (
  `user_id` INT NOT NULL,
  `guild_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `guild_id`),
  INDEX `guild_id_idx` (`guild_id` ASC) VISIBLE,
  CONSTRAINT `user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `tictactoe`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `guild_id`
    FOREIGN KEY (`guild_id`)
    REFERENCES `tictactoe`.`guild` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
";
    public static function getInfo()
    {
        return [
            "tables" => [
                'userTable' => 'user',
                'guildTable' => 'guild',
                'memberTable' => 'guild_member',
                'gameTable' => 'game'
            ],
            'queries' => [
                'gameCreateTableQuery' => self::SQL_CREATE_GAME_TABLE_QUERY,
                'userCreateTableQuery' => self::SQL_CREATE_USER_TABLE_QUERY,
                'guildCreateTableQuery' => self::SQL_CREATE_GUILD_TABLE_QUERY." ".self::SQL_ADD_GUILD_PARENT_FK,
                'guildMembersTableQuery' => self::SQL_CREATE_GUILD_MEMBER
            ],
        ];
    }
}