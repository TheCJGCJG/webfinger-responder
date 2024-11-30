=== Webfinger Responder ===

Contributors: TheCJGCJG
Tags: webfinger, oidc
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.2.0
License: GPLv2
License URI: https://github.com/TheCJGCJG/webfinger-responder/blob/main/LICENSE

A WordPress plugin that implements Webfinger protocol support for WordPress sites.

== Description ==

Webfinger Responder adds Webfinger protocol support to your WordPress site.

Features:
- Implements Webfinger protocol specification
- Automatic user discovery
- Compatible with ActivityPub and other Fediverse protocols
- Easy to configure and use
- Lightweight implementation

== Installation ==

1. Install the WordPress Webfinger Responder plugin through the WordPress plugin directory or by uploading the plugin files
2. Activate the plugin via the 'Plugins' menu in your WordPress dashboard
3. Go to Settings → Webfinger in your WordPress admin panel
4. Configure your RegEx patterns and corresponding responses

=== RegEx Pattern Configuration ===
1. Match any email address under a specific domain:
`acct:[a-zA-Z0-9._%+-]+@example.co.uk`

- john.doe@example.co.uk
- jane_smith123@example.co.uk
- any.user@example.co.uk

Provided it is prefixed with 'acct:'

2. Match a specific email address:
`hello@example.co.uk`
This pattern will only match the exact email address " hello@example.co.uk"

==== Response Behavior ====

The plugin uses a cumulative matching system for responses:

- When a resource query is made (e.g., "acct: hello@example.com"), the system checks all configured patterns
- If multiple patterns match the queried resource, ALL matching responses will be included in the final output

For example:
- If you have patterns for both example.co.uk (general) and hello@example.co.uk (specific)
- A query for "acct: hello@example.co.uk" will return responses from BOTH patterns

This allows you to set up both broad domain-wide responses and specific responses for individual addresses while combining them when appropriate.

== Frequently Asked Questions ==

= What is Webfinger? =

Webfinger is a protocol that allows for discovery of information about people and other entities on the Internet.

= Does this plugin require any additional configuration? =

Yes, you need to update your issuer URL

== Changelog ==

= 1.1.0 =
* Made responses entirely configurable by pattern

= 1.0.0 =
* Initial release
* Basic Webfinger protocol implementation
* Automatic user discovery support
