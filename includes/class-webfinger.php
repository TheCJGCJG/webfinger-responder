<?php
class Webfinger {
    public function init() {
        add_action('init', array($this, 'webfinger_callback'));
    }

    // Since this function is not going to be called by a normal form input, we don't necessarily expect there to be 
    // a nonce input, we would ordinarily generate one.
    function webfinger_callback() {
        $webfinger_path = get_option('webfinger_path', '/.well-known/webfinger');
        
        // Validate REQUEST_URI exists and sanitize it
        $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash(sanitize_text_field($_SERVER['REQUEST_URI'])) : '';
        
        // Check if this is a WebFinger request
        if (str_starts_with($request_uri, $webfinger_path) && isset($_GET["resource"])) {
            // Sanitize and unslash the resource parameter
            $resource = wp_unslash(sanitize_text_field($_GET['resource']));
            
            $resource_patterns = get_option('webfinger_resource_patterns', array());
            $response = array(
                'subject' => $resource,
                'links' => array()
            );
            
            // Check each pattern for a match
            foreach ($resource_patterns as $pattern_data) {
                if (preg_match('/' . str_replace('/', '\/', $pattern_data['pattern']) . '/', $resource)) {
                    // If pattern matches, add all associated links
                    if (isset($pattern_data['links']) && is_array($pattern_data['links'])) {
                        foreach ($pattern_data['links'] as $link) {
                            if (!empty($link['rel']) && !empty($link['href'])) {
                                // Only add the link if no rel parameter is specified
                                // or if the rel parameter matches the link's rel value
                                if (!isset($_GET['rel']) || $_GET['rel'] === $link['rel']) {
                                    $response['links'][] = array(
                                        'rel' => $link['rel'],
                                        'href' => $link['href']
                                    );
                                }
                            }
                        }
                    }
                }
            }
    
            // Send JSON response using WordPress function
            header('Content-Type: application/jrd+json');
            echo wp_json_encode($response);
            exit;
        }
    }
}
