MySQL_Ban - WEB PAGE
====================

I update web panel for support PHP 7.2:
https://forums.alliedmods.net/showthread.php?t=191283

How install?
1. Import current table to mysql

CREATE TABLE IF NOT EXISTS `my_bans` (
    `id` int(11) NOT NULL auto_increment,
    `steam_id` varchar(32) NOT NULL,
    `player_name` varchar(65) NOT NULL,
    `ban_length` int(1) NOT NULL default '0',
    `ban_reason` varchar(100) NOT NULL,
    `banned_by` varchar(100) NOT NULL,
    `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
    PRIMARY KEY  (`id`),
    UNIQUE KEY `steam_id` (`steam_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

2. Replace in databases.cfg settings:

	"default"
	{
		"driver"			"default"
		"host"				"localhost"
		"database"			"sourcemod"
		"user"				"root"
		"pass"				""
	}
	
3. Need compile plugin to smx in scripts and copy in folder plugins.