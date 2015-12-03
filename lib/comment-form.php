<?php


add_filter( 'genesis_title_comments', 'sp_genesis_title_comments' );
function sp_genesis_title_comments() {
	$title = '<hr><h3 class="page-header">Comments</h3>';
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
            if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'], '', 'Commenter Avatar', $atts );
       ?>
       </a>
      </div>
      <div class="media-body well">
    <h5 class="media-heading" itemprop="name"><?php printf( __( '%s ', 'gb3' ), sprintf( '<cite class="fn"><strong>%s</strong></cite>', get_comment_author_link() ) ); ?>&nbsp;<span class="bullet text-muted small" aria-hidden="true">•</span>&nbsp;<span class="comment-meta">
              <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                <time class="text-muted small" datetime="<?php comment_time( 'c' ); ?>" itemprop="commentTime">
                  <?php printf( _x( '%1$s at %2$s', '1: date, 2: time' ), get_comment_date(), get_comment_time() ); ?>
                </time>
              </a>
              <span class="edit-link text-muted small pull-right"><?php edit_comment_link( __( 'Edit' ), '<span class="glyphicon glyphicon-edit"></span>', '</span>' ); ?></span>
            </span>
     </h5>
          <?php if ( '0' == $comment->comment_approved ) : ?>
            <div class="alert alert-info">
              <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.'); ?></p>
            </div>
          <?php endif; ?>

          <div class="comment-content" itemprop="commentText">
            <?php comment_text(); ?>
          </div><!-- .comment-content -->
          <?php comment_reply_link(
            array_merge(
              $args, array(
                'add_below' => 'div-comment',
                'depth'   => $depth,
                'max_depth' => $args['max_depth'],
                'before'  => '<footer class="reply comment-reply pull-right">',
                'after'   => '</footer><!-- .reply -->'
              )
            )
          ); ?>
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
    $args['title_reply'] = _x( 'Join the Conversation', 'noun' );
    $args['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_registration_url(), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>';
    $args['comment_notes_after'] = '';
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun' ) . '</label> 
            <textarea class="form-control expand" id="comment" name="comment" cols="45" rows="3" aria-required="true"></textarea>
        </div>';
    $args['class_submit'] = 'btn btn-default'; 
    return $args;
}




function add_comment_author_to_reply_link($link, $args, $comment){
    $comment = get_comment( $comment );
    if ( empty($comment->comment_author) ) {
        if (!empty($comment->user_id)){
            $user=get_userdata($comment->user_id);
            $author=$user->user_login;
        } else {
            $author = __('Anonymous');
        }
    } else {
        $author = $comment->comment_author;
    }
    if(strpos($author, ' ')){
        $author = substr($author, 0, strpos($author, ' '));
    }
    $reply_link_text = $args['reply_text'];
    $link = str_replace($reply_link_text, '<i class="glyphicon glyphicon-share-alt"></i> Reply to ' . $author, $link);
    return $link;
}
add_filter('comment_reply_link', 'add_comment_author_to_reply_link', 10, 3); 



add_filter('comment_reply_link', 'replace_reply_link_class');
function replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='", $class);
    return $class;
}




add_action( 'wp_footer', 'do_comment_form_script', 9999 );
function do_comment_form_script() {
?>
<style type="text/css">
#commentform {
display:table;
width:100%;   
}
.comment-form-comment {
display: table-header-group; 
}	
</style>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('textarea.expand').focus(function () {
        $(this).animate({ height: "9em" }, 300); 
    });
});
</script>
<?php
}
