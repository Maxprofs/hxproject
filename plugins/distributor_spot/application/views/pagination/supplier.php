<?php
// Number of page links in the begin and end of whole range
$count_out = (!empty($config['count_out'])) ? (int)$config['count_out'] : 3;
// Number of page links on each side of current page
$count_in = (!empty($config['count_in'])) ? (int)$config['count_in'] : 5;

// Beginning group of pages: $n1...$n2
$n1 = 1;
$n2 = min($count_out, $total_pages);

// Ending group of pages: $n7...$n8
$n7 = max(1, $total_pages - $count_out + 1);
$n8 = $total_pages;

// Middle group of pages: $n4...$n5
$n4 = max($n2 + 1, $current_page - $count_in);
$n5 = min($n7 - 1, $current_page + $count_in);
$use_middle = ($n5 >= $n4);

// Point $n3 between $n2 and $n4
$n3 = (int)(($n2 + $n4) / 2);
$use_n3 = ($use_middle && (($n4 - $n2) > 1));

// Point $n6 between $n5 and $n7
$n6 = (int)(($n5 + $n7) / 2);
$use_n6 = ($use_middle && (($n7 - $n5) > 1));

// Links to display as array(page => content)
$links = array();

// Generate links data in accordance with calculated numbers
for($i = $n1; $i <= $n2; $i++)
{
    $links[$i] = $i;
}
if($use_n3)
{
    $links[$n3] = '&hellip;';
}
for($i = $n4; $i <= $n5; $i++)
{
    $links[$i] = $i;
}
if($use_n6)
{
    $links[$n6] = '&hellip;';
}
for($i = $n7; $i <= $n8; $i++)
{
    $links[$i] = $i;
}

?>

<div class="pm-fy-page">
    <div class="main_mod_page clear">
        <p class="page_right">
            <?php if ($first_page !== FALSE): ?>
                <a class="back-first" title="首页" href="<?php echo HTML::chars($page->url($first_page)) ?>"></a>
            <?php else: ?>
                <a class="back-first" title="首页"></a>
            <?php endif ?>

            <?php if ($previous_page !== FALSE): ?>
                <a class="prev" title="上一页" href="<?php echo HTML::chars($page->url($previous_page)) ?>"></a>
            <?php else: ?>
                <a class="prev" title="上一页"></a>
            <?php endif ?>

            <span class="mod_pagenav_count">

    <?php foreach ($links as $i => $content): ?>

        <?php if ($i == $current_page): ?>
            <a title="<?php echo $i ?>" class="current"><?php echo $content ?></a>
        <?php else: ?>
            <a title="<?php echo $i ?>" href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $content ?></a>
        <?php endif ?>

    <?php endforeach ?>
		</span>

            <?php if ($next_page !== FALSE): ?>
                <a class="next"title="下一页" href="<?php echo HTML::chars($page->url($next_page)) ?>"></a>
            <?php else: ?>
                <a class="next" title="下一页"></a>
            <?php endif ?>

            <?php if ($last_page !== FALSE): ?>
                <a class="go-last" title="末页" href="<?php echo HTML::chars($page->url($last_page)) ?>"></a>
            <?php else: ?>
                <a class="go-last" title="末页"></a>
            <?php endif ?>
        </p>
    </div><!-- 翻页 -->
</div>
<div class="page-text ml-20"><p>总共 <span class="color-red"><?php echo $total_pages; ?></span> 页,共 <span class="color-red"><?php echo $total_items; ?></span> 条记录</p></div>
<div class="show-num ml-20">
    每页显示数量：
    <form method="get" id="pagefrm" style="display: inline-block">
        <select name="pagesize" onchange="submitfrm();">
            <option value="30" <?php if ($items_per_page == 30): ?>selected="selected" <?php endif ?>>30</option>
            <option value="40" <?php if ($items_per_page == 40): ?>selected="selected" <?php endif ?>>40</option>
            <option value="50" <?php if ($items_per_page == 50): ?>selected="selected" <?php endif ?>>50</option>
            <option value="60" <?php if ($items_per_page == 60): ?>selected="selected" <?php endif ?>>60</option>
        </select>
    </form>
</div>
<script>
    function submitfrm(){
        var f=document.getElementById('pagefrm');
        f.submit();
    }

</script>
