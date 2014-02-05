<?php
/**
 * Template Name: vrac
 * @package WordPress
 * @subpackage Matilda
 */ ?>

<?php get_header(); ?>

    <div id="content" role="main" >
        <div class="container p404">
            <div class="thumbnail top-20 bottom-20">
                <img src="<?php echo bloginfo('template_url'); ?>core/img/404.png" alt="404" />
            </div>
            <div class="p404-overlay">
                <h2 class="bottom-10">Oups... Marie-George a perdu le contrôle</h2>
                <p>Vous aussi ? Pas de panique, <a href="/">retournez à l'acceuil !</a></p>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
