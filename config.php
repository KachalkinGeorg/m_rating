<?php

# protect against hack attempts
if (!defined('NGCMS')) die ('HAL');

pluginsLoadConfig();
LoadPluginLang('m_rating', 'config', '', '', '#');

switch ($_REQUEST['action']) {
	case 'about':			about();		break;
	default: main();
}

function about()
{global $twig, $lang, $breadcrumb;
	$tpath = locatePluginTemplates(array('main', 'about'), 'm_rating', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-star-half-o btn-position"></i><span class="text-semibold">'.$lang['m_rating']['m_rating'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=m_rating' => '<i class="fa fa-star-half-o btn-position"></i>'.$lang['m_rating']['m_rating'].'',  '<i class="fa fa-exclamation-circle btn-position"></i>'.$lang['m_rating']['about'].'' ) );

	$xt = $twig->loadTemplate($tpath['about'].'about.tpl');
	$tVars = array();
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$about = 'версия 0.3';
	
	$tVars = array(
		'global' => $lang['m_rating']['about'],
		'header' => $about,
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}

function main()
{global $twig, $lang, $breadcrumb;
	
	$tpath = locatePluginTemplates(array('main', 'general.from'), 'm_rating', 1);
	$breadcrumb = breadcrumb('<i class="fa fa-star-half-o btn-position"></i><span class="text-semibold">'.$lang['m_rating']['m_rating'].'</span>', array('?mod=extras' => '<i class="fa fa-puzzle-piece btn-position"></i>'.$lang['extras'].'', '?mod=extra-config&plugin=m_rating' => '<i class="fa fa-star-half-o btn-position"></i>'.$lang['m_rating']['m_rating'].'' ) );

	if (isset($_REQUEST['submit'])){
		pluginSetVariable('m_rating', 'guest', (int)$_REQUEST['guest']);
		pluginSetVariable('m_rating', 'revote', (int)$_REQUEST['revote']);
		pluginSetVariable('m_rating', 'localsource', (int)$_REQUEST['localsource']);
		pluginsSaveConfig();
		msg(array("type" => "info", "info" => $lang['m_rating']['save']));
		return print_msg( 'info', $lang['m_rating']['m_rating'], $lang['m_rating']['save'], 'javascript:history.go(-1)' );
	}
	
	$guest = pluginGetVariable('m_rating', 'guest');
	$guest = '<option value="0" '.($guest==0?'selected':'').'>'.$lang['noa'].'</option><option value="1" '.($guest==1?'selected':'').'>'.$lang['yesa'].'</option>';
	$revote = pluginGetVariable('m_rating', 'revote');
	$revote = '<option value="0" '.($revote==0?'selected':'').'>'.$lang['noa'].'</option><option value="1" '.($revote==1?'selected':'').'>'.$lang['yesa'].'</option>';

	$xt = $twig->loadTemplate($tpath['general.from'].'general.from.tpl');
	$xg = $twig->loadTemplate($tpath['main'].'main.tpl');
	
	$tVars = array(
		'guest'   	=> $guest,
		'revote'   	=> $revote,
		'localsource'   => MakeDropDown(array(0 => 'Шаблон сайта', 1 => 'Плагина'), 'localsource', (int)pluginGetVariable('m_rating', 'localsource')),
	);
	
	$tVars = array(
		'global' => $lang['m_rating']['common'],
		'header' => '<i class="fa fa-exclamation-circle"></i> <a href="?mod=extra-config&plugin=m_rating&action=about">'.$lang['m_rating']['about'].'</a>',
		'entries' => $xt->render($tVars)
	);
	
	print $xg->render($tVars);
}
