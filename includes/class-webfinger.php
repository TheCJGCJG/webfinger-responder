<?php
class Webfinger {
    public function init() {
        add_action('init', array($this, 'webfinger_callback'));
    }

    function webfinger_callback() {
        $webfinger_path = get_option('webfinger_path', '/.well-known/webfinger');
        
        // Check if this is a WebFinger request
        if (str_starts_with($_SERVER['REQUEST_URI'], $webfinger_path) && isset($_GET["resource"])) {
            $resource = $_GET['resource'];
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
    
            // Send JSON response
            header('Content-Type: application/jrd+json');
            echo json_encode($response);
            exit;
        }
    }
    

}
