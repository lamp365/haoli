<?php
      $pindex = max(1, intval($_GP['page']));
      $psize = 30;
      $condition='';
      $conditiondata=array();
	  $mess_list = array();

    if(!empty($_GP['timestart']) && !empty($_GP['timeend'])){
        $timestart = strtotime($_GP['timestart']);
        $timeend   = strtotime($_GP['timeend']);
        $condition .= " AND createtime >= {$timestart} And createtime<= {$timeend}";
    }
      if(!empty($_GP['nickname']))
      {
      	
      	 $condition=$condition.' and nickname like :nickname ';
      	 $conditiondata[':nickname']='%'.trim($_GP['nickname']).'%';
      }
      if(!empty($_GP['mobile']))
      {
      	 $condition=$condition.' and mobile like :mobile ';
      	 $conditiondata[':mobile']= '%'.trim($_GP['mobile']).'%';
      }



       if(!empty($_GP['weixinname']))
      {
      	
      	 $condition=$condition.' and openid in (select wxfans.openid from ' . table('weixin_wxfans').' wxfans where wxfans.nickname like :weixinname)';
      	 $conditiondata[':weixinname']='%'.$_GP['weixinname'].'%';
      }

      $status=1;
      if(empty($_GP['showstatus'])||$_GP['showstatus']==1)
      {
      	
      	 $status=1;
      }
     
         if($_GP['showstatus']==-1)
      {
      	
      	 $status=0;
      }
      if(!empty($_GP['rank_level']))
      {
          $rank_model = mysqld_select("SELECT * FROM " . table('rank_model')."where rank_level=".intval($_GP['rank_level']) );
          if(!empty($rank_model['rank_level']))
          {
                $condition=$condition." and experience>=".$rank_model['experience'];
                $rank_model2 = mysqld_select("SELECT * FROM " . table('rank_model')."where rank_level>".$rank_model['rank_level'].' order  by rank_level limit 1' );
                if(!empty($rank_model2['rank_level']))
                {
                    if(intval($rank_model['experience'])<intval($rank_model2['experience']))
                    {
                        $condition=$condition." and experience<".$rank_model2['experience'];
                    }
                }
          }
      }
      $rank_model_list = mysqld_selectall("SELECT * FROM " . table('rank_model')." order by rank_level" );
	  $list  = mysqld_selectall('SELECT * FROM '.table('member')." where  dummy=0 and `istemplate`=0  and `status`={$status} {$condition} "." LIMIT " . ($pindex - 1) * $psize . ',' . $psize,$conditiondata);
      $total = mysqld_selectcolumn('SELECT COUNT(*) FROM ' . table('member')." where  dummy=0 and `istemplate`=0 {$condition} ",$conditiondata);
      $pager = pagination($total, $pindex, $psize);
      
        foreach($list as  $index=>$item){
             $list[$index]['weixin']= mysqld_selectall("SELECT * FROM " . table('weixin_wxfans') . " WHERE openid = :openid", array(':openid' => $item['openid']));
        }


            //获取角色
            $rolers   = mysqld_select("select id,name,createtime from ".table('rolers')." where type=1 and isdelete=0");

            //获取业务员
            $user_rolers  = '';
            if(!empty($rolers)){
                $sql = "select r.id,r.rolers_id,r.uid,u.username from ".table('rolers_relation')." as r ";
                $sql .= " left join ".table('user')." as u on u.id=r.uid where r.rolers_id={$rolers['id']}";
                $user_rolers = mysqld_selectall($sql);
            }

            //获取会员身份 如渠道商    这些信息 用在添加会员时的 下拉选择
            $purchase = mysqld_selectall("select id,pid,name,createtime from ".table('rolers')." where type<>1 order by pid asc");
            if (! empty($purchase)) {
                $childrens = '';
                foreach ($purchase as $key => $item) {
                    if (! empty($item['pid'])) {
                        $childrens[$item['pid']][$item['id']] = $item;
                        unset($purchase[$key]);
                    }
                }
            }

			include page('list');