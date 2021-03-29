<?php get_header('post'); ?>
    <main class="site-main">
    <?php
    //Запускаем цикл Wordpress, проверяем есть ли посты
		while ( have_posts() ) :
            // если пост есть, выводим содержимое
			the_post();
            // находим шаблон для вывода поста в папке template_parts
			get_template_part( 'template-parts/content', get_post_type() );
            //Выводим ссылки на предыдущий и следующий посты
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Назад', 'universal-example' ) . '</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Вперёд:', 'universal-example' ) . '</span>',
				)
			);
			// Если комментарии к записи открыты, выводим комментарии
			if ( comments_open() || get_comments_number() ) :
                //Находим файл comments.php и выводим комментарии
				comments_template();
			endif;

		endwhile; // Конец цикла Wordpress
		?>
    </main>
<?php get_footer(); ?>