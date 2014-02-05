<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 */
?>
	<div class="span6"  id="comments">

		<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyeleven' ); ?></p>
			</div><!-- #comments -->
		<?php
				/* Stop the rest of comments.php from being processed,
				 * but don't kill the script entirely -- we still have
				 * to fully load the template.
				 */
				return;
			endif;
		?>

		<?php if( comments_open() ) : ?>

			<div class="span6">

				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="commentform">
					
					<?php if (!$user_ID) : ?>

						<div class="inputs form-horizontal"> 

							<div class="">
								<label class="hide" for="author">Pseudo*</label>
								<div class="">
									<input type="text" name="author" id="author" placeholder="Pseudo*" value="<?php echo $comment_author; ?>" class="text span5"/>
								</div>
							</div>

							 <div class="">
								<label class="hide" for="email">E-mail*</label>
								<div class="">
									<input type="text" name="email" id="email" placeholder="E-mail*" value="<?php echo $comment_author_email; ?>" class="text span5" />
								</div>
							</div>

							 <div class="">
								<label class="hide" for="url">Site web</label>
								<div class="">
									<input type="text" name="url" id="url" placeholder="Site web" value="<?php echo $comment_author_url; ?>" class="text span5" />
								</div>
							</div>

						</div> <!-- fin du div inputs -->

		      <?php else: ?>

            <div class="inputs">
                Tu es connecté en tant que <strong><?php echo $user_identity; ?></strong>. Tu n'es pas <?php echo $user_identity; ?> ? <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout">Te déconnecter!</a>
            </div>

					<?php endif; ?>

          <div class="inputs">
						<textarea name="comment" class="span5" placeholder="Votre commentaire ici..." rows="3" id="comment-content"></textarea>
					</div>

					<div class="submit" style="clear:both">

						<input name="submit" class="btn btn-danger" type="submit" value="Ouuuh yeah." />

            <?php do_action('comment_form', $post->ID); ?>

						<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
					</div>

				</form>
			</div>

		<?php endif; ?>

		<?php if ( have_comments() ) : ?>			

			<div class="span6">
				<div class="comments-list">

					<h4 id="comments-title">
						<?php comments_number('0 commentaire', '1 commentaire', '% commentaires' );?>
					</h4>

					<ol class="commentlist unstyled">
						<?php
							/* Loop through and list the comments. Tell wp_list_comments() */
							wp_list_comments('callback=matilda_comment');
						?>
					</ol>

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
						<nav id="comment-nav-below">
							<h1 class="assistive-text"><?php _e( 'Comment navigation'); ?></h1>
							<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments') ); ?></div>
							<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;') ); ?></div>
						</nav>
					<?php endif; // check for comment navigation ?>

				</div>
			</div>

			<?php
				/* If there are no comments and comments are closed, let's leave a little note, shall we?
				 * But we don't want the note on pages or post types that do not support comments.
				 */
				elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
					<div class="span6 comments-list">
						<p class="nocomments"><?php _e( 'Comments are closed.'); ?></p>
					</div>					
			<?php endif; ?>

	</div><!-- #comments -->
