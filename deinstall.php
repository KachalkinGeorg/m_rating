<?php
// Protect against hack attempts
if (!defined('NGCMS')) die ('HAL');

loadPluginLang('m_rating', 'config', '', '', ':');

$db_update = array(
	array(
		'table'  => 'm_rating',
		'action' => 'drop',
	),
	array(
		'table'  => 'news',
		'action' => 'modify',
		'fields' => array(
			array('action' => 'drop', 'name' => 'm_rating'),
		)
	)
);

if ($_REQUEST['action'] == 'commit') {
	if (fixdb_plugin_install('m_rating', $db_update, 'deinstall')) {
		plugin_mark_deinstalled('m_rating');
	}
} else {
	generate_install_page('m_rating', $lang['m_rating:deinstall'], 'deinstall');
}