<?php get_header(); ?>

	<!-- index.php -->

	<?php if( is_home() || is_single() ) query_posts(  $wp_query->query + array("posts_per_page" => 1) ); ?>

	<div id="content" role="main">

		<?php if (have_posts()) : ?>

      <div id="pageCenter">

				<div id="pageSlide" class="swiper-container">
				    <div class="js-wrapper swiper-wrapper">

						<?php while (have_posts()) : the_post(); ?>

							<div class="js-card swiper-slide container" data-permalink="<?php echo urldecode(get_permalink()) ?>" data-title="<?php bloginfo('name'); wp_title(); ?>">

								<div class="offset">

									<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>

									<div class="posthead">
										<?php matilda_post_meta() ?>
									</div>

									<div class="row">

										<?php matilda_chronique_block(); ?>


										<?php
											// MP3 must show the comments block
											// at the right of the article,
											// just bellow the thumbnail.
											if( is_mp3_layout() ) : ?>

												<div class="span6 pull-right">

													<div class="span6">
														<img src="<?= matilda_the_image(280, 280, $post, true); ?>" alt="" class="thumbnail top-20 bottom-20 left-10" />
													</div>

													<?php
														// Hack to show the comment's template on the homepage
														$withcomments = "1";
														// Comments block
														comments_template();
													?>

												</div>

										<?php endif; ?>

										<article <?php post_class( get_article_layout_class() ) ?> id="post-<?php the_ID(); ?>">

											<div class="entry js-content">
												<?php the_content(); ?>
											</div>

										</article>

									</div>


									<div class="row top-40">

										<div class="span6">

											<div class="author bottom-20">
												<?php
													$userId = get_the_author_meta('ID');
													$site = get_the_author_url();
													$twitter = get_the_author_meta('twitter', $userId);
													$twitter = str_replace("@", "", $twitter );
												?>
												<div class="pull-left">
													<?php echo get_avatar($userId, 60 ); ?>
												</div>

												<div class="top-10 left-80">
													<h3><?php the_author_posts_link(); ?></h3>

													<?php if( $site ) : ?>
														<a href="<?=$site?>" target="_blank" class="site right-10"><i class="icon icon-globe"></i> son site</a>
													<?php endif; ?>

													<?php if( $twitter ) : ?>
														<a href="http://twitter.com/<?=$twitter?>" target="_blank" class="site"><i class="icon icon-comment"></i> son twitter</a><br />
													<?php endif; ?>

												</div>


											</div>

							                <ul class="unstyled span6 social-buttons">
							                    <li class="pull-left right-10">
							                        <a href="http://twitter.com/share" class="socialite twitter-share" data-count="vertical" data-via="tonsonotone" rel="nofollow"  data-url="<?=get_permalink(); ?>"  target="_blank">
							                            <span>Share on Twitter</span>
							                        </a>
							                    </li>
							                    <li class="pull-left right-10">
							                        <a href="https://plusone.google.com/_/+1/confirm?hl=en&amp;url=http://socialitejs.com" class="socialite googleplus-one" data-size="tall" rel="nofollow"  data-url="<?=get_permalink(); ?>"  target="_blank">
							                            <span>Share on Google+</span>
							                        </a>
							                    </li>
							                    <li class="pull-left right-10">
							                        <a class="socialite facebook-like" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false" rel="nofollow"  data-href="<?=get_permalink(); ?>"  target="_blank">
							                            <span>Share on Facebook</span>
							                        </a>
							                    </li>
							                </ul>

										</div>

										<?php
											if( ! is_mp3_layout() ) :
												// Hack to show the comment's template on the homepage
												$withcomments = "1";
												// Comments block
												comments_template();
											endif;
										?>

				             		</div>

									<?php /* Do not remove that element that allow Javascript to find the next link */ ?>
									<div class="js-navigation">
										<?php if( is_single() ) : ?>
											<div class="alignright previous"><?php next_post_link('%link','Article plus ancien &raquo;') ?></div>
											<div class="alignleft next"><?php previous_post_link('%link', '&laquo; Article plus récent') ?></div>
										<?php else: ?>
											<div class="alignright next"><?php next_posts_link('Articles plus anciens &raquo;') ?></div>
											<div class="alignleft previous"><?php previous_posts_link('&laquo; Articles plus récents') ?></div>
										<?php endif; ?>
									</div>

								</div>
							</div>

						<?php endwhile; ?>

				 	</div>
				</div>

				<div class="js-loader-overlay hide">
					<div class="container row">
						<div class="progress span8 offset2 progress-striped progress-danger active">
		              		<div class="bar" style="width: 0%;"></div>
		          		</div>
	        		</div>
	        	</div>
			</div>

		<?php endif; ?>
	</div>

<?php get_footer(); ?>
