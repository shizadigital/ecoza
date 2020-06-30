<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="<?php echo html_lang(); ?>">

<head>
    <meta charset="UTF-8">
    
    <?php echo $web_meta; ?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>

    <?php echo the_favicon(); ?>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/bootstrap.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/font-awesome.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/elegant-icons.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/nice-select.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/jquery-ui.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/owl.carousel.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/slicknav.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo template_current_url('assets/css/style.css'); ?>" type="text/css">

    <link rel="stylesheet" href="<?php echo vendors_assets_url('flag-icon-css-master/css/flag-icon.min.css'); ?>" type="text/css">

    <!-- Load js -->
    <script src="<?php echo template_current_url('assets/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo template_current_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo template_current_url('assets/js/jquery.nice-select.min.js'); ?>"></script>
    <script src="<?php echo template_current_url('assets/js/jquery-ui.min.js'); ?>"></script>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="<?php echo base_url(); ?>"><img style="height:50px;" src="<?php echo logo_url('medium'); ?>" alt="<?php echo web_info('tagline'); ?>"></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <div class="humberger__menu__widget">

            <?php if(count(langlist())>1): ?>
            <div class="header__top__right__language">
                <?php
                $getlocale = explode("_",  t('locale') );
                $theflagcode = strtoupper( $getlocale[1] );
                ?>                                
                <div><i class="flag-icon flag-icon-<?php echo strtolower($getlocale[0]); ?>"></i> <?php echo ucwords(locales(t('locale'))); ?></div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <?php
                    foreach( langlist() AS $lv ){
                        if( $lv == t('locale') ) {
                            continue;
                        }

                        $shortname = explode("_", $lv)[0];
                        $countryName = locales($lv);

                        echo '<li><a href="'.base_url('setlang/setlang/'.$lv).'">'.strtoupper($shortname).' '.$countryName.'</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="header__top__right__auth">
                <a href="#"><i class="fa fa-user"></i> Login</a>
            </div>
        </div>
        <?php if( $this->navigation->hasMenu('1') ): ?>
        <nav class="humberger__menu__nav mobile-menu">
            <?php 
            // set menu property
            $datamenu = array(
                'openingtag' => array(
                    1 => array(
                        'tag' => 'ul',
                        'attr' => array('class'=>'menumobile'),
                    ),
                    2 => array(
                        'tag' => 'ul',
                        'attr' => array('class'=>'header__menu__dropdown'),
                    )
                ),
                'listingtag' => array(
                    'activeclass' => array('tagposition' => 'li', 'class'=>'active'),
                    'subindicator' => array('topmenu' => '<i class="arrow_carrot-down"></i>', 'submenu'=>'<i class="arrow_carrot-right"></i>'),
                    1 => array(
                        'tag' => 'li',
                        'attr' => array(),
                        'anchor_attr' => array()
                    )
                ),
            );

            echo $this->navigation->navMenu( 1, $datamenu );
            ?>
        </nav>
        <?php endif; ?>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <?php
            if(get_social_url('facebook')!=''){
                echo '<a href="'.get_social_url('facebook').'" target="_blank"><i class="fa fa-facebook"></i></a>';
            }
            if(get_social_url('twitter')!=''){
                echo '<a href="'.get_social_url('twitter').'" target="_blank"><i class="fa fa-twitter-alt"></i></a>';
            }
            if(get_social_url('instagram')!=''){
                echo '<a href="'.get_social_url('instagram').'" target="_blank"><i class="fa fa-instagram"></i></a>';
            }
            if(get_social_url('youtube')!=''){
                echo '<a href="'.get_social_url('youtube').'" target="_blank"><i class="fa fa-youtube"></i></a>';
            }
            ?>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> <?php echo get_option('siteemail'); ?></li>
                <li><i class="fa fa-clock-o"></i> <?php echo getDay(date('d')).', '.date('d').' '.getMonth(date('m')) .' '. date('Y'); ?></li>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> <?php echo get_option('siteemail'); ?></li>
                                <li><i class="fa fa-clock-o"></i> <?php echo getDay(date('d')).', '.date('d').' '.getMonth(date('m')).' '.date('Y'); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <?php
                                if(get_social_url('facebook')!=''){
                                    echo '<a href="'.get_social_url('facebook').'" target="_blank"><i class="fa fa-facebook"></i></a>';
                                }
                                if(get_social_url('twitter')!=''){
                                    echo '<a href="'.get_social_url('twitter').'" target="_blank"><i class="fa fa-twitter"></i></a>';
                                }
                                if(get_social_url('instagram')!=''){
                                    echo '<a href="'.get_social_url('instagram').'" target="_blank"><i class="fa fa-instagram"></i></a>';
                                }
                                if(get_social_url('youtube')!=''){
                                    echo '<a href="'.get_social_url('youtube').'" target="_blank"><i class="fa fa-youtube"></i></a>';
                                }
                                ?>
                            </div>

                            <?php if(count(langlist())>1): ?>
                            <div class="header__top__right__language">
                                <?php
                                $getlocale = explode("_",  t('locale') );
                                $theflagcode = strtoupper( $getlocale[1] );
                                ?>                                
                                <div><i class="flag-icon flag-icon-<?php echo strtolower($getlocale[1]); ?>"></i> <?php echo ucwords(locales(t('locale'))); ?></div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <?php
                                    foreach( langlist() AS $lv ){
                                        if( $lv == t('locale') ) {
                                            continue;
                                        }

                                        $shortname = explode("_", $lv)[0];
                                        $countryName = locales($lv);

                                        echo '<li><a href="'.base_url('setlang/setlang/'.$lv).'">'.strtoupper($shortname).' '.$countryName.'</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <div class="header__top__right__auth">
                                <a href="#"><i class="fa fa-user"></i> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="<?php echo base_url(); ?>"><img style="height:50px;" src="<?php echo logo_url('medium'); ?>" alt="<?php echo web_info('tagline'); ?>"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php if( $this->navigation->hasMenu('1') ): ?>
                    <nav class="header__menu">
                        <?php 
                        // set menu property
                        $datamenu = array(
                            'openingtag' => array(
                                1 => array(
                                    'tag' => 'ul',
                                    'attr' => array('class'=>'menudesktop'),
                                ),
                                2 => array(
                                    'tag' => 'ul',
                                    'attr' => array('class'=>'header__menu__dropdown'),
                                )
                            ),
                            'listingtag' => array(
                                'activeclass' => array('tagposition' => 'li', 'class'=>'active'),
                                'subindicator' => array('topmenu' => '<i class="arrow_carrot-down"></i>', 'submenu'=>'<i class="arrow_carrot-right"></i>'),
                                1 => array(
                                    'tag' => 'li',
                                    'attr' => array(),
                                    'anchor_attr' => array()
                                )
                            ),
                        );

                        echo $this->navigation->navMenu( 1, $datamenu );
                        ?>
                    </nav>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                            <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                        </ul>
                        <div class="header__cart__price">item: <span>$150.00</span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->