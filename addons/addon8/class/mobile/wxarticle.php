<?php
		$member = get_member_account(false);
		$op = empty($_GP['op']) ? 'display' : $_GP['op'];
		if($op == 'display'){
			include addons_page('wx_article_list_search');
		}

  	 	 