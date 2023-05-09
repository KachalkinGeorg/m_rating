<?php

class m_rating{
	var $row = array();
	var $total = array('rate'=>"0.0",'votes'=>0);

	public function __construct($row){
		if($row){
			$m_rating = array();
			$row = explode("||",$row);
			foreach($row as $k=>$v){
				$v = explode("=",$v);
				$m_rating[$v[0]] = explode(":",$v[1]);
			}

			$tc = $votes = $rate = 0;
			foreach($m_rating as $k=>$v){
				$m_rating[$k]['rate'] = $this->rateval($v[1],$v[0]);
				if($v[0]){
					$tc++;
					$rate = $rate + $v[1]/$v[0];
					$votes = $votes + $v[0];
				}
			}
			$this->row = $m_rating;
			$this->total['rate'] = $this->rateval($rate,$tc);
			$this->total['votes'] = $votes;
		}
	}

	public function ratebar($area){
		$return = "";
		if($this->row[$area][0]) $rate = round($this->row[$area][1]/$this->row[$area][0],0);
		else $rate = 0;
		for($i=1;$i<=10;$i++) $return .= "<li".(($i<=$rate)?" class=\"m-current\"":"")." title=\"{$i}\"><span>{$i}</span></li>";
		return $return;
	}
	
	public function rating($area){
		if(!$this->row[$area]['rate']) return "0.0";
		return $this->row[$area]['rate'];
	}

	public function votes($area){
		if(!$this->row[$area][0]) return 0;
		return $this->row[$area][0];
	}

	private function rateval($r,$v){
		if(!$v) return "0.0";
		$r = round($r/$v,1);
		if(intval($r)==$r) return $r.".0";
		else return $r;
	}
}
