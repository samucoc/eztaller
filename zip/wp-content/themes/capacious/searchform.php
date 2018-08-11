<div class="search-block">
    <form action="<?php echo esc_url( home_url() )?>" class="searchform" id="searchform" method="get" role="search">
        <div>
            <label for="menu-search" class="screen-reader-text"></label>
            <?php
             $capacious_placeholder_option = capacious_get_option( 'capacious_post_search_placeholder_option');
            if ( isset($capacious_placeholder_option) ):
               
            endif; ?>
            <input type="text" placeholder='<?php echo esc_attr($capacious_placeholder_option) ;?>'  class="menu-search" id="menu-search" name="s" value="<?php echo esc_attr( get_search_query() );?>">
            <button class="searchsubmit fa fa-search" type="submit" id="searchsubmit"></button>
        </div>
    </form>
</div>