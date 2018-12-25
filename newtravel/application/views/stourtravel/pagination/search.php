<?php defined('SYSPATH') or die('No direct script access.');?>
<span class="c-999 lh-24">共<?php echo $total_items; ?>条，每页：<?php echo $items_per_page; ?>条</span>
<div class="fr ml-20" id="returnPage">
    <div name="laypage1.2" class="laypage_main laypageskin_molv" id="laypage_0">
        <?php if ($first_page !== FALSE): ?>
            <a class="laypage_first" title="首页" href="<?php echo HTML::chars($page->url(1)) ?>">首页</a>
        <?php endif ?>
        <?php if ($previous_page !== FALSE): ?>
            <a class="laypage_prev" title="上一页" href="<?php echo HTML::chars($page->url($previous_page)) ?>">«</a>
        <?php endif ?>

        <?php
        //每页显示数量
      //  $needpage = 10;
        $coefficient = floor($current_page/$needpage);
        $mod = $current_page % $needpage;
        //开始页码
        $startPage = $coefficient*$needpage+1 ;
        if($startPage==0)
        {
            $startPage = 1;
        }
        $endPage =   $coefficient*$needpage + $needpage;
        //如果endpage 大于 总页数,则取总页数
        $endPage = $endPage > $total_pages ? $total_pages : $endPage;
        ?>
        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <?php if ($i == $current_page): ?>
                <span title="<?php echo $i ?>" href="<?php echo HTML::chars($page->url($i)) ?>" class="laypage_curr"><?php echo $i ?></span>
            <?php else: ?>
                <a title="<?php echo $i ?>" href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a>
            <?php endif ?>
        <?php endfor ?>

        <?php if ($next_page !== FALSE): ?>
            <a class="laypage_next" title="下一页" href="<?php echo HTML::chars($page->url($next_page)) ?>">»</a>
        <?php endif ?>
        <?php if ($last_page !== FALSE): ?>
            <a class="laypage_last" title="最后一页" href="<?php echo HTML::chars($page->url($last_page)) ?>">尾页</a>
        <?php endif ?>

    </div>
</div>