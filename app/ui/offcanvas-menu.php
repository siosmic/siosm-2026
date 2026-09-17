<div id="offcanvas-menu" class="fixed top-0 right-0 z-40 flex-col w-80 h-full bg-white shadow-2xl opacity-0 transition-all duration-500 ease-out translate-x-80 pointer-events-none offcanvas lg:w-96 lg:translate-x-96">

    <div class="flex justify-end p-3">
        <div class="w-8 h-8 cursor-pointer burger-menu-close group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="transition-all duration-500 ease-out group-hover:rotate-180"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path class="fill-primary" d="M183.1 137.4C170.6 124.9 150.3 124.9 137.8 137.4C125.3 149.9 125.3 170.2 137.8 182.7L275.2 320L137.9 457.4C125.4 469.9 125.4 490.2 137.9 502.7C150.4 515.2 170.7 515.2 183.2 502.7L320.5 365.3L457.9 502.6C470.4 515.1 490.7 515.1 503.2 502.6C515.7 490.1 515.7 469.8 503.2 457.3L365.8 320L503.1 182.6C515.6 170.1 515.6 149.8 503.1 137.3C490.6 124.8 470.3 124.8 457.8 137.3L320.5 274.7L183.1 137.4z" />
            </svg>
        </div>
    </div>

    <div class="flex justify-center items-center mb-10">
        <?php //get_template_part('app/ui/logo', 'mini'); 
        ?>
        <span class="text-2xl font-bold"><?php echo get_bloginfo('name') ?></span>
    </div>

    <?php

    wp_nav_menu(
        array(
            'container_id'    => 'primary',
            'container_class' => 'block md:hidden',
            'menu_class'      => 'menu accordion',
            'theme_location'  => 'primary',
            'li_class'        => 'text-primary',
            'fallback_cb'     => false,
        )
    );

    wp_nav_menu(
        array(
            'container_id'    => 'offcanvas',
            'container_class' => '',
            'menu_class'      => 'menu accordion',
            'theme_location'  => 'burger',
            'li_class'        => 'text-primary',
            'fallback_cb'     => false,
        )
    );
    ?>

</div>