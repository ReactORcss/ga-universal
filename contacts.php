<?php
/*
Template Name: Страница контакты
Template Post Type: page
*/

get_header();
?>
    <section class="section-dark">
        <div class="container">
            <?php the_title('<h1 class="page-title">', '</h1>', true); ?>
            <div class="contacts-wrapper">
                <div class="left">
                    <h2 class="contacts-title">Через форму обратной связи</h2>
                    <!-- <form action="#" class="contacts-form" method="POST">
                        <input name="contact_name" type="text" class="input contacts-input" placeholder="Ваше имя">
                        <input name="contact_email" type="email" class="input contacts-input" placeholder="Ваш Email">
                        <textarea name="contact_comment" id="" class="textarea contacts-textarea" placeholder="Ваш вопрос"></textarea>
                        <button type="submit" class="button more">Отправить</button>
                    </form> -->
                    <?php the_content()?>
                </div>
                <div class="right">
                    <h2 class="contacts-title">Или по этим контактам</h2>
                    <?php 
                        // проверяем, есть ли дополнительное поле email
                        $email = get_post_meta(get_the_ID(), 'email', true);
                        if($email) {
                            echo '<a href="mailto:' . $email . '">' . $email . '</a>';      
                        }
                        // проверяем, есть ли дополнительное поле адрес
                        $address = get_post_meta(get_the_ID(), 'address', true);  
                        if($address) {
                            echo '<address>' . $address . '</address>';
                        }
                        // проверяем, есть ли дополнительное поле телефон
                        $phone = get_post_meta(get_the_ID(), 'phone', true);  
                        if($phone) {
                            echo '<a href="tel:' . $phone . '">' . $phone . '</a>';
                        }

                        // $check = the_field('email');
                        // echo '<a href="mailto:' . $check . '">' . $check . '</a>';      
                        
                        // the_field('address');
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
get_footer();