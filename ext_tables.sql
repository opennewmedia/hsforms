#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_hsforms_form_ibelink text DEFAULT '' NULL,
	tx_hsforms_form_view int(11) DEFAULT 0 NOT NULL,
	tx_hsforms_form_layout int(11) DEFAULT 0 NOT NULL,
	tx_hsforms_form_modaltitle text DEFAULT '' NULL,
	tx_hsforms_form_btnlabel text DEFAULT '' NULL,
	tx_hsforms_form_text text DEFAULT '' NULL,
	tx_hsforms_form_cssclasses text DEFAULT '' NULL,
	tx_hsforms_form_promocode text DEFAULT '' NULL,
	tx_hsforms_form_minpersons int(11) DEFAULT 1 NOT NULL,
	tx_hsforms_form_maxpersons int(11) DEFAULT 7 NOT NULL,
	tx_hsforms_form_minadults int(11) DEFAULT 1 NOT NULL,
	tx_hsforms_form_maxadults int(11) DEFAULT 2 NOT NULL,
	tx_hsforms_form_defadults int(11) DEFAULT 2 NOT NULL,
	tx_hsforms_form_minchildren int(11) DEFAULT 1 NOT NULL,
	tx_hsforms_form_maxchildren int(11) DEFAULT 2 NOT NULL,
	tx_hsforms_form_defchildren int(11) DEFAULT 0 NOT NULL,
	tx_hsforms_form_minnights int(11) DEFAULT 1 NOT NULL,
	tx_hsforms_form_maxnights int(11) DEFAULT 2 NOT NULL,
	tx_hsforms_form_minrooms int(11) DEFAULT 1 NOT NULL,
	tx_hsforms_form_maxrooms int(11) DEFAULT 2 NOT NULL,
	tx_hsforms_form_daysallowed int(11) DEFAULT 0 NOT NULL,
	tx_hsforms_form_daysallowed_converted varchar(255) DEFAULT '' NOT NULL,
	tx_hsforms_form_travelperiods varchar(255) DEFAULT '' NOT NULL,
	tx_hsforms_form_promocode_flag tinyint(1) DEFAULT 0 NOT NULL,
	tx_hsforms_form_rate_flag tinyint(1) DEFAULT 0 NOT NULL,
	tx_hsforms_form_segment_flag tinyint(1) DEFAULT 0 NOT NULL,
	tx_hsforms_form_rates varchar(255) DEFAULT '' NOT NULL,
	tx_hsforms_form_segments varchar(255) DEFAULT '' NOT NULL,
	tx_hsforms_form_daysfromnow varchar(255) DEFAULT '' NOT NULL,
	tx_hsforms_form_daystillend varchar(255) DEFAULT '' NOT NULL,
	tx_hsforms_form_lastbookingdate datetime DEFAULT '1970-01-01 00:00:01',
	tx_hsforms_form_keepparams tinyint(1) DEFAULT 0 NOT NULL,
	tx_hsforms_form_customtemplate text DEFAULT '' NULL,
	tx_hsforms_form_allowedparams text DEFAULT '' NULL,
	tx_hsforms_form_legends_flag tinyint(1) DEFAULT 0 NOT NULL,
	tx_hsforms_form_buffer_flag tinyint(1) DEFAULT 0 NOT NULL,
	tx_hsforms_form_addrooms_flag tinyint(1) DEFAULT 0 NOT NULL
);

#
# Table structure for table 'tx_hsforms_domain_model_travelperiod'
#
CREATE TABLE tx_hsforms_domain_model_travelperiod (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	start int(11) DEFAULT '0' NULL,
	end int(11) DEFAULT '0' NULL,
	internal_name varchar(255) DEFAULT '' NOT NULL,
	daysallowed int(11) unsigned DEFAULT '127' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_hsforms_domain_model_rate'
#
CREATE TABLE tx_hsforms_domain_model_rate (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	code varchar(255) DEFAULT '' NOT NULL,
	internal_name varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_hsforms_domain_model_segment'
#
CREATE TABLE tx_hsforms_domain_model_segment (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	code varchar(255) DEFAULT '' NOT NULL,
	title text,
	description text,
	image int(11) unsigned NOT NULL default '0',
	internal_name varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_hsforms_config'
#
CREATE TABLE tx_hsforms_config
(
	uid int(11) NOT NULL auto_increment,
	config varchar(255) DEFAULT '' NOT NULL,
	value varchar(255) DEFAULT '' NOT NULL,
	PRIMARY KEY (uid)
);
