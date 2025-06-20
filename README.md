## local_oauthdirectsso

In brief, the LTNC `local_oauthdirectsso` redirects not logged users to a specific OAuth 2 login url and supports profile field auto-filling.
 
![Lesterhuis Training & Consultancy](https://ltnc.nl/wp-content/uploads/2025/04/LTNC_fc_pos_zwart.png)


* Author: Luuk Verhoeven, [ldesignmedia.nl](https://ldesignmedia.nl/)
* Author: Gemma Lesterhuis, [Lesterhuis Training & Consultancy](https://ltnc.nl/)
* Min. required: Moodle 4.1.x
* Supports PHP: 7.4 through 8.2

![Moodle41](https://img.shields.io/badge/moodle-4.1-brightgreen.svg)
![Moodle42](https://img.shields.io/badge/moodle-4.2-brightgreen.svg)
![Moodle43](https://img.shields.io/badge/moodle-4.3-brightgreen.svg)
![Moodle44](https://img.shields.io/badge/moodle-4.4-brightgreen.svg)
![Moodle45](https://img.shields.io/badge/moodle-4.5-brightgreen.svg)

![PHP7.4](https://img.shields.io/badge/PHP-7.4-brightgreen.svg)
![PHP8.2](https://img.shields.io/badge/PHP-8.2-brightgreen.svg)

## List of features
- Overview and settings can be found under the 'Server' tab in admin settings (Oauth 2 direct SSO).
- GDPR provider
- Separate login page `/local/oauthdirectsso/login.php?id=x` where `x` will be replaced with the linked OAuth service id
- Redirect can be passed by adding `&wantsurl=https://moodle.lms.nl/course/view.php?id=1`
- IP restrictions can be set for each OAuth provider.
    - This goes to the Moodle core `address_in_subnet()` function specifications:
      - 1: `xxx.xxx.xxx.xxx/nn` or `xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx/nnn`          (number of bits in net mask)
      - 2: `xxx.xxx.xxx.xxx-yyy` or  `xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx::xxxx-yyyy` (a range of IP addresses in the last group)
      - 3: `xxx.xxx or xxx.xxx.` or `xxx:xxx:xxxx` or `xxx:xxx:xxxx.`                (incomplete address, a bit non-technical ;-)
- **NEW**: Automatic profile field filling for OAuth2 users
- **NEW**: Compatible with various enrollment plugins through standard Moodle events
- **NEW**: Supports both standard user fields and custom profile fields

![Admin](pix/admin.png)
![Overview](pix/overview.png)
![Add](pix/add.png)

## Installation
1.  Copy this plugin to the `local\oauthdirectsso` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin

## Integration with enrollment plugins

This plugin uses Moodle's standard event system to provide seamless integration with various enrollment methods:

1. **High-priority event listeners**: The plugin registers event listeners with a high priority (10000) to ensure profile fields are processed before other plugins handle the events.

2. **Standard Moodle events**: After updating profile fields, the plugin triggers the standard `user_updated` event that enrollment plugins can listen for.

3. **Compatible with multiple enrollment methods**: Works with any enrollment plugin that listens to standard Moodle events, including `enrol_attributes`, `enrol_auto`, `local_profilecohort`, and others. We use Moodle's core events (user_created and user_loggedin) to update profile fields, making it compatible with virtually all enrollment methods that follow Moodle standards.

4. **No special configuration needed**: Other plugins don't need to be modified to work with OAuth2 Direct SSO, as long as they follow Moodle standards.

This event-based approach ensures that profile fields are available to enrollment plugins immediately after login, solving timing issues that could occur with other implementations.

## Bug and Problem support

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.
If you discover any security related issues, please email [servicedesk@ltnc.nl](mailto:servicedesk@ltnc.nl) instead of using the issue tracker.

Please bear in mind that bug and problem support is not free of charge. This is with the exception of developers that report and suggest a solution by creating a pull request. 
Support is included for customers with an active LTNC Moodle Addon Maintenance Program subscription. For more information send an email to [sales@ltnc.nl](mailto:sales@ltnc.nl)

## Feature proposal
We are aware that members of the community will have other needs and would love to see them solved by this plugin. We are always interested to read about your feature proposals or even get a pull request from you, but please understand that we handle these as feature proposals and not as feature requests that we commit to implementing.

If you would like to see your feature proposal developed and included in our code base, please send an email to [sales@ltnc.nl](mailto:sales@ltnc.nl) with your suggestion so we can send you a formal proposal for paid development. 

Please bear in mind that new features will only be added to Main Branch and only for Moodle versions that are in Current Stable release states (see [Moodle Release](https://moodledev.io/general/releases) for more information).

Customers with an active LTNC Moodle Addon Maintenance Program subscription may receive priority consideration for their feature proposals.

## License

Local Oauthdirectsso code is provided freely as open source software, under version 3 of the GNU General Public License.
