<?php
namespace home\controller;

class games extends \home\controller\base
{
	public function index()
	{
		$_GP = $this->request;
		$seting  = globaSetting();
		$self_qq = getQQ_onWork($seting);

		//获取所有的游戏币
		$dish_json = '';
		$allDish   = mysqld_selectall("select title,id,content,marketprice from ".table('shop_dish')." where status = 1 and  deleted =0 ");
		foreach($allDish as &$one){
			$one['total_number'] = mysqld_selectcolumn("select count(id) from ".table('dish_number')." where dish_id={$one['id']} and is_used=0");
		}
		$dish_json = json_encode($allDish);

		//记住当前
		to_member_loginfromurl();
		include themePage('games');
	}
}