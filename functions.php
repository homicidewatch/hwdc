<?php
add_filter( 'the_content_more_link', 'hw_set_frontend_permalink', 10, 2 );
function hw_set_frontend_permalink( $more_link, $more_link_text ) {
    global $post;
    $permalink = get_permalink( $post->ID );
    $blogurl = get_bloginfo('url');
    $frontend = get_option('frontend_url', $blogurl);
    $url = str_replace($blogurl, $frontend, $permalink);
    return "<a href=\"{$url}\">" . $more_link_text . "</a>";
}

add_action( 'admin_menu', 'hw_add_options_page' );
function hw_add_options_page() {
    add_options_page( 'Homicide Watch', 'Homicide Watch', 'manage_options',
                      'hwdc', 'hw_options_page' );
}

function hw_options_page() { ?>
    <div>
        <h2>Homicide Watch settings</h2>
        <form action="options.php" method="post">

            <?php settings_fields('hwdc'); ?>
            <?php do_settings_sections('hwdc'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div> <?php
}


add_action('admin_init', 'hw_settings_init');
function hw_settings_init() {
    add_settings_section( 'hwdc', 'hwdc', 'hw_section_callback', 'hwdc');
    
    add_settings_field( 'frontend_url', 'Frontend URL',
        'hw_frontend_url_callback', 'hwdc', 'hwdc');
    register_setting('hwdc', 'frontend_url');
}

function hw_section_callback() {}

function hw_frontend_url_callback() {
    $option = get_option( 'frontend_url' );
    echo "<p><input type='text' value='$option' name='frontend_url' /></p>";
}
?>