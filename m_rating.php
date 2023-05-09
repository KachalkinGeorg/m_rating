<?PHP
if (!defined('NGCMS')) die ('HAL');

include_once(root . "/plugins/m_rating/lib/class.php");

class MRatingFilter extends NewsFilter {
    function showNews($newsID, $SQLnews, &$tvars, $mode = array()) {
		global $config, $twig, $IP, $template, $userROW, $ip, $mysql, $lang;
	
		$row = $mysql->record("select * from " . prefix . "_news where id = " . db_squote($newsID)." LIMIT 1");
	
		$tpath = locatePluginTemplates(array('m_rating', ':m_rating.css'), 'm_rating', pluginGetVariable('m_rating', 'localsource'), pluginGetVariable('m_rating', 'skin') ? pluginGetVariable('m_rating', 'skin') : 'default');
		$xt = $twig->loadTemplate($tpath['m_rating'].'m_rating.tpl');
	
		register_stylesheet($tpath['url::m_rating.css'].'/m_rating.css');
	
		$rating = new m_rating($row['m_rating']);
	
		$tVars = array (
			'id' 		=> ''.$row['id'].'',
			'rate' 		=> ''.$rating->total['rate'].'',
			'video' 	=> ''.$rating->ratebar('video').'',
			'gameplay' 	=> ''.$rating->ratebar('gameplay').'',
			'sound' 	=> ''.$rating->ratebar('sound').'',
			'atm' 		=> ''.$rating->ratebar('atm').'',

			'rvideo' 	=> ''.$rating->rating('video').'',
			'rgameplay' => ''.$rating->rating('gameplay').'',
			'rsound' 	=> ''.$rating->rating('sound').'',
			'ratm' 		=> ''.$rating->rating('atm').'',
		
			'tvideo' 	=> ''.$rating->votes('video').'',
			'tgameplay' => ''.$rating->votes('gameplay').'',
			'tsound' 	=> ''.$rating->votes('sound').'',
			'tatm' 		=> ''.$rating->votes('atm').'',

			'news_id' => $newsID,
			'home' => home,
		);
	
		$tvars['vars']['m_rating'] = $xt->render($tVars);
	
	}
}

register_filter('news','m_rating', new MRatingFilter);
?>