<?php
/**
 * Template Name: about
 * @package WordPress
 * @subpackage Matilda
 */ ?>

<?php get_header(); ?>
    
    <div id="content" role="main">
        <?php if (have_posts()) : ?>

            <div id="pageCenter">
                <?php while (have_posts()) : the_post(); ?>
                
                    <div class="container" data-permalink="<?php echo urldecode(get_permalink()) ?>" data-title="<?php bloginfo('name'); wp_title(); ?>">

                        <div class="offset">
                            <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                
                            <div class="posthead">  
                                <?php matilda_post_meta() ?>
                            </div>

                            <article <?php post_class( get_article_layout_class() ) ?> id="post-<?php the_ID(); ?>">
                                
                                <div class="entry">
                                    <?php the_content(); ?>

                                    <div class="row-fluid top-20">
                                        <?php
                                            $blogusers = get_users(
                                                array(
                                                    'orderby'      => 'post_count',
                                                    'order'        => 'DESC',
                                                    'count_total'  => true,
                                                    'fields'       => 'all',
                                                    'exclude'      => array('lab'),
                                                    'who'          => 'authors'
                                                )
                                            );

                                            foreach ($blogusers as $key => $user) {
                                                if($key%3==0):
                                                    echo '<div class="span4 tc bottom-10" style="margin-left:0">'; 
                                                else:
                                                    echo '<div class="span4 tc bottom-10">'; 
                                                endif;
                                                    echo '<a href="/author/' . $user->user_nicename . '">';
                                                        echo get_avatar($user->ID, '120');
                                                        echo "<h4>" . $user->display_name . "</h4>";
                                                        echo $user->post_count;
                                                    echo '</a>';
                                                echo '</div>';
                                            }
                                        ?>
                                    </div>
                                </div>

                            </article>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>            
        <?php endif; ?>
    </div>

<?php get_footer(); ?>
