<?php get_header(); ?>

<div id="content">

    <div class="container top-20">

        <?php
            $curauth = get_userdata(intval($author));
        ?>

        <div id="author" class="row">

            <div class="span8 tj">

                <h2 class="bottom-20"><?php wp_title(''); ?></h2>

                <?php if( get_the_author_meta('description', $curauth->ID) ): ?>
                    <p><?= nl2br(get_the_author_meta('description', $curauth->ID)); ?></p>
                <?php endif; ?>

                <?php if( get_user_meta($curauth->ID, "favorite-groups") ): ?>
                    <p><b>Groupes préférés</b> : <?=nl2br(get_user_meta($curauth->ID, "favorite-groups", true))?></p>
                <?php endif; ?>

                <?php if( get_user_meta($curauth->ID, "hobbies") ): ?>
                    <p><b>Passions dans la vie</b> : <?=nl2br(get_user_meta($curauth->ID, "hobbies", true))?></p>
                <?php endif; ?>

                <?php if( get_user_meta($curauth->ID, "devise") ): ?>
                    <p><b>Une devise</b> : <?=nl2br(get_user_meta($curauth->ID, "devise", true))?></p>
                <?php endif; ?>
            </div>


            <div class="span3 offset1 tr">

                <?php echo get_avatar($curauth->user_email, '120'); ?>      

                <ul class="unstyled">
                    <?php if( $curauth->user_url ): ?>
                        <li>
                            <strong>
                                <a href="<?php echo $curauth->user_url; ?>"><?php echo str_replace("http://", "", $curauth->user_url); ?></a>
                            </strong>
                        </li>
                    <?php endif; ?>

                    <?php 
                        $twitter = get_the_author_meta('twitter', $curauth->ID);
                        $twitter = str_replace("@", "", $twitter );
                    ?>

                    <?php if ($twitter) : ?>
                        <li>
                            <a href="http://twitter.com/<?=$twitter?>">Son twitter</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="http://branchetonsonotone.com/feed/?author=<? echo $curauth->ID; ?>">Son flux RSS</a>
                    </li>
                </ul>              
            </div>
        </div>  


        <?php if (have_posts()) : ?>
                
            <h2 class="top-20"><?php the_author_posts(); ?> <?php echo _n("article publié par", "articles publiés par", get_the_author_posts() ); ?>  <?php wp_title(''); ?></h2>
        
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
 

