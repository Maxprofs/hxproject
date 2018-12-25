
<!--左侧导航区-->
  	<div class="menu-left">
    	<div class="global_nav">
        <div class="kj_tit">供应商设置</div>
      </div>
      <div class="nav-tab-a leftnav">

        <?php
        $supplier_menu = DB::select()->from('menu_new')->where('level', '=', '2')->and_where('title', '=', '供应商设置')->execute()->current();
        $menu = Model_Menu_New::get_left_nav($supplier_menu['id']);
        if (!empty($menu))
        {
            foreach (Model_Menu_New::get_config_by_id($menu['child_id'], 1) as $row)
            {

                $class = $row['displayorder'] == $itemid ? " class='active' " : '';
                $data_url = empty($class) ? ' data-url="' . $row['url'] . '" ' : '';
                $alias_title = isset($row['alias_title']) ? ' data_title="' . $row['alias_title'] . '" ' : '';
                echo '<a href="javascript:;"' . $class . $data_url .$alias_title. '>' . $row['title'].'</a>';
            }

          }
        ?>

      </div>
    </div>
		<script>
         $(document).ready(function(e) {
                //导航点击
                $(".leftnav").find('a').click(function(){
                    var url= $(this).attr('data-url');
                    var title = $(this).html();
                    ST.Util.addTab(title,url);
                })
         })
       </script>