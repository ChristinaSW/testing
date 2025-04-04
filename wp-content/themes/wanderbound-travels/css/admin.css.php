<?php

header("Content-type: text/css; charset: UTF-8");

$icon_color = '';
$icon_color = ( $icon_color != '' )?'color: '.$icon_color.' !important;':'';

$media_cloud = '';
$media_cloud = ( $media_cloud != '' )?'background-image: url('.$media_cloud.')!important;':'';
$yoast = '';
$yoast = ( $yoast != '' )?'background-image: url('.$yoast.')!important;':'';
$gravity_forms = '';
$gravity_forms = ( $gravity_forms != '' )?'background-image: url('.$gravity_forms.')!important;':'';
$mec_calendar = '';
$mec_calendar = ( $mec_calendar != '' )?'background-image: url('.$mec_calendar.')!important;':'';
$sg_optimizer = '';
$sg_optimizer = ( $sg_optimizer != '' )?'background-image: url('.$sg_optimizer.')!important;':'';
$sg_security = '';
$sg_security = ( $sg_security != '' )?'background-image: url('.$sg_security.')!important;':'';


?>

/* Structure */

.user-description-wrap,
.user-url-wrap {
    display: none;
}

/* Admin icons color */

#adminmenu div.wp-menu-image:before,
.block-editor-block-types-list .block-editor-block-icon.has-colors svg {
    <?php echo $icon_color ?>
}

/* Plugin Icons */

    /* Gravity Forms */

    .toplevel_page_gf_edit_forms .wp-menu-image.svg {
        <?php echo $gravity_forms ?>
        background-size: 15px auto !important;
    }

    /* Yoast SEO */

    #toplevel_page_wpseo_dashboard .wp-menu-image.svg {
        <?php echo $yoast ?>
    }

    /* SiteGround Optimizer */

    <?php if( $sg_optimizer != '' ){ ?>
    #adminmenu .toplevel_page_sg-cachepress .wp-menu-image img {
        display: none;
    }
    #adminmenu #toplevel_page_sg-cachepress .wp-menu-image:before {
        <?php echo $sg_optimizer ?>
        background-repeat: no-repeat;
        background-position: 0px 6px;
        width: 20px;
        height: 29px;
        content: '';
    }
    <?php } ?>

    /* SiteGround Security */

    <?php if( $sg_security != '' ){ ?>
    #adminmenu .toplevel_page_sg-security .wp-menu-image img {
        display: none;
    }
    #adminmenu #toplevel_page_sg-security .wp-menu-image:before {
        <?php echo $sg_security ?>
        background-repeat: no-repeat;
        background-position: 0px 6px;
        width: 20px;
        height: 29px;
        content: '';
    }
    <?php } ?>

    /* Media Cloud */

    .toplevel_page_media-cloud .wp-menu-image.svg {
        <?php echo $media_cloud ?>
    }

    /* Calendar */

    #toplevel_page_mec-intro .toplevel_page_mec-intro .wp-menu-image img {
        display: none;
    }
    #toplevel_page_mec-intro .toplevel_page_mec-intro .wp-menu-image {
        <?php echo $mec_calendar ?>
        background-repeat: no-repeat;
        background-position: center;
        background-size: 20px auto;
    }

/* Custom Block Attribute Styles */

