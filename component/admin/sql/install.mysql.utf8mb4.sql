DROP TABLE IF EXISTS `#__com_tawny_parties`;

CREATE TABLE `#__com_tawny_parties` (
	`party_id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) UNIQUE NOT NULL,
	`acronym` VARCHAR(25) UNIQUE NOT NULL,
	`1` tinyint(4) DEFAULT 0,
	`2` tinyint(4)  DEFAULT 0,
	`3` tinyint(4)  DEFAULT 0,	
	`4` tinyint(4)  DEFAULT 0,
	`5` tinyint(4)  DEFAULT 0,
	`6` tinyint(4)  DEFAULT 0,
	`7` tinyint(4)  DEFAULT 0,
	`8` tinyint(4)  DEFAULT 0,
	`9` tinyint(4)  DEFAULT 0,						
	PRIMARY KEY (`party_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__com_tawny_parties` (`name`, `acronym`, `8`) VALUES
('Australian Labor Party', 'ALP', 1),
('Liberal Party' , 'LIB', 1 ), 
('Territory Alliance', 'TA', 1), 
('National Party', 'NAT', 1), 
('Australian Greens', 'GRN', 1);

DROP TABLE IF EXISTS `#__com_tawny_questions`;

CREATE TABLE `#__com_tawny_questions` (
	`question_id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`question` VARCHAR(150) UNIQUE NOT NULL,
	`issue` VARCHAR(25) NOT NULL,
	`keywords` VARCHAR(25) NOT NULL,
	`1` int(11) DEFAULT 0,
	`2` int(11)  DEFAULT 0,
	`3` int(11)  DEFAULT 0,	
	`4` int(11)  DEFAULT 0,
	`5` int(11)  DEFAULT 0,
	`6` int(11)  DEFAULT 0,
	`7` int(11)  DEFAULT 0,
	`8` int(11)  DEFAULT 0,
	`9` int(11)  DEFAULT 0,
	PRIMARY KEY (`question_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__com_tawny_questions` (`question`, `issue`, `keywords`, `8`) 
VALUES ('Protect life, save our children & stop the murder of the innocents - oppose abortion', 'Protect Life', 'abortion', 1), ('Protect the disabled, the elderly and vulnerable people - say NO to euthanasia', 'Protect Life', 'euthanasia', 2);

DROP TABLE IF EXISTS `#__com_tawny_votinghistory`;

CREATE TABLE `#__com_tawny_votinghistory` (
	`votehistory_id` INT(11) NOT NULL AUTO_INCREMENT,
	`question_id` INT(11) NOT NULL,
	`party_id` INT(11) NOT NULL,
	`score` INT(11) NOT NULL,
	`comment` VARCHAR(1000) NOT NULL,
	`bill_name` VARCHAR(500),
	`date` DATE,
	`jurisdiction` INT(11) NOT NULL,
	PRIMARY KEY (`votehistory_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__com_tawny_votinghistory` (`question_id`, `party_id`, `score`, `comment`, `jurisdiction`) 
VALUES (2, 2, -1, 'Description of the actual vote goes here.', 9), (2, 3, 1, 'A vote description goes here...', 9),(1, 3, 1, 'A vote description goes here...', 9), (1, 1, 1, 'A vote description goes here...', 9);

DROP TABLE IF EXISTS `#__com_tawny_policystatements`;

CREATE TABLE `#__com_tawny_policystatements` (
	`statement_id` INT(11) NOT NULL AUTO_INCREMENT,
	`question_id` INT(11) NOT NULL,
	`party_id` INT(11) NOT NULL,
	`score` INT(11) NOT NULL,
	`comment` VARCHAR(1000) NOT NULL,
	`source_url` VARCHAR(1000),
	`date` DATE,
	`jurisdiction` INT(11) NOT NULL,
	PRIMARY KEY (`statement_id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__com_tawny_policystatements` (`question_id`, `party_id`, `score`, `comment`, `jurisdiction`) 
VALUES (2, 2, -1, 'Party supports euthanasia', 9), (2, 1, 1, 'party opposes euthanasia', 9),(1, 3, -1, 'Policy statement supporting abortion', 9), (1, 2, 1, 'policy statement against abortion', 9);
