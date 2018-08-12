<?php
/**
 * Contact
 *
   Template Name:  Contact Page
 *
 * @file           template-contact.php
 * @package        StanleyWP
 * @author         Brad Williams & Carlos Alvarez
 * @copyright      2014 Gents Themes
 * @license        license.txt
 * @version        Release: 3.0.3
 * @link           http://codex.wordpress.org/Theme_Development#Pages_.28page.php.29
 * @since          available since Release 1.0
 */
   ?>

   <?php
   if(isset($_POST['submitted'])) {
    if(trim($_POST['contactName']) === '') {
        $nameError = 'Por favor, escriba su nombre.';
        $hasError = true;
    } else {
        $name = trim($_POST['contactName']);
    }

    if(trim($_POST['email']) === '')  {
        $emailError = 'Por favor, introduzca su dirección de correo electrónico.';
        $hasError = true;
    } else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
        $emailError = 'Ha introducido una dirección de correo inválida.';
        $hasError = true;
    } else {
        $email = trim($_POST['email']);
    }

    if(trim($_POST['comments']) === '') {
          $commentError = 'Por favor ingrese un mensaje.';
        $hasError = true;
    } else {
        if(function_exists('stripslashes')) {
            $comments = stripslashes(trim($_POST['comments']));
        } else {
            $comments = trim($_POST['comments']);
        }
    }

    if(!isset($hasError)) {
        $emailTo = get_option('tz_email');
        if (!isset($emailTo) || ($emailTo == '') ){
            $emailTo = get_option('admin_email');
        }
        $subject = '[Nac Abarca] From '.$name;
        $body = "Nombre: $name \n\Correo: $email \n\Comentarios: $comments";
        $headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

        wp_mail($emailTo, $subject, $body, $headers);
        $emailSent = true;
    }

} ?>

<?php get_header(); ?>


<div class="container pt">


        <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>


        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


                <div class="row mt">
            <div class="col-lg-6 col-lg-offset-3 centered">

                   <header>
            <h3><?php the_title(); ?></h3>
          </header>
                <hr>
                <?php the_content(); ?>
            </div>
        </div>

            <section class="post-entry">

                <div class="row mt">
            <div class="col-lg-8 col-lg-offset-2">

             <?php if(isset($emailSent) && $emailSent == true) { ?>
             <div class="alert alert-success">
                <p>Muchas Gracias, su correo electrónico fue enviado con éxito.</p>
            </div>
            <?php } else { ?>

            <?php if(isset($hasError) || isset($captchaError)) { ?>
            <div class="alert alert-danger alert-dismissable">
                <a class="close" data-dismiss="alert">×</a>
                <h4 class="alert-heading">Disculpe, ocurrió un error.</h4>
                <p class="error">¡Inténtalo de nuevo!<p>
                </div>
                <?php } ?>

                <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
                    <fieldset>
                        <div class="form-group">

                            <input class="form-control" type="text" name="contactName" id="contactName" value="" placeholder="Ingrese con su nombre" />
                            <span class="input-icon fui-check-inverted"></span>
                            <?php if(isset($nameError)) { ?>
                            <p><span class="error"><?=$nameError;?></span></p>
                            <?php } ?>
                             <br>

                        </div>
                        <div class="form-group">

                            <input class="form-control" type="text" name="email" id="email" value="" placeholder="Ingrese con su correo" />
                            <span class="input-icon fui-check-inverted"></span>
                            <?php if(isset($emailError)) { ?>
                            <p><span class="error"><?=$emailError;?></span></p>
                            <?php } ?>

                             <br>
                        </div>
                        <div class="form-group">

                            <textarea class="form-control" name="comments" id="commentsText" rows="10" cols="20" placeholder="Ingrese con su comentario"></textarea>
                            <?php if(isset($commentError)) { ?>
                            <p><span class="error"><?=$commentError;?></span></p>
                            <?php } ?>
                             <br>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </div>
                        <input type="hidden" name="submitted" id="submitted" value="true" />
                    </fieldset>
                </form>
                <?php } ?>

                </div>
        </div><!-- /row -->

            </section><!-- end of .post-entry -->

        </article><!-- end of #post-<?php the_ID(); ?> -->

</div><!-- container -->



<?php endwhile; ?>

<?php if (  $wp_query->max_num_pages > 1 ) : ?>
    <nav class="navigation">
       <div class="previous"><?php next_posts_link( __( '&#8249; Publicaciones más antiguas', 'gents' ) ); ?></div>
       <div class="next"><?php previous_posts_link( __( 'Publicaciones más nuevas &#8250;', 'gents' ) ); ?></div>
   </nav><!-- end of .navigation -->
<?php endif; ?>

<?php else : ?>

    <article id="post-not-found" class="hentry clearfix">
        <header>
           <h1 class="title-404"><?php _e('404 &#8212; ¡Fantasía conocerte aquí!', 'gents'); ?></h1>
       </header>
       <section>
           <p><?php _e('No entre en pánico, lo superaremos juntos. Exploremos nuestras opciones aquí.', 'gents'); ?></p>
       </section>
       <footer>
           <h6><?php _e( 'Puedes regresar', 'gents' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Initio', 'gents' ); ?>"><?php _e( '&#9166; Inicio', 'gents' ); ?></a> <?php _e( 'o busque la página que estaba buscando', 'gents' ); ?></h6>
           <?php get_search_form(); ?>
       </footer>

   </article>

<?php endif; ?>



<?php get_footer(); ?>
