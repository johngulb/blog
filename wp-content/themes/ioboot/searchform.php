<form role="search" method="get" class="io-search-form form-row" action="<?php echo esc_url( home_url( '/' ) ) ?>">
        <div class="form-group col-lg-8">
            <input type="text" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'ioboot' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
        </div><!-- /.col-sm-2 -->
        <div class="form-group col-lg-4">
            <input type="submit" class="submit btn btn-primary btn-block" value="<?php echo esc_attr_x( 'Search', 'submit button', 'ioboot' ) ?>" />
        </div><!-- /.col-sm-2 -->
</form>