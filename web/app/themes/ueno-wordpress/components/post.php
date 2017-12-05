<?php
$date = get_the_date();
$title = get_the_title();
$post = get_post();
$blurb = get_the_excerpt();
$content = apply_filters('the_content', get_the_content());
$link = get_permalink();
$tags = get_the_tags();
?>
<div class="blog">
  <div class="blog__date"><?php echo $date; ?></div>
  <h3 class="blog__title">
    <a href="<?php echo $link; ?>">
      <?php echo $title; ?>!
    </a>
  </h3>
  <div class="blog__main">
    <div class="blog__blurb"><?php echo $blurb; ?></div>
  </div>
</div>
