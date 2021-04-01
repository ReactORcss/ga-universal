<?php
//Добавление расширенных возможностей
if ( ! function_exists( 'universal_theme_setup' ) ) :
    function universal_theme_setup() {
        // Добавление тега title
        add_theme_support( 'title-tag' );

        // Добавление миниатюр
        add_theme_support( 'post-thumbnails', array( 'post' ) );

        // Добавление пользовательского логотипа
        add_theme_support( 'custom-logo', [
            'width'       => 163,
            'flex-height' => true,
            'header-text' => 'Universal',
            'unlink-homepage-logo' => false, // WP 5.5
        ] );

        // Регистрация меню
        register_nav_menus( [
            'header_menu' => 'Меню в шапке',
            'footer_menu' => 'Меню в подвале'
        ] );
    }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );

/**
 * Подключение сайдбара
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной сверху', 'universal-example' ),
			'id'            => 'main-sidebar-top',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-example' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Сайдбар на главной снизу', 'universal-example' ),
			'id'            => 'main-sidebar-bottom',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universal-example' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Меню в подвале', 'universal-example' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Добавьте меню сюда.', 'universal-example' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-menu-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Текст в подвале', 'universal-example' ),
			'id'            => 'sidebar-footer-text',
			'description'   => esc_html__( 'Добавьте текст сюда.', 'universal-example' ),
			'before_widget' => '<section id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
	
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

/**
 * Добавление нового виджета Downloader_Widget.
 */
