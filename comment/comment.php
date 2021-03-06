<li <?php hybrid_attr( 'comment' ); ?>>

    <article>
        <header class="comment-info clearfix">
			<?php echo get_avatar( $comment, 40 ); ?>

			<cite <?php hybrid_attr( 'comment-author' ); ?>><?php comment_author_link(); ?></cite>
			<a <?php hybrid_attr( 'comment-permalink' ); ?>><time <?php hybrid_attr( 'comment-published' ); ?>><?php printf( __( '%1$s at %2$s', 'fold' ), get_comment_date(), get_comment_time() ); ?></time></a>

			<?php edit_comment_link( __( 'Edit This', 'fold' ), '(', ')' ); ?>
        </header><!-- .comment-meta -->

		<div <?php hybrid_attr( 'comment-content' ); ?>>
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fold' ); ?></em>
				</p>
			<?php endif; ?>
			<?php comment_text(); ?>

			<?php hybrid_comment_reply_link(); ?>
        </div><!-- .comment-content -->
    </article>

<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>
