<?php

add_filter( 'genesis_title_comments', 'sp_genesis_title_comments' );
function sp_genesis_title_comments() {
	$title = '<h3 class="page-header">Comments</h3>';
	return $title;
}


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
      <div <?php echo genesis_attr( 'comment-author' ); ?>>
      <a href="#" itemprop="image">
      <?php
            $atts = array( 
                   'extra_attr' => 'nopin="nopin"',
                   'class' => 'media-object img-rounded'                  
            );
            if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', 'commenter avatar', $atts );
        ?>
       </a>
      </div>
      <div class="media-body">
    <h5 class="media-heading" itemprop="name"><?php printf( __( '%s ', 'gb3' ), sprintf( '<cite class="fn"><strong>%s</strong></cite>', get_comment_author_link() ) ); ?>&nbsp;<span class="bullet text-muted small" aria-hidden="true">•</span>&nbsp;<span class="comment-meta">
              <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                <time class="text-muted small" datetime="<?php comment_time( 'c' ); ?>" itemprop="commentTime">
                  <?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
                </time>
              </a>
              <?php comment_reply_link(
                array_merge(
                  $args, array(
                    'reply_text' => '<span class="glyphicon glyphicon-share-alt"></span> Reply',
                    'add_below' => 'div-comment',
                    'depth'   => $depth,
                    'max_depth' => $args['max_depth'],
                    'before'  => '<footer class="reply comment-reply text-muted small pull-right">',
                    'after'   => '</footer><!-- .reply -->'
                  )
                )
              ); ?>
              <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link text-muted small">', '</span>' ); ?>
             
     </h5>
          <?php if ( '0' == $comment->comment_approved ) : ?>
            <div class="alert alert-info">
              <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.'); ?></p>
            </div>
          <?php endif; ?>
          <div class="comment-content" itemprop="commentText">
            <?php comment_text(); ?>
          </div><!-- .comment-content -->
      </div><!-- .media-body -->
<?php do_action( 'genesis_after_comment' ); ?>
    </article>
    <?php
}



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




add_filter( 'comment_form_defaults', 'bsg_comment_form_modifications' );
function bsg_comment_form_modifications( $args ) {
    $args['title_reply'] = __( 'Join the Conversation' );
    $args['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_registration_url(), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>';
    $args['comment_notes_after'] = '';
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . __( 'Comment' ) . '</label> 
            <textarea class="form-control expand" id="comment" name="comment" cols="45" rows="3" aria-required="true"></textarea>
        </div>';
    $args['class_submit'] = 'btn btn-default'; 
    return $args;
}
