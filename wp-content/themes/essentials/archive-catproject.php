<?php
/**
 * The template for displaying archive pages Project
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package essentials
 */

$blog_template = 'right-sidebar';
if(!empty(pix_get_option('blog-page-template'))){
	$blog_template = pix_get_option('blog-page-template');
}

switch ($blog_template) {
	case 'left-sidebar':
		get_template_part( 'templates/template-blog-left-sidebar');
		break;
	case 'full-width':
		get_template_part( 'templates/template-blog-without-sidebar');
		break;
	case 'with-offset':
		get_template_part( 'templates/template-blog-with-offset');
		break;
	default:
		get_template_part( 'templates/template-blog-right-sidebar');
}
?>

<div class="row">
	<?php
	   $custom_terms = get_terms('project');

	   foreach($custom_terms as $custom_term) {
	       wp_reset_query();
	       $args = array('post_type' => 'project',
	           'tax_query' => array(
	               array(
	                   'taxonomy' => 'catproject',
	                   'field' => 'slug',
	                   'terms' => $custom_term->slug,
	               ),
	           ),
	        );

	        $loop = new WP_Query($args);
	        if($loop->have_posts()) {
	           echo '<h2>'.$custom_term->name.'</h2>';

	           while($loop->have_posts()) : $loop->the_post();
	               echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br>';
	           endwhile;
	        }
	   }
	?>
</div>
