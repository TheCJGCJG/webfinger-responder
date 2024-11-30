<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
        <?php
        settings_fields('webfinger_options');
        do_settings_sections('webfinger_options');
        
        // Get saved patterns or initialize empty array
        $resource_patterns = get_option('webfinger_resource_patterns', array());
        ?>
        
        <h2>WebFinger Path</h2>
        <input type="text" 
               name="webfinger_path" 
               value="<?php echo esc_attr(get_option('webfinger_path', '/.well-known/webfinger')); ?>" 
               class="regular-text">

        <h2>Resource Patterns and Links</h2>
        <div id="patterns-container">
            <?php foreach ($resource_patterns as $index => $pattern_data): ?>
                <div class="pattern-entry">
                    <h3>Pattern</h3>
                    <input type="text" 
                           name="webfinger_resource_patterns[<?php echo $index; ?>][pattern]" 
                           value="<?php echo esc_attr($pattern_data['pattern']); ?>"
                           class="regular-text">
                    
                    <h4>Links</h4>
                    <div class="links-container">
                        <?php foreach ($pattern_data['links'] as $link_index => $link): ?>
                            <div class="link-entry">
                                <input type="text" 
                                       name="webfinger_resource_patterns[<?php echo $index; ?>][links][<?php echo $link_index; ?>][rel]" 
                                       value="<?php echo esc_attr($link['rel']); ?>" 
                                       placeholder="Relation (rel)" 
                                       class="regular-text">
                                <input type="text" 
                                       name="webfinger_resource_patterns[<?php echo $index; ?>][links][<?php echo $link_index; ?>][href]" 
                                       value="<?php echo esc_attr($link['href']); ?>" 
                                       placeholder="URL (href)" 
                                       class="regular-text">
                                <button type="button" class="button remove-link">Remove Link</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="button add-link">Add Link</button>
                    <button type="button" class="button remove-pattern">Remove Pattern</button>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="button" id="add-pattern">Add Pattern</button>
        <?php submit_button(); ?>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Create HTML for a new link
    function createLinkHTML(patternIndex, linkIndex) {
        return `
            <div class="link-entry">
                <input type="text" 
                       name="webfinger_resource_patterns[${patternIndex}][links][${linkIndex}][rel]" 
                       placeholder="Relation (rel)" 
                       class="regular-text">
                <input type="text" 
                       name="webfinger_resource_patterns[${patternIndex}][links][${linkIndex}][href]" 
                       placeholder="URL (href)" 
                       class="regular-text">
                <button type="button" class="button remove-link">Remove Link</button>
            </div>
        `;
    }

    // Create HTML for a new pattern
    function createPatternHTML() {
        const patternIndex = $('.pattern-entry').length;
        return `
            <div class="pattern-entry">
                <h3>Pattern</h3>
                <input type="text" 
                       name="webfinger_resource_patterns[${patternIndex}][pattern]" 
                       class="regular-text">
                <h4>Links</h4>
                <div class="links-container">
                    ${createLinkHTML(patternIndex, 0)}
                </div>
                <button type="button" class="button add-link">Add Link</button>
                <button type="button" class="button remove-pattern">Remove Pattern</button>
            </div>
        `;
    }

    // Add new pattern
    $('#add-pattern').click(function() {
        $('#patterns-container').append(createPatternHTML());
    });

    // Add new link to pattern
    $(document).on('click', '.add-link', function() {
        const $pattern = $(this).closest('.pattern-entry');
        const patternIndex = $('.pattern-entry').index($pattern);
        const linkIndex = $pattern.find('.link-entry').length;
        $pattern.find('.links-container').append(createLinkHTML(patternIndex, linkIndex));
    });

    // Remove link
    $(document).on('click', '.remove-link', function() {
        $(this).closest('.link-entry').remove();
    });

    // Remove pattern
    $(document).on('click', '.remove-pattern', function() {
        $(this).closest('.pattern-entry').remove();
    });
});
</script>
