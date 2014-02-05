<?php get_header(); ?>
    
    <div id="content" role="main">
        <?php if (have_posts()) : ?>

            <div id="pageCenter">
                <?php while (have_posts()) : the_post(); ?>
                
                    <div class="js-card container" data-permalink="<?php echo urldecode(get_permalink()) ?>" data-title="<?php bloginfo('name'); wp_title(); ?>">
                        
                        <div class="offset">
                            <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                
                            <div class="posthead">  
                                <?php matilda_post_meta() ?>
                            </div>

                            <article <?php post_class( get_article_layout_class() ) ?> id="post-<?php the_ID(); ?>">
                                
                                <div class="entry js-content">
                                    <?php the_content(); ?>
                                </div>

                            </article>
                        </div>

                    </div>
                <?php endwhile; ?>
           </div>

        <?php endif; ?>
    </div>

<?php get_footer(); ?>
