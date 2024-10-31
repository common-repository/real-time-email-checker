<?php
function ec_display_contents()
{
    $options = get_option('ec_array');
    ?>
    <?php
    if (isset($_GET['m']) && $_GET['m'] == '1')
        echo "<div id='message' class='updated fade'><p><strong>You have successfully updated your API key.</strong></p></div>";
    if (isset($_GET['m']) && $_GET['m'] == '0')
        echo "<div id='message' class='updated fade'><p><strong>You have entered an invalid API key.</strong></p></div>";


    ?>
    <div class="wrap"><br><br><br><br><br>
        <center><h2>Email Checker Settings</h2><br>
            <form method="post" action="admin-post.php">
                <input type="hidden" name="action" value="ec_save_validator_option"/>
                <?php wp_nonce_field('ec_verify'); ?>
                API Key : <input type="text" name="api_key" value="<?php echo esc_html($options['ec_apikey']); ?>"
                                 size="40"/>
                <br/><br>
                <input type="submit" value="Validate API Key and Save" class="button-primary"/><br><br>
                <a href="https://www.emailchecker.io/" target="_blank">Need a API key?</a>
            </form>
        </center>
    </div>
    <?php
}

?>