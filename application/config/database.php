<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn' => '',
	'hostname' => 'ecovisrkca-covidecare-com.cdeky8oy4qrz.ap-south-1.rds.amazonaws.com',
	'username' => 'covidecare',
	'password' => 'ec0v!1995^c0',
	'database' => 'covidcare',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
$active_group2 = 'live';
$db['live'] = array(
	'dsn' => '',
	'hostname' => 'covid-new.cjhicuhwhkqt.ap-south-1.rds.amazonaws.com',
	'username' => 'covid_new',
	'password' => 'aws#covid#T20',
//	'username' => 'u890460787_6rCdl',
//	'password' => 'Docplus@123',
	'database' => 'covid3',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
