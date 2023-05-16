<?php
if (!defined('NGCMS'))
{
	die ('HAL');
}

function plugin_m_rating_install($action) {
	global $lang;
	
	if ($action != 'autoapply')
		loadPluginLang('m_rating', 'config', '', '', ':');
	
	$db_update = array(
		array(
			'table' => 'news',
			'action' => 'modify',
			'key' => 'primary key (`id`)',
			'fields' => array(
				array('action' => 'cmodify', 'name' => 'm_rating', 'type' => 'varchar(255)', 'params' => 'NOT NULL DEFAULT \'\'')
			)
		),
		array(
			'table'  => 'm_rating',
			'action' => 'cmodify',
			'key'    => 'primary key (id), KEY `news_id` (`news_id`)',
			'fields' => array(
				array('action' => 'cmodify', 'name' => 'id', 'type' => 'int(6)', 'params' => 'NOT NULL AUTO_INCREMENT'),
				array('action' => 'cmodify', 'name' => 'news_id', 'type' => 'int(6)', 'params' => 'NOT NULL'),
				array('action' => 'cmodify', 'name' => 'ip', 'type' => 'varchar(15)', 'params' => 'NOT NULL'),
				array('action' => 'cmodify', 'name' => 'member', 'type' => 'varchar(70)', 'params' => 'NOT NULL'),
				array('action' => 'cmodify', 'name' => 'area', 'type' => 'text', 'params' => 'NOT NULL')
			)
		)
	);
	
	switch ($action) {
		case 'confirm':
			generate_install_page('m_rating', $lang['m_rating:install']);
			break;
		case 'autoapply':
		case 'apply':
			if (fixdb_plugin_install('m_rating', $db_update, 'install', ($action == 'autoapply') ? true : false)) {
				plugin_mark_installed('m_rating');
			} else {
				return false;
			}
			// Now we need to set some default params
			$params = array(
				'localsource'   => 1,
				'revote' 		=> 0,
				'guest'   		=> 0,
			);
			foreach ($params as $k => $v) {
				extra_set_param('m_rating', $k, $v);
			}
			extra_commit_changes();
			break;
	}

	return true;
}