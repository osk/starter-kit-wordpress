<?php
get_header();
$headline = single_tag_title('', false);
?>

<main>
  <h1><?php echo $headline; ?></h1>
  <div class="posts">
    <?php
    while (have_posts()) {
      the_post();
      include 'components/post.php';
    }
    ?>
  </div>
</main>

<?php get_footer(); ?>
