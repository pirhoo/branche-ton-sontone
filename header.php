<!DOCTYPE html public "⚛">
<!--[if lt IE 7]> <html lang="en-us" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="en-us" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="en-us" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us" class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
        <meta name="viewport" content="width=960,  user-scalable=yes, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />


		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="verify-v1" content="ZsF5T0pWVjp0yFtBBoP4XudVDiJBX9EkN69Ys6JXdbY=" />
		<meta name="google-site-verification" content="7Co0cOKWkdVUBmB9DjmZXEnQhQVuKC39_Ak20_KHPks" />

		<?php matilda_facebook_like_meta(); ?>

		<title>
			<?php bloginfo('name'); wp_title(); ?>
		</title>

		<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

        <link href="<?php echo bloginfo('template_url'); ?>/core/stylesheet/css/font.css" rel="stylesheet">
        <link href="<?php echo bloginfo('template_url'); ?>/core/stylesheet/css/socialite.css" rel="stylesheet">
        <link href="<?php echo bloginfo('template_url'); ?>/core/stylesheet/css/global.css?v=<?=THEME_VERSION?>" rel="stylesheet">



		<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
		<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<link rel="icon" href="<?php echo bloginfo('template_url'); ?>/core/img/favicon.png" />
		<link rel="shortcut icon" href="<?php echo bloginfo('template_url'); ?>/core/img/favicon.png" />
		<link rel="apple-touch-icon" href="<?php echo bloginfo('template_url'); ?>/core/img/mg_apple.png"/>


		<?php wp_head();?>
	</head>
	<body>

        <div class="top-banner">
            <div class="overflow">
                <img src="<?php echo bloginfo('template_url'); ?>/core/img/banner-<?= rand(1,2) ?>.png" />
            </div>
        </div>

        <div dir="ltr">

            <header class="container">
                <a href="<?php bloginfo("home"); ?>">
                    <img class="logo" src="<?php bloginfo('template_url'); ?>/core/img/mg.png" />
                </a>
                <h1 class="top-40">Branche Ton Sonotone</h1>
                <p>Le Webzine qui t'aide à pécho en te donnant une super culture musicale</p>
            </header>

            <div class="main-nav">
                <div class="wrapper">
                    <div class="links pull-left" id="categories" data-toggle="buttons-radio">

                        <a href="<?php bloginfo("home"); ?>" class="link hp" title="La page d'accueil">
                            <b class="icon-white icon-home"></b>
                        </a>
                        <a class="link " data-toggle="dropdown" href="#">
                            <span class="icon-question-sign icon-white"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/a-propos">Nous connaitre</a></li>
                            <li><a href="/contact">Nous contacter</a></li>
                            <li><a href="/sabonner">Nous suivre</a></li>
                            <li><a href="/participer">Nous rejoindre</a></li>
                            <li class="divider"></li>
                            <li><a href="/?random"><i class="i"></i> Un article au pif</a></li>
                        </ul>
                        <a class="link" href="#form-search"  data-toggle="modal" id="toggle-search">
                            <span class="icon-search icon-white"></span>
                        </a>

                        <a class="link toggle-category" data-categories="mp3,videos" title="Les sons et les vidéos">
                            <b class="icon-white icon-heart"></b>
                            Sons &amp; vidéos
                        </a>

                        <a class="link toggle-category" data-categories="chroniques" title="Les disques">
                            <b class="icon-white icon-headphones"></b>
                            Disques
                        </a>

                        <a class="link toggle-category" data-categories="dossiers,concerts,interviews,divers,bestof,playlits" title="Le reste">
                            <b class="icon-white icon-music"></b>
                            Concerts &amp; dossiers
                        </a>
                    </div>

                    <div class="links pull-right">
                        <a class="link" href="https://www.facebook.com/branchetonsonotone" target="_blank">
                            <img src="<?php echo bloginfo('template_url'); ?>/core/img/facebook.png" alt="facebook" />
                        </a>
                        <a class="link" href="https://twitter.com/tonsonotone" target="_blank">
                            <img src="<?php echo bloginfo('template_url'); ?>/core/img/twitter.png" alt="twitter" />
                        </a>
                    </div>

                    <div class="slider-nav">
                        <a class="previous link hidden">
                            <span class="icon-chevron-left icon-white"></span>
                            Précédent
                        </a>
                        <a class="next link hidden">
                            Suivant
                            <span class="icon-chevron-right icon-white"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div id="interspace" class="hide first">
            <!-- Show a topic dynamicly-->
            <div class="wrapper">

            </div>
            <a title="Page précédent" class="previous-page"></a>
            <a title="Page suivante" class="next-page"></a>
        </div>

        <script type="text/template" id="tpl-interspace-list">
            <% _.each(posts, function(post) { %>
                <a href="<%= post.url %>" class="js-card">
                    <% if (post.thumbnail) { %>
                        <div class="cover">
                            <img src="<%= post.thumbnail %>" alt="" />
                        </div>
                    <% } %>
                    <%= post.title %>
                </a>
            <% }); %>
        </script>


        <form class="modal hide " id="form-search" action="<?php bloginfo("home"); ?>" method="GET">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Rechercher un article</h3>
            </div>
            <div class="modal-body">
                <div class="control-group">
                    <div class="controls">
                        <p class="help-block">
                            Branche Ton Sonotone c'est <b><?= nb_posts(); ?> articles</b>, <b><?= nb_tags(); ?> tags</b> et <b><?= nb_comments(); ?> commentaires</b>...<br />
                            On s'est dit qu'on allait vous aider un peu.
                        </p>
                        <div class="input-append bottom-10">
                            <input type="text" name="s" class="text input-xlarge" id="input-search" placeholder="exemple : rock, guitare, enfant malien" /><button type="submit" class="btn btn-danger">Rechercher</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>