class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Полезные файлы',
			array( 'description' => 'Файлы для скачивания', 'classname' => 'widget-downloader', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
        $description = $instance['description'];
        $link = $instance['link'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
        if ( ! empty( $description ) ) {
			echo '<p>' . $description . '</p>';
		}
        if ( ! empty( $link ) ) {
			echo '<a target="_blank" class="widget-link" href="' . $link . '">
			<img class="widget-link-icon" src="' . get_template_directory_uri(). '/assets/images/download.svg">
			Скачать</a>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Полезные файлы';
        $description = @ $instance['description'] ?: 'Описание';
        $link = @ $instance['link'] ?: 'http://yandex.ru';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
        $instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );

class Recent_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: downloader_widget
			'Недавно опубликовано',
			array( 'description' => 'Последние посты', 'classname' => 'widget-recent-posts', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
        $count = $instance['count'];

		echo $args['before_widget'];

        if ( ! empty( $count ) ) {
			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			echo '<div class="widget-recent-posts-wrapper">';
			global $post;
			$postslist = get_posts( array( 'posts_per_page' => $count, 'order'=> 'ASC', 'orderby' => 'title' ) );
			foreach ( $postslist as $post ){
				setup_postdata($post);
				?>
				<a href="<?php echo get_the_permalink()?>" class="recent-post-link">
					<img class="recent-post-thumb" src="<?php echo get_the_post_thumbnail_url(null, 'thumbnail')?>" alt="">
					<div class="recent-post-info">
					<h4 class="recent-post-title"><?php echo mb_strimwidth(get_the_title(), 0, 25, '...'); ?></h4>
					<span class="recent-post-time">
							<?php $time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
							echo "$time_diff назад";?>
					</span>
					</div>
				</a>
				<?php
			}
			wp_reset_postdata();
				echo '</div>';
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Недавно опубликовано';
        $count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Заголовок:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество постов:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.downloader_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Posts_Widget

// регистрация Recent_Posts_Widget в WordPress
function register_recent_posts_widget() {
	register_widget( 'Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );

/**
 * Добавление нового виджета Foo_Widget.
 */
class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', // ID виджета, если не указать (оставить ''), то ID будет равен названию класса в нижнем регистре: social_widget
			'Социальные сети',
			array( 'description' => 'Выберите соцсеть', 'classname' => 'widget-social', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$social_link_fb = @ $instance['social_link_fb'];
		$social_link_youtube = @ $instance['social_link_youtube'];
		$social_link_twitter = @ $instance['social_link_twitter'];
		$social_link_vk = @ $instance['social_link_vk'];

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="widget-social-wrapper">';
		if ( ! empty( $social_link_fb ) ) {
			echo '<a class="widget-social-icon" href="' . $social_link_fb . '"><img class="widget-social-icon" src="' . get_template_directory_uri(). '/assets/images/facebook.svg">
			</a>';
		}
		if ( ! empty( $social_link_youtube ) ) {
			echo '<a class="widget-social-icon" href="' . $social_link_youtube . '"><img class="widget-social-icon" src="' . get_template_directory_uri(). '/assets/images/youtube.svg">
			</a>';
		}
		if ( ! empty( $social_link_twitter ) ) {
			echo '<a class="widget-social-icon" href="' . $social_link_twitter . '"><img class="widget-social-icon" src="' . get_template_directory_uri(). '/assets/images/twitter.svg">
			</a>';
		}
		if ( ! empty( $social_link_vk ) ) {
			echo '<a class="widget-social-icon" href="' . $social_link_fb . '"><img class="widget-social-icon" src="' . get_template_directory_uri(). '/assets/images/facebook.svg">
			</a>';
		}
		echo '</div>';
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Наши соцсети';
		$social_link_fb = @ $instance['social_link_fb'] ?: '';
		$social_link_youtube = @ $instance['social_link_youtube'] ?: 'https://www.../';
		$social_link_twitter = @ $instance['social_link_twitter'] ?: 'https://www.../';
		$social_link_vk = @ $instance['social_link_vk'] ?: 'https://www.../';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_fb' ); ?>"><?php _e( 'Facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_fb' ); ?>" name="<?php echo $this->get_field_name( 'social_link_fb' ); ?>" type="text" value="<?php echo esc_attr( $social_link_fb ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_youtube' ); ?>"><?php _e( 'Youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_youtube' ); ?>" name="<?php echo $this->get_field_name( 'social_link_youtube' ); ?>" type="text" value="<?php echo esc_attr( $social_link_youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_twitter' ); ?>"><?php _e( 'Twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_twitter' ); ?>" name="<?php echo $this->get_field_name( 'social_link_twitter' ); ?>" type="text" value="<?php echo esc_attr( $social_link_twitter ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'social_link_vk' ); ?>"><?php _e( 'VK:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'social_link_vk' ); ?>" name="<?php echo $this->get_field_name( 'social_link_vk' ); ?>" type="text" value="<?php echo esc_attr( $social_link_vk ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['social_link_fb'] = ( ! empty( $new_instance['social_link_fb'] ) ) ? strip_tags( $new_instance['social_link_fb'] ) : '';
		$instance['social_link_youtube'] = ( ! empty( $new_instance['social_link_youtube'] ) ) ? strip_tags( $new_instance['social_link_youtube'] ) : '';
		$instance['social_link_twitter'] = ( ! empty( $new_instance['social_link_twitter'] ) ) ? strip_tags( $new_instance['social_link_twitter'] ) : '';
		$instance['social_link_vk'] = ( ! empty( $new_instance['social_link_vk'] ) ) ? strip_tags( $new_instance['social_link_vk'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Social_widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );



// Подключение стилей и скриптов
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'swiper-slider', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', 'style', time() );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style', time() );
    wp_enqueue_style( 'Roboto-Slab', 'https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap' );
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', '//code.jquery.com/jquery-3.6.0.min.js');
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', null, time(), true);
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', 'swiper', time(), true);
}

add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );

add_action( 'wp_enqueue_scripts', 'adminAjax_data', 99 );
function adminAjax_data(){
	wp_localize_script( 'jquery', 'adminAjax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);

}

add_action( 'wp_ajax_contacts_form', 'ajax_form' );
add_action( 'wp_ajax_nopriv_contacts_form', 'ajax_form' );
function ajax_form() {
	$contact_name = $_POST['contact_name'];
	$contact_email = $_POST['contact_email'];
	$contact_comment = $_POST['contact_comment'];
	$message = 'Пользователь оставил свои данные: ' . $contact_name;

	$headers = 'From: Alexey Sorokin <mrsoralex@gmail.com>' . "\r\n";
	$sent_message = wp_mail('mrsoralex@yandex.ru', 'Новая заявка с сайта', $message, $headers);
	if($sent_message) {
		echo 'Всё получилось!';
	} else {
		echo 'Где-то есть ошибка:(';
	}
	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}

//Настройка виджета с тегами, изменяем настройки
add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args');
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '11';
	$args['orderby'] = 'count';
	return $args;
}

## отключаем создание миниатюр файлов для указанных размеров
add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'homepage-thumb', 65, 65, true ); // Кадрирование изображения
    add_image_size( 'article-thumb', 336, 195, true ); // Кадрирование изображения
}

//меняем стиль многоточия в отрывках
add_filter('excerpt_more', function($more) {
	return '...';
});

//склояем слова после числительных
function plural_form($number, $after) {
	$cases = array (2, 0, 1, 1, 1, 2);
	echo $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}