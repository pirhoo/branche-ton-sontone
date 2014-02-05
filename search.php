<?php get_header(); ?>

	<div id="content" role="main">

    <div class="container top-20">

    	<h2><?php printf( __( 'Résultats de recherche pour <em>%s</em>'), '<span>' . get_search_query() . '</span>' ); ?></h2>

      <?php if (have_posts()) : ?>

          <div id="archive" class="row">

              <?php while (have_posts()) : the_post(); ?>

                  <div class="span4 js-card top-20">

                  
                      <?php
                          // Find the image
                          if(  matilda_the_image() ) : ?>

                              <a 
                                      href="<?php the_permalink() ?>" 
                                      rel="bookmark" 
                                      title="Permanent Link to <?php the_title(); ?>">
                                  
                                  <img src="<?php echo matilda_the_image(180,180); ?>" alt="<?php the_title(); ?>" class="bottom-10 thumbnail" />

                              </a>
                      <?php   endif; ?>

                      <h3 class="title">
                          <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
                      </h3>       

                      <div class="posthead">  
                          <abbr title="<?php the_time('l j F Y') ?> à <?php the_time() ?>"><?php echo get_pretty_date(); ?></abbr> par <?php the_author_posts_link(); ?>
                      </div>

                      <div class="tj">
                          <?php the_excerpt(); ?> 
                      </div>

                  </div>

              <?php endwhile; ?>
          </div>


          <div class="navigation">
              <?php
                  if(function_exists('wp_pagenavi')): wp_pagenavi(); 
                  else: ?>
                      <div class="right"><?php next_posts_link('Articles plus anciens &raquo;') ?></div>
                      <div class="left"><?php previous_posts_link('&laquo; Articles plus récents') ?></div>
              <?php   endif; ?>
          </div>

      	<?php  endif; ?>

	    </div>

	</div>

<?php get_footer(); ?>
 

