<?php

// COMMENT HEADER
add_filter( 'genesis_title_comments', 'sp_genesis_title_comments' );
function sp_genesis_title_comments() {
	$title = '<h3 class="page-header">Comments</h3>';
	return $title;
}



// COMMENT LIST
add_filter( 'genesis_comment_list_args', 'custom_genesis_comment_list_args' );
function custom_genesis_comment_list_args( $args ){
    $args['callback'] = 'custom_genesis_comment_callback';
    return $args;
}
function custom_genesis_comment_callback( $comment, $args, $depth ){
$GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
<article <?php echo genesis_attr( 'comment' ); ?>>
<?php do_action( 'genesis_before_comment' ); ?>
        <div <?php echo genesis_attr( 'comment-media' ); ?>>
        <?php 
        $atts = array( 
        	'extra_attr' => 'nopin="nopin"',
                'class' => 'media-object img-rounded'                  
            	);
        if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', 'commenter avatar', $atts ); ?>
        </div>
        <div class="media-body">
        	<h5 <?php echo genesis_attr( 'comment-header' ); ?>>
        		<span <?php echo genesis_attr( 'comment-author' ); ?>>
        		<?php
        		$author = get_comment_author();
			$url    = get_comment_author_url();
			if ( ! empty( $url ) && 'http://' !== $url ) {
				$author = sprintf( '<a href="%s" %s>%s</a>', esc_url( $url ), genesis_attr( 'comment-author-link' ), $author );
       			}
			$comment_author_says_text = apply_filters( 'comment_author_says_text', __( '', 'genesis' ) );
			if ( ! empty( $comment_author_says_text ) ) {
				$comment_author_says_text = '<span class="says">' . $comment_author_says_text . '</span>';
			}
			printf( '<span itemprop="name">%s</span> %s', $author, $comment_author_says_text );
			echo '</span>'; // comment-author
			$comment_date = apply_filters( 'genesis_show_comment_date', true, get_post_type() );
			if ( $comment_date ) {
				printf( '<span %s>', genesis_attr( 'comment-meta' ) );
				printf( '<time %s>', genesis_attr( 'comment-time' ) );
				printf( '<a href="%s" %s>', esc_url( get_comment_link( $comment->comment_ID ) ), genesis_attr( 'comment-time-link' ) );
				echo    esc_html( get_comment_date() ) . ' ' . __( 'at', 'genesis' ) . ' ' . esc_html( get_comment_time() );
				echo    '</a></time></span>';
			}
			comment_reply_link(
                		array_merge(
                			$args, array(
                				'reply_text' => '<span class="glyphicon glyphicon-share-alt"></span> Reply',
                    				'add_below' => 'div-comment',
                    				'depth'   => $depth,
                    				'max_depth' => $args['max_depth'],
		    				'before' => sprintf( '<div %s>', genesis_attr( 'comment-reply' ) ),
                    				'after'   => '</div><!-- .reply -->'
                  				)
                			)
              		); 
              		edit_comment_link( __( ' (Edit)' ), '<span class="edit-link text-muted small">', '</span>' ); 
              		?>
              	</h5>
 		<div <?php echo genesis_attr( 'comment-content' ); ?>>
        	<?php if ( ! $comment->comment_approved ) : ?>
			<?php $comment_awaiting_moderation_text = apply_filters( 'genesis_comment_awaiting_moderation', __( 'Your comment is awaiting moderation.', 'genesis' ) ); ?>
			<div class="alert alert-info"><?php echo $comment_awaiting_moderation_text; ?></div>
		<?php endif; ?>
        	<?php comment_text(); ?>
        	</div><!-- .comment-content -->
        </div><!-- .media-body -->
<?php do_action( 'genesis_after_comment' ); ?>
</article>
<?php
}



// COMMENT FORM FIELDS
// @ToDo - Change/combine these next two filters to genesis_comment_form_args filter
add_filter( 'comment_form_default_fields', 'bsg_comment_form_fields' );
function bsg_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    $fields   =  array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
        'email'  => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                    '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
        'url'    => '<div class="form-group comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
                    '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'        
    );
    return $fields;
}

// COMMENT FORM DEFAULTS
add_filter( 'comment_form_defaults', 'bsg_comment_form_modifications' );
function bsg_comment_form_modifications( $args ) {
    $args['title_reply'] = __( 'Join the Conversation' );
    $args['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_registration_url(), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>';
    $args['comment_notes_after'] = '';
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . __( 'Comment' ) . '</label> 
            <textarea class="form-control expand" id="comment" name="comment" cols="45" rows="4" aria-required="true"></textarea>
        </div>';
    $args['class_submit'] = 'btn btn-default'; 
    return $args;
}
