<?php $url='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$urlencode=urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>	

<div class="clr ml10">
    <form name="uslang" action="<?php echo urldecode($urlencode); ?>" method="post" class="fl">
        <input type="submit" value="" name="submit" style="background:url(<?php echo bloginfo('template_url');?>/images/us.png) no-repeat; cursor:pointer; border:none; width:30px; height:20px;" />
    </form>
    <form name="jlang" action="http://translate.google.com/translate?u=<?php echo urldecode($urlencode); ?>&amp;langpair=en|ja" method="post" class="fl">
        <input type="submit" value="" name="submit" style="background:url(<?php echo bloginfo('template_url');?>/images/ja.png) no-repeat; border:none; cursor:pointer; width:30px; height:20px; margin:0px 5px;" />
    </form>
    <form name="zhlang" action="http://translate.google.com/translate?u=<?php echo urldecode($urlencode); ?>&amp;langpair=en|zh-CN" method="post" class="fl">
        <input type="submit" value="" name="submit" style="background:url(<?php echo bloginfo('template_url');?>/images/zh.png) no-repeat; border:none; cursor:pointer; width:30px; height:20px; margin:0px 5px;" />
    </form>
    <form name="eslang" action="http://translate.google.com/translate?u=<?php echo urldecode($urlencode); ?>&amp;langpair=en|es" method="post" class="fl">
        <input type="submit" value="" name="submit" style="background:url(<?php echo bloginfo('template_url');?>/images/es.png) no-repeat; border:none; cursor:pointer; width:30px; height:20px; margin:0px 5px;" />
    
    </form>
    <form name="kolang" action="http://translate.google.com/translate?u=<?php echo urldecode($urlencode); ?>&amp;langpair=en|ko" method="post" class="fl">
        <input type="submit" value="" name="submit" style="background:url(<?php echo bloginfo('template_url');?>/images/ko.png) no-repeat; border:none; cursor:pointer; width:30px; height:20px;" />
    </form>
</div>
<div class="clr">&nbsp;</div>