<?php
/*
Template Name: Страница таксономии
Template Post Type: post, page, products
*/

get_header(); ?>
  <div class="container">
    <h1 class="category-title"><?php single_term_title();?></h1>
    <div class="post-list">
      <?php while ( have_posts() ){ the_post(); ?>
      
        <div class="post-card">
        <a href="<?php echo the_permalink() ?>" class="digest-item-permalink">
            <img src="<?php 
                if(has_post_thumbnail() ) {
                    echo get_the_post_thumbnail_url();
                } else {
                    echo get_template_directory_uri().'/assets/images/img-default.jpg';
                }
                ?>" class="digest-thumb">
          <div class="post-card-text">
            <h2 class="post-card-title"><?php the_title();?></h2>
            <p class="post-card-excerpt"><?php echo mb_strimwidth(get_the_excerpt(), 0, 90, '...');?></p>
        </a>
            <div class="author">
              <?php $author_id = get_the_author_meta('ID'); ?>
              <img src="<?php echo get_avatar_url($author_id)?>" alt="Автор статьи" class="author-avatar">
              <div class="author-info">
                <span class="author-name"><strong><?php the_author()?></strong></span>
                <span class="date"><?php the_time( 'j F' )?></span>
                <div class="comments">
                  <svg width="13.5" height="13.5" class="icon comments-icon" fill="#BCBFC2">
                    <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite.svg#comment'?>"></use>
                  </svg>
                  <span class="comments-counter"><?php comments_number('0', '1', '%');?></span>
                </div>
                <div class="likes">
                  <svg width="13" height="12" class="icon likes-icon" fill="#BCBFC2">
                    <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/sprite.svg#heart'?>"></use>
                  </svg>
                  <span class="likes-counter"><?php comments_number('0', '1', '%')?></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ( ! have_posts() ){ ?>
        Записей нет.
      <?php } ?>
    </div>
  </div>
<?php get_footer();
