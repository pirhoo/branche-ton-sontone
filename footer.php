


        <footer>
            <div class="container">
                <div class="row">
                    <div class="span5">
                        <h3>Branche Ton Sonotone</h3>
                        <ul class="unstyled">
                            <li><a href="http://twitter.com/tonsonotone">Dans ton Twitter</a></li>
                            <li><a href="http://www.facebook.com/branchetonsonotone">Dans ton Facebook</a></li>
                            <li><a href="http://feeds2.feedburner.com/branchetonsonotone">Dans ton flux</a></li>
                            <li class="input-append input-prepend top-10">
                                <form action="http://feedburner.google.com/fb/a/mailverify" method="POST">
                                    <input type="hidden" value="branchetonsonotone" name="uri">
                                    <input type="hidden" value="fr_FR" name="loc">
                                    <span class="add-on">@</span><input name="email" type="text" placeholder="Dans tes emails" class="span2" /><button type="submit" class="btn btn-danger">S'abonner</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="span3">
                        <h3>À propos de nous</h3>
                        <ul class="unstyled">
                            <li><a href="/a-propos">Nous connaitre</a></li>
                            <li><a href="/contact">Nous contacter</a></li>
                            <li><a href="/sabonner">Nous suivre</a></li>
                            <li><a href="/participer">Nous rejoindre</a></li>
                        </ul>
                    </div>
                    <div class="span4 tr">
                        <h3>À propos des contenus</h3>
                        <p>Les articles sur ce site sont placés sous <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/">licence Creative Common</a>. Les vidéos et musiques demeurent la propriété exclusive de leur auteur.</p>
                        <p>Ce site est fièrement propulsé par <a href="http://wordpress.org/">Wordpress</a> et bricolé par <a href="http://pirhoo.com">Pirhoo</a>.
                    </div>
                </div>
            </div>
        </footer>


        <div class="js-loader-overlay js-template">
            <div class="container row">
                <div class="progress span8 offset2 progress-striped progress-danger active">
                    <div class="bar" style="width: 100%;"></div>
                </div>
            </div>
        </div>


        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.imagesloaded.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery-css-transform.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/underscore-min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/bootstrap/bootstrap.min.js" type="text/javascript"></script>

        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.history.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.scrollTo-min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.columnizer.min.js"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.placeholder.min.js"></script>

        <script src="<?php bloginfo('template_url'); ?>/core/js/Modernizr.class.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/idangerous.swiper-1.9.1.min.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/Socialite.class.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/functions.utils.js" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/slide.js?v=<?=THEME_VERSION?>" type="text/javascript"></script>
        <script src="<?php bloginfo('template_url'); ?>/core/js/global.js?v=<?=THEME_VERSION?>" type="text/javascript"></script>

        <?php if( is_archive() || is_author() || is_search() || is_page() ): ?>
            <script src="<?php bloginfo('template_url'); ?>/core/js/jquery/jquery.isotope.min.js?v=<?=THEME_VERSION?>"></script>
            <script src="<?php bloginfo('template_url'); ?>/core/js/archive.js?v=<?=THEME_VERSION?>"></script>
        <?php endif; ?>

        <script>
            var _gaq=[['_setAccount','UA-8865740-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

	</body>

</html>