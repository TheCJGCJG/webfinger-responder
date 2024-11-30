<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php settings_fields('webfinger_options'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="webfinger_path">Webfinger Path</label>
                </th>
                <td>
                    <input type="text" id="webfinger_path" name="webfinger_path" 
                           value="<?php echo esc_attr($webfinger_path); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="issuer_url">Issuer URL</label>
                </th>
                <td>
                    <input type="url" id="issuer_url" name="issuer_url" 
                           value="<?php echo esc_url($issuer_url); ?>" class="regular-text">
                </td>
            </tr>
            <tr>
                <th scope="row">Resource RegExps</th>
                <td>
                    <div id="regexp-container">
                        <?php foreach ($resource_regexps as $index => $regexp): ?>
                            <div class="regexp-entry">
                                <input type="text" name="resource_regexps[]" 
                                       value="<?php echo esc_attr($regexp); ?>" class="regular-text">
                                <button type="button" class="button remove-regexp">Remove</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button" id="add-regexp">Add RegExp</button>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
