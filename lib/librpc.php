<?php

function mRatingGenerate($params) {
	global $mysql, $userROW, $ip, $newsID, $config, $is_logged, $echo;
	
	$area = $params['area'];
	$go_rate = $params['go_rate'];
	$news_id = intval($params['news_id']);

	if(!$news_id ) die("{\"error\": \"ID Новости недоступен\"}");
	if($go_rate > 10 or $go_rate < 1 ) die("{\"error\": \"Попытка мошенничества\"}");
	
	if(!pluginGetVariable('m_rating', 'guest')){
		if(!is_array($userROW)) die("{\"error\": \"У вас не достаточно прав для голосования\"}");
	}

	if( $is_logged ) $where = 'member = '.db_squote($userROW['name']).'';
	else $where = 'ip ='.db_squote($ip).'';
	
	$login = $userROW['name'] ? $userROW['name'] : 'гость';
	$log = $mysql->record('SELECT * FROM ' . prefix . '_m_rating WHERE news_id ='.db_squote($news_id).' AND '.$where.'' );
	if($log['news_id']){
		$log['area'] = explode("|",$log['area']);
		if(!pluginGetVariable('m_rating', 'revote'))
			if(in_array($area,$log['area'])) die("{\"error\": \"Вы уже голосовали\"}");
		
		else{
			$log['area'][] = $area;
			$log['area'] = implode("|",$log['area']);
			$mysql->query('UPDATE ' . prefix . '_m_rating SET area='.db_squote($log['area']).' WHERE news_id ='.db_squote($news_id).'' );
		}
	}else $mysql->query('INSERT INTO ' . prefix . '_m_rating (news_id, ip, member, area) values ('.db_squote($news_id).', '.db_squote($ip).', '.db_squote($login).', '.db_squote($area).')' );

	$row = $mysql->record("SELECT m_rating FROM " . prefix . "_news where id = " . db_squote($news_id)."");

	$m_rating = array();
	$temp = explode("||",$row['m_rating']);
	foreach($temp as $k=>$v){
		$v = explode("=",$v);
		$m_rating[$v[0]] = explode(":",$v[1]);
	}
	if($m_rating[$area]){
		$m_rating[$area][0] = $m_rating[$area][0]+1;
		$m_rating[$area][1] = $m_rating[$area][1]+$go_rate;
	}else $m_rating[$area] = array(1,$go_rate);

	foreach($m_rating as $k=>$v) $m_rating[$k] = $k."=".implode(":",$v);
	$row['m_rating'] = implode("||",$m_rating);

	$mysql->record("UPDATE " . prefix . "_news SET m_rating=".db_squote($row['m_rating'])." where id = " . db_squote($news_id)."");
	
	$is_ajax = true;
	include_once(root . "/plugins/m_rating/m_rating.php");

	$echo = m_rating_update($news_id);
	$echo = addcslashes($echo, "\v\t\n\r\f\"\\/");

	die("{\"html\":\"{$echo}\",\"error\": \"Ваш голос {$login} принят. Спасибо!\"}");

}

rpcRegisterFunction('plugin.m_rating.get', 'mRatingGenerate');

?>