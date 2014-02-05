<?php get_header(); ?>

<div id="content">
  <div id="pageCenter">
		<div class="container">

			<?php if (have_posts()) : ?>

				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

				<?php /* If this is a category archive */ if (is_category()) { ?>

					<?php get_category($categorie) ?> 
						
					<?php if(is_category(6)) { ?>
							<h2 class="top-20">Toutes les <?php single_cat_title(); ?> bien fraîches !</h2><!--news-->
						
					<?php } else if(is_category(3)) { ?>

							<h2 class="top-20">Toutes les bonnes <?php single_cat_title(); ?> qu'on a pondu !</h2> <!--chro-->
						
					<?php } else if(is_category(4)) { ?>

							<h2 class="top-20">Tous les <?php single_cat_title(); ?> où on est allé !</h2><!--conc-->
						
					<?php } else if(is_category(5)) { ?>

							<h2 class="top-20">Tous les <?php single_cat_title(); ?> qui tapent !</h2><!--mp3-->
						
					<?php } else if(is_category(7)) { ?>
							<h2 class="top-20">Toutes les <?php single_cat_title(); ?> qui déchirent !</h2><!--vid-->
						
					<?php } else if(is_category(8)) { ?>

							<h2 class="top-20">Tous les trucs <?php single_cat_title(); ?> (dont on savait pas quoi faire)</h2><!--div-->
						
					<?php } else if(is_category(225)) { ?>
							<h2 class="top-20">Tous les (gros) <?php single_cat_title(); ?></h2>
					
					<?php } ?>
				
					<?php if(is_category($categorie)) { echo category_description($categorie); } ?>
				
				<?php /* If this is a tagged archive */  } elseif (is_tag())    { ?>

					<h2 class="title">Articles taggués avec : <?php single_tag_title(); ?></h2>

				<?php /* If this is a daily archive */   } elseif (is_day())    { ?> 

					<h2 class="title">Publié le <?php the_time('j F Y'); ?></h2>
			
				<?php /* If this is a monthly archive */ } elseif (is_month())  { ?> 

					<h2 class="title">Archive du mois de <?php the_time('F Y'); ?></h2>
			
				<?php /* If this is a yearly archive */  } elseif (is_year()) { ?>
				
					<h2 class="title">Archive de l'année <?php the_time('Y'); ?></h2>

				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>

					<h2 class="title">Les archives</h2>

				<?php } ?>
			
				<div id="archive">

					<?php while (have_posts()) : the_post(); ?>

						<div class="js-card top-20">
						
							<?php
								// Find the image
								if(  matilda_the_image() ) : ?>

									<a 
											href="<?php the_permalink() ?>" 
											rel="bookmark" 
											title="Permanent Link to <?php the_title(); ?>">
										
										<img src="<?php echo matilda_the_image(180,180); ?>" alt="<?php the_title(); ?>" class="bottom-10 thumbnail" />

									</a>
							<?php	endif; ?>

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
					<?php	endif; ?>
				</div>

			<?php else: ?>
				<h2 class="title">Erreur 404 - Dans ton cul</h2>
			<?php  endif; ?>
		</div>
	</div>

</div>

<?php get_footer(); ?>
