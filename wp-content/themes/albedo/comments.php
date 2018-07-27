<?php
/**
 * The template for displaying Comments.
 */
?>

<?php
	if ( ! defined( 'ABSPATH' ) ) { exit; }
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() || ( !comments_open() && 0 == get_comments_number() ) ) {
		return;
	}
?>

	<!--
		Comments block
	-->
	<div class="indent <?php echo get_option('show_avatars') ? 'with-avatars' : 'no-avatars'; ?>" id="comments">

		<h4 class="comments-title h1"><?php printf( _nx( '<span>1</span> Comment', 'Comments: <span>%1$s</span>', get_comments_number(), 'comments title', 'albedo' ), number_format_i18n( get_comments_number() ) ); ?></h4>

		<?php if ( have_comments() ) : ?>

			<ul class="comments-list">
				<?php
					wp_list_comments( array( 'callback' => 'wplab_albedo_comments_callback' ) );
				?>
			</ul><!-- .commentlist -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comments-nav" class="pagination style-post">
				<?php paginate_comments_links(); ?>
			</nav>
			<?php endif; // check for comment navigation ?>

		<?php else: ?>

			<p><?php esc_html_e( 'There are not comments on this post yet. Be the first one!', 'albedo'); ?></p>

		<?php endif; // have_comments() ?>

		<?php
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			$form_classes = '';
			if( wplab_albedo_utils::is_unyson() ) {
				$form_classes = 'form-style-' . fw_get_db_customizer_option( 'blog_single_comment_form_style' );
				$form_classes .= ' inputs-style-' . fw_get_db_customizer_option( 'blog_single_comment_form_inputs_style' );
			}

			$col_rtl = is_rtl() ? 'pull-right' : '';

			$comment_form_args = array(

				'class_submit' => 'button style-blue size-medium',

				'class_form' => 'comment-form ' . $form_classes,

				'title_reply' => esc_html__( 'Leave a comment', 'albedo' ),

				'comment_field'	=> '<div class="row"><div class="form-row col-md-12"><textarea class="input-icon-comment" id="comment" placeholder="' . esc_html__( 'Your Comment *', 'albedo' ) . '" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></div>',

				'fields'	=> apply_filters( 'comment_form_default_fields', array(

					'author' => '<div class="row"><div class="form-row ' . $col_rtl . ' col-md-6"><input class="input-icon-user" id="author" name="author" type="text" placeholder="' . esc_html__( 'Your Name *', 'albedo' ) . '" value="' . $commenter['comment_author'] . '" size="30"' . $aria_req . ' /></div></div>',

					'email' => '<div class="row"><div class="form-row col-md-6"><input id="email" class="input-icon-email" name="email" type="text" placeholder="' . esc_html__( 'Email Address *', 'albedo' ) . '" value="' . $commenter['comment_author_email'] . '" size="30"' . $aria_req . ' /></div>',

					'url' => '<div class="form-row col-md-6"><input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'albedo' ) . '" value="' . $commenter['comment_author_url'] .'" size="30" /></div></div>'

					)
				),

				'comment_notes_after' => '',

				'must_log_in' => '<p>' .  wp_kses_post( sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'albedo' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) ) . '</p>',

				'logged_in_as' => '',

				'comment_notes_before' => '',

			);
		?>

		<?php comment_form( $comment_form_args ); ?>

	</div><!-- /comments-->

<?php
/**
	* Comments callback function
 **/
function wplab_albedo_comments_callback( $comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '':
	?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

			<div class="comment-body">

				<div class="photo">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>

				<div class="comment-text">

					<header>

						<div class="alignleft">
							<div class="author-name"><?php $comment_author = get_userdata( $comment->user_id ); echo isset( $comment_author->display_name ) ? $comment_author->display_name : get_comment_author( get_comment_ID() ) ?></div>
							<div class="comment-time"><?php echo human_time_diff( get_comment_time('U'), current_time('timestamp')) . " " . esc_html__('ago', 'albedo'); ?></div>
						</div>

						<?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment', 'reply_text' => esc_html__('Reply', 'albedo'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ), get_comment_ID(), get_the_ID() ); ?>
						<div class="clearfix"></div>
					</header>

					<?php comment_text(); ?>

				</div>

			</div>

	<?php
		break;
			case 'pingback'  :
			case 'trackback' :
	?>
		<li class="post pingback">
			<div class="comment-data">
				<p><?php esc_html_e( 'Pingback', 'albedo' ); ?>: <?php comment_author_link(); ?></p>
			</div>
	<?php
		break;
	endswitch;
}
