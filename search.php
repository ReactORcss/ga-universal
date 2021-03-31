<?php get_header(); ?>
<div class="container">
    <h1 class="search-title">Результаты поиска по запросу:</h1>
    <div class="favourites">
        <div class="digest-wrapper">
        <ul class="digest">
            <?php while ( have_posts() ){ the_post(); ?>
                <li class="digest-item">
                                        <a href="<?php echo the_permalink() ?>" class="digest-item-permalink">
                                            <img src="<?php 
                                                if(has_post_thumbnail() ) {
                                                    echo get_the_post_thumbnail_url();
                                                } else {
                                                    echo get_template_directory_uri().'/assets/images/img-default.jpg';
                                                }
                                                ?>" class="digest-thumb">
                                                </a>
                                            </span>
                                            <div class="digest-info">
                                                <?php
                                                    foreach (get_the_category() as $category) {
                                                        printf(
                                                            '<a href="%s" class="category-link %s">%s</a>',
                                                            esc_url( get_category_link($category)),
                                                            esc_html( $category -> slug ),
                                                            esc_html( $category -> name ),
                                                        );
                                                    }
                                                ?>
                                                <a href="<?php echo get_the_permalink() ?>" class="digest-item-permalink">
                                                    <h3 class="digest-title"><?php echo mb_strimwidth(get_the_title(), 0, 65, '...') ?></h3>
                                                </a>
                                                <p class="digest-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 150, '...') ?></p>
                                                <div class="digest-footer">
                                                    <span class="digest-date"><?php the_time('j F') ?></span>
                                                    <div class="comments digest-comments">
                                                        <svg width="19" height="15" class="icon comments-icon">
                                                            <use xlink:href="<?php echo get_template_directory_uri()?>/assets/images/sprite.svg#comment"></use>
                                                        </svg>
                                                        <span class="comments-counter"><?php comments_number('0', '1', '%') ?></span>
                                                    </div>
                                                    <div class="likes digest-likes">
                                                        <img src="<?php echo get_template_directory_uri() . '/assets/images/heart.svg'?>" alt="icon: like" class="likes-icon">
                                                        <span class="likes-counter"><?php comments_number('0', '1', '%') ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                </li>
            <?php } ?>
            <?php if ( ! have_posts() ){ ?>
                Записей нет.
            <?php } ?>
        </ul>
        <?php 
        $args = array(
            'prev_text'    => '&larr; Назад',
	        'next_text'    => 'Вперёд &rarr;',
        );
        the_posts_pagination( $args) ?>
        </div>
        <!-- Подключаем нижний сайдбар -->
        <?php get_sidebar('home-bottom'); ?>    
    </div>
</div>
<?php get_footer(); ?>