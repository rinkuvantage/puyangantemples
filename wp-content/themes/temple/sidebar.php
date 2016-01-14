<div class="left_sidebar">
    <div class="srch_box">
	  <?php get_search_form(); ?>
      
    </div>
    <div class="all_temple">
      <h1>Temples</h1>
      <ul class="left_ul">
        <li><a href="<?php echo get_option('home'); ?>/ten-temples">To visit the temples of ten</a></li>
        <li><a href="<?php echo get_option('home'); ?>/star-temples">Star temples</a></li>
		<?php $categories=Categorydetail(''," order by id asc");
		if(count($categories)>0){
			foreach($categories as $category){ ?>
			<li><a href="<?php echo get_option('home'); ?>/category-temples/?cid=<?php echo $category->id; ?>"><?php _e($category->category); if($category->showcount=='1'){ $totaltemple=totalcategorytemples($category->id); if($totaltemple>0){echo' ('.$totaltemple.')';}} ?> </a></li>
			<?php }
		}
		 ?>
      </ul>
    </div>
    <?php /*?><div class="all_temple">
      <h1>Worship</h1>
      <ul class="left_ul">
        <li><a href="#">Mantras (Slocum)</a></li>
        <li><a href="#">Bama Murugan</a></li>
      </ul>
    </div>
    <div class="all_temple">
      <h1>Shiv Tips</h1>
      <ul class="left_ul">
        <li><a href="#">Akamakurippukal Shiva!</a></li>
        <li><a href="#">Ecclesiasticus orders kamika</a></li>
        <li><a href="#">64 Shiv formats </a></li>
        <li><a href="#">64 miracle</a></li>
      </ul>
    </div>
    
    <div class="all_temple">
      <h1>Spiritual elders</h1>
      <ul class="left_ul">
        <li><a href="#">63 Nayanmars</a></li>
        <li><a href="#">12 Alwar</a></li>
        <li><a href="#">Siddha</a></li>
        <li><a href="#">Rishis</a></li>
        <li><a href="#">More</a></li>
      </ul>
    </div><?php */?>
  </div>