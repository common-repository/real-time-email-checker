<?php
function ec_add_admin_menu()
{
    add_submenu_page('options-general.php', 'Email Checker', 'Email Checker', 'manage_options', __FILE__ . '_display_contents', 'ec_display_contents');
}

?>