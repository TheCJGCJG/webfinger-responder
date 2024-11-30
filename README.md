=== Webfinger Responder ===

Contributors: TheCJGCJG
Tags: webfinger, oidc
Requires at least: 6.0
Tested up to: 6.7
Stable tag: 1.0.0
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

1. Install the Plugin
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Settings, Webfinger
4. Update the Issuer URL
5. Update the Regex for `resource` - this will default to any resource "/./", which may be what you want

Regex examples
- `/acct:[a-zA-Z0-9. _%+-]+@example.co.uk/` - will allow any email under example.co.uk

== Frequently Asked Questions ==

= What is Webfinger? =

Webfinger is a protocol that allows for discovery of information about people and other entities on the Internet.

= Does this plugin require any additional configuration? =

Yes, you need to update your issuer URL

== Changelog ==

= 1.0.0 =
* Initial release
* Basic Webfinger protocol implementation
* Automatic user discovery support
