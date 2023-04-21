<?php 
/* Template Name: Project Page
*/ ?>
<?php 
if(!empty($_GET["template"])){
    switch ($_GET["template"]) {
        case 'blog-right-sidebar':
            get_template_part( 'templates/template-blog-right-sidebar' );
            break;
        case 'blog-left-sidebar':
            get_template_part( 'templates/template-blog-left-sidebar' );
            break;
        case 'full-width':
            get_template_part( 'templates/template-full-width' );
            break;
        default:
            break;
    }
}


get_header();

$classes = 'bg-white ';
$styles = '';
$col_classes = 'col-12';

if(!empty(pix_get_option('pages-bg-color'))){
    if(pix_get_option('pages-bg-color')=='custom'){
        $styles = 'background:'.pix_get_option('custom-pages-bg-color').';';
        $classes = '';
    }else{
        $classes = 'bg-'.pix_get_option('pages-bg-color'). ' ';
    }
}

if(!empty(pix_get_option('pages-with-intro'))&&pix_get_option('pages-with-intro')){
	get_template_part( 'template-parts/intro' );
}

if(!function_exists('essentials_core_plugin')){
    get_template_part( 'template-parts/intro' );
    $classes .= ' pix-pb-20 ';
    $col_classes = 'col-12 col-md-8 offset-md-2';
}

if(!get_post_meta( get_the_ID(), 'pix-hide-top-padding', true )){
    $classes .= 'pt-5';
}

$containerClass = 'container';
if( class_exists( '\Elementor\Plugin' ) ) {
    if ( Elementor\Plugin::instance()->db->is_built_with_elementor( get_the_ID() ) ) {
        if(empty(pix_get_option('pix-add-default-container'))){
            $containerClass = 'container-fluid px-0 mx-0';
        }
    }
}

?>
<div id="content" class="site-content <?php echo esc_html( $classes );?>" style="<?php echo esc_html( $styles ); ?>" >
    <div class="<?php echo esc_attr($containerClass); ?>">
            <div class="<?php echo esc_attr($col_classes); ?>">
                <div id="primary" class="content-area">
                    <main id="main" class="site-main">
                        <div class="row">
                            <?php
                                $args = array( 
                                        'post_type' => 'project',
                                        'post_status' => 'publish',
                                        //'cat' => 71, // Id chuyên mục
                                        'showposts' => 5,
                                        //'taxonomy' = 'catproject',

                                        ); 
                                    ?>
                                    <?php $getposts = new WP_query( $args);?>
                                    <?php global $wp_query; $wp_query->in_the_loop = true; ?>
                                    <?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="entry-thumb">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail(array(300, 300)); ?> 
                                                </a>
                                            </div>
                                            <span>
                                                <p>Chuyên mục: </p>
                                           <?php the_category(); ?>
                                            </span>
                                            <div class="entry-title">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            </div>

                                            <div class="entry-date">
                                                <span><?php echo get_the_date();?></span>
                                            </div>
                                            <div class="entry-body">
                                                <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
                                            </div>
                                            <a href="<?php the_permalink(); ?>" class="read-more"> Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                                            <div class="clear"></div>
                                        </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div> <!-- #row -->
                    </main><!-- #main -->
                </div><!-- #primary -->
            </div>
        </div>
    </div>
</div>
<?php

get_footer();
