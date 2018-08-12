<?php
/**
 * Single Portfolio Template
 *
 *
 * @file           single-portfolio.php
 * @package        StanleyWP
 * @author         Brad WIlliams
 * @copyright      2003 - 2014 Gents Themes
 * @license        license.txt
 * @version        Release: 3.0.3
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>

<div id="content-project">

 <?php if (have_posts()) : ?>

 <?php while (have_posts()) : the_post(); ?>


 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

  <!-- Portfolio Section -->
  <div class="container pt">
    <div class="row mt">
     <div class="col-lg-6 col-lg-offset-3 centered">

      <?php if( rwmb_meta( 'wtf_portfolio_top_title' ) !== '' ) { ?>
      <?php echo rwmb_meta( 'wtf_portfolio_top_title' ); ?>
      <hr>
      <?php } ?>

      <?php the_content(); ?>

    </div>
  </div><!-- row -->

  <div class="row mt centered">
    <div class="col-lg-8 col-lg-offset-2">
      <?php
      $images = rwmb_meta( 'thickbox', 'type=image' );
      foreach ( $images as $image ) {
        echo "<p><img class='img-responsive' src='{$image['full_url']}' alt='{$image['alt']}' /></p>";
      } ?>
      <?php if(rwmb_meta('wtf_port_cats') == 'value1') {?>
      <p><bt><?php _e('Tipo','gents'); ?>: </span><?php echo get_the_term_list( get_the_ID(), 'portfolio_cats', '',', ',' ') ?></bt></p>
       <?php } ?>
    </div><!-- col-lg-8 -->
  </div>
</div><!-- container -->
</article><!-- end of #post-<?php the_ID(); ?> -->


<?php endwhile; ?>

<?php else : ?>

  <div class="container">
   <article id="post-not-found" class="hentry clearfix">
    <header>
     <h1 class="title-404"><?php _e('404 - ¡Me encantaría conocerte!', 'gents'); ?></h1>
   </header>
   <section>
     <p><?php _e('No entre en pánico, lo superaremos juntos. Exploremos nuestras opciones aquí.', 'gents'); ?></p>
   </section>
   <footer>
     <h6><?php _e( 'Puedes regresar', 'gents' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Inicio', 'gents' ); ?>"><?php _e( '&#9166; Inicio', 'gents' ); ?></a> <?php _e( 'o busca la página que estabas buscando', 'gents' ); ?></h6>
     <?php get_search_form(); ?>
   </footer>

 </article>
</div>

<?php endif; ?>

</div><!-- end of #content -->


<?php get_footer(); ?>
