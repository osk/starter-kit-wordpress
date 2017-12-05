<?php get_header(); ?>

<?php
while (have_posts()):
  the_post();
  $date = get_the_date();
  $headline = get_the_title();
  $content = apply_filters('the_content', get_the_content());
  $tags = get_the_tags();
?>

<div class="blog">
  <span class="blog__date"><?php echo $date; ?></span>
  <h1 class="blog__headline"><?php echo $headline; ?></h1>
  <div class="blog__content"><?php echo $content; ?></div>
  <ul class="blog__tags">
    <?php
    if ($tags):
      foreach ($tags as $tag):
        $tag_text = $tag->name;
        $tag_link = '/tag/'.$tag->slug;
    ?>
        <li class="blog__tag">
          <a href="<?php echo $tag_link; ?>">
            <?php echo $tag_text; ?>
          </a>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </ul>
  </div>
</div>

<?php
endwhile;
get_footer();
