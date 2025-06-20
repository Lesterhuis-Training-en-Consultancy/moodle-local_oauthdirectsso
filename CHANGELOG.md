# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)

# Plugin version.php information
```php
// Plugin release number corresponds to the lasest tested Moodle version in which the plugin has been tested.
$plugin->release = '3.5.7'; // [3.5.7]

// Plugin version number corresponds to the latest plugin version.
$plugin->version = 2019010100; // 2019-01-01
```

# How do I make a good changelog?
Guiding Principles
* Changelogs are for humans, not machines.
* There should be an entry for every single version.
* The same types of changes should be grouped.
* The latest version comes first.
* The release date of each version is displayed.

Types of changes
* **Added** for new features.
* **Changed** for changes in existing functionality.
* **Deprecated** for soon-to-be removed features.
* **Removed** for now removed features.
* **Fixed** for any bug fixes.
* **Security** in case of vulnerabilities.


# Version (4.5.3) - 2025-06-20
### Added
- Implemented event-based approach for profile field processing to fix timing issues when filling profile fields
- Ensured high event priority to guarantee proper execution order
### Changed
- Replaced before_http_headers hook with standard Moodle events for better compatibility
- Simplified code for better maintainability
- Removed dependency on cookies for OAuth issuer ID tracking
- Improved logging and debugging capabilities
- Enhanced version compatibility across Moodle 4.1-4.5
- Fixed timing issues when filling profile fields

# Version (4.5.1) - 2025-02-20
- Add new option that allows setting a value to profile field if this wasn't enabled #10
- Support for processing multiple OAuth2 linked accounts per user

# Version (4.5.0) - 2024-09-13
- Tested Moodle 4.5

# Version (4.2 v2) - 2024-04-02
- Add support for legacy configuration.
- Loads configuration in a 'Legacy configuration' link inside the oauth table overview.
- Possible to update.
- When the legacy configuration is emptied login.php will no longer be work without a provided id.

# Version (4.2) - 2024-01-15
- Add support for multiple OAuth providers. 
- Please be aware this update is a breaking change for environments that already have this plugin installed. 
For continued access, it is essential to re-select your existing OAuth and the Restricted IP addresses.
- Tested on PHP 8.2
- Tested in Moodle 4.2

# Version (4.1) - 2023-04-13
- Tested PHP 8.0
- Tested Moodle 4.1
- version Bump

# Version (4.0) - 2022-05-26
- Tested PHP 7.4
- Tested Moodle 4.0
- version Bump

# Version (3.9) - 2020-12-15

### Fixed
- Wantsurl was not working when already logged in

# Version (3.9) - 2020-07-02

### Added
- Build the first version of the plugin
