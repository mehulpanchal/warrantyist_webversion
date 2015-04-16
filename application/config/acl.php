<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @file
 *
 * Configuration for ACL permissions
 *
 */

/**
 * Each controller or action can have its own permission array
 *
 * I've created some simple sample permissions based on the Drupal scheme
 *
 * Each controller or action can have add, edit own, edit all,
 * delete own and delete all - then add roles against the permissions
 */
$config['permission'] = array(
	'profile' => array(
		'change_profile' => array('0','1','2','3'),
		'manage_account' => array('0','1'),
		'user_management' => array('0','1'),
		'manage_devices' => array('0','1','3'),
		'export_data' => array('0','1','3'),
		'deactivate_account' => array('0','1'),
		'contact_information' => array('0','1'),
	),
	'umpires' => array(
		'add' => array('admin'),
		'edit own' => array('umpire', 'admin'),
		'edit all' => array('admin'),
		'delete own' => array('umpire', 'admin'),
		'delete all' => array('admin'),
	),
	'cricket' => array(
		'add' => array('umpire', 'admin'),
		'edit own' => array(), // not applicable
		'edit all' => array('umpire', 'admin'),
		'delete own' => array(), // not applicable
		'delete all' => array('umpire', 'admin'),
	),
);

/**
 * You can have as many roles as you like, each user or object can have multiple roles.
 */
$config['roles'] = array('0', '1', '2', '3', '4');
/* End of applications/config/acl.php */
