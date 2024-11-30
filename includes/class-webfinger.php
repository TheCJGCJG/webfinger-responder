<?php
class Webfinger {
    public function init() {
        add_action('init', array($this, 'webfinger_callback'));
    }

    public function webfinger_callback() {
        $webfinger_path = get_option('webfinger_path', '/.well-known/webfinger');
        $issuer_url = get_option('issuer_url');
        $resource_regexps = get_option('resource_regexps', array('/./'));

        // Validate and sanitize REQUEST_URI
        // if this request were coming from Wordpress, we would also validate it has a nonce
        // but it is not, so we won't
        $request_uri = '';
        if (isset($_SERVER['REQUEST_URI'])) {
            $request_uri = wp_unslash(sanitize_text_field($_SERVER['REQUEST_URI']));
        }

        // Validate and sanitize resource parameter
        // if this request were coming from Wordpress, we would also validate it has a nonce
        // but it is not, so we won't
        $resource = '';
        if (isset($_GET['resource'])) {
            $resource = wp_unslash(sanitize_text_field($_GET['resource']));
        }

        if (str_starts_with($request_uri, $webfinger_path) && !empty($resource)) {
            $matches_pattern = false;
            foreach ($resource_regexps as $regex) {
                if (preg_match($regex, $resource)) {
                    $matches_pattern = true;
                    break;
                }
            }
            
            if (!$matches_pattern) {
                http_response_code(403);
                die('Forbidden');
            }

            $payload = array(
                "subject" => $resource,
                "links" => array(
                    array(
                        "rel" => "http://openid.net/specs/connect/1.0/issuer",
                        "href" => $issuer_url
                    )
                )
            );

            header('Content-Type: application/jrd+json');
            header('Access-Control-Allow-Origin: *');
            echo wp_json_encode($payload);
            exit;
        }
    }
}
