<?php 

/*
Plugin Name: UW OG Meta
Description: Auto-creates Open Graph meta data for each page
Version: 1.0
Author: Nick Winkelbauer
*/

add_action( 'wp_head', 'uw_og_meta' );

function uw_og_meta(){
?>
	<meta property="og:title" content="<?php the_title() ?>" />
	<meta property="og:site_name" content="University of Washington" />
	<meta property="og:url" content="<?php the_permalink() ?>" />
	<meta property="og:type" content="Website" />
<?php
	if ( has_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
?>
		<meta property="og:image" content="<?php echo $image[0]; ?>"/>
<?php
	} else {
		$image = catch_that_image();
?> 		<meta property="og:image" content="<?php echo $image; ?>"/>
		<meta property="og:image:width" content="100" />
		<meta property="og:image:height" content="100" />
<?php
	}
	if (has_excerpt()){
?> 		<meta property="og:description" content="<?php echo the_excerpt(); ?>" /> 
<?php
	} else {
		$p = get_page( $page_id );
		list($desc,) = explode('.', $p->post_content, 2);
?>		 <meta property="og:description" content="<?php echo $desc; ?>" /> 
<?php
	}
}

// Get URL of first image in a post
function catch_that_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];

	// no image found display default image instead
	if(empty($first_img)){
		$first_img = "http://www.washington.edu/brand/files/2014/09/W-Logo_Purple_Hex-250x168.png";
	}
	return $first_img;
}
