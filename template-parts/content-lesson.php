<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <!-- Шапка поста -->
    <header class="entry-header <?php echo get_post_type();?>-header" style="background: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75));">
	<div class="container">
		<div class="post-header-wrapper">
		<div class="post-header-nav">
			<?php
				foreach (get_the_category() as $category) {
				printf(
				'<a href="%s" class="category-link %s">%s</a>',
				esc_url( get_category_link( $category )),
				esc_html($category -> slug),
				esc_html( $category -> name )
			);
			}
				?>
			</div>
			<div class="video">
				<iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php
					$video_link = get_field('video_link');
					if($video_link) {
						$tmp = explode('?v=', get_field('video_link'));
						echo end ($tmp);
					}?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<div class="lesson-header-title-wrapper">
			<?php
			//проверяем, точно ли мы на странице поста
			if ( is_singular() ) :
				the_title( '<h1 class="lesson-header-title">', '</h1>' );
			else :
				the_title( '<h2 class="lesson-header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>
			</div>
			<div class="post-header-info">
				<span class="post-header-date">
					<svg width="15" height="15" class="icon comments-icon">
						<use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#clock"></use>
					</svg>
          		<?php the_time('j F, g:i') ?></span>
			</div>
		</div>	
	</div>		
	</header><!-- шапка поста -->
    <!-- Содержимое поста -->
    <div class="entry-content">
		<?php
        //выводим содержимое
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-example' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Страницы:', 'universal-example' ),
				'after'  => '</div>',
			)
		);
		?>
		<blockquote class="wp-block-quote">
          <p>Таким образом консультация с широким активом способствует подготовки и реализации направлений прогрессивного развития. Не следует, однако забывать, что новая модель организационной деятельности в значительной степени обуславливает.</p>
        </blockquote>
		<footer class="entry-footer">
        <?php
            $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'universal-theme' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-theme' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			//Поделиться в соцсетях
			meks_ess_share(); 
        ?>
		</footer><!-- .entry-footer -->
	</div><!-- содержимое поста -->
    <!-- Подвал поста -->
</article>