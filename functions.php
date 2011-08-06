<?php
add_filter('post_link', 'hw_set_frontend_permalink', 11, 3);
function hw_set_frontend_permalink($permalink, $post, $leavename) {
    $here = get_bloginfo('url');
    $there = get_option('frontend_url', '');
    $permalink = preg_replace('{'.$here.'}', $there, $permalink);
    return $permalink;
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