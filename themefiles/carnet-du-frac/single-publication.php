<?php get_mp_header(); ?>

<!-- single-publication.php : <?php echo MultiPublisher::$publicationType;?> -->

<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

<?php get_mp_publication_cover(); ?>

<?php the_content(); ?>
<?php endwhile; ?>
<?php endif; ?>

<!-- fin single-publication.php -->

<?php get_mp_footer(); ?>