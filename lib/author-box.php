<?php
/**
 * Module: Custom Author Box
 * Description: Adds User Contact Methods, Remove Default Genesis Box, and add Bootstraped Box.
 */



/*-----------------------------------------------------------------------------------*/
/* Display author box on single posts                                                */
/*-----------------------------------------------------------------------------------*/
//* 
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
// */



/*-----------------------------------------------------------------------------------*/
/* Modify the size of the Gravatar in the author box                                 */
/*-----------------------------------------------------------------------------------*/
//* 
add_filter( 'genesis_author_box_gravatar_size', 'altitude_author_box_gravatar' );
function altitude_author_box_gravatar( $size ) {
    return 90;
}
// */


/*-----------------------------------------------------------------------------------*/
/* Add custom meta fields                                                            */
/*-----------------------------------------------------------------------------------*/
//* 
add_filter( 'user_contactmethods', 'rv_custom_profile_fields', 9999 );
function rv_custom_profile_fields( $contactmethods ) {
    unset( $contactmethods['twitter'] );
    unset( $contactmethods['googleplus'] );
    unset( $contactmethods['facebook'] );
    $contactmethods['twitter_custom'] = 'Twitter Profile URL';
    $contactmethods['facebook_custom'] = 'Facebook Profile URL';
    $contactmethods['linkedin_custom'] = 'LinkedIn Profile URL';
    $contactmethods['gplus_custom'] = 'Google+ Profile URL';
    return $contactmethods;
}
// */



/*-----------------------------------------------------------------------------------*/
/* Removes default Genesis Author Box - Add custom box with custom user meta fields  */
/*-----------------------------------------------------------------------------------*/
//* 
function twbsgen_genesis_do_author_box_single() { 
  if ( is_single() ) {
  ?>
	<?php $gravatar = get_avatar( get_the_author_meta( 'ID' ), 250 ); // Author Gravatar ?>
	<?php $display_name = get_the_author_meta( 'display_name' ); // Author Display Name ?>
	<?php $authinfo = get_the_author_meta( 'description' ); // Author Bio ?>
	<?php $facebook = esc_url( htmlentities( get_the_author_meta( 'facebook_custom' ) ), array( 'https', 'http' ) ); ?>
	<?php $linkedin = esc_url( htmlentities( get_the_author_meta( 'linkedin_custom' ) ), array( 'https', 'http' ) ); ?>
	<?php $twitter = esc_url( htmlentities( get_the_author_meta( 'twitter_custom' ) ), array( 'https', 'http' ) ); ?>
	<?php $gplus = esc_url( htmlentities( get_the_author_meta( 'gplus_custom' ) ), array( 'https', 'http' ) ); ?>
	<?php $website = esc_url( htmlentities( get_the_author_meta( 'url' ) ), array( 'https', 'http' ) ); ?>
 <section class="author-box">
  <div class="row">
  <div class="col-sm-3">
 <div class="gravatar-object-fit">
		<?php echo $gravatar; ?>
</div>
  </div>
  <div class="col-sm-9">
        <div class="author-box-intro small">Author</div>
		<h2 class="author-box-title">About <?php echo $display_name; ?></h2>
		<div class="author-box-content"><p><?php echo $authinfo; ?></p></div>
		<div class="author-social-links">
			<?php
			if ( $twitter || $facebook || $linkedin || $gplus || $website )
				echo 'Follow Me: ';
			if ( $twitter )
				echo '<a href="' . $twitter . '" class="author-social-link twitter" target="_blank"><i class="fa fa-2x fa-twitter"></i></a>';
			if ( $facebook )
				echo '<a href="' . $facebook . '" class="author-social-link facebook" target="_blank"><i class="fa fa-2x fa-facebook"></i></a>';
			if ( $gplus )
				echo '<a href="' . $gplus . '" class="author-social-link gplus" target="_blank"><i class="fa fa-2x fa-google-plus"></i></a>';
			if ( $linkedin )
				echo '<a href="' . $linkedin . '" class="author-social-link linkedin" target="_blank"><i class="fa fa-2x fa-linkedin"></i></a>';
			?>
		</div>
		</div><!-- .col-sm-9 -->
</div> <!-- .row -->
	</section>
<?php
  }
}
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 ); // Remove Genesis Author Box
add_action( 'genesis_after_entry', 'twbsgen_genesis_do_author_box_single', 8 ); // Add bootstrap author box instead
//*/
