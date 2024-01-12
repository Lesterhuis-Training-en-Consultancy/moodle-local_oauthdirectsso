## local_oauthdirectsso

In brief, the MFreak mod `local_oauthdirectsso` redirects not logged users to a specific login url.
 
Special thanks to Gemma Lesterhuis ([Lesterhuis Training & Consultancy](https://ltnc.nl/)) for develop & design, useful input, bug reports and beta testing

![MFreak.nl](https://ldesignmedia.nl/logo_small.png)
![Lesterhuis Training & Consultancy](https://ldesignmedia.nl/logo_small_ltnc.png)

* Author: Luuk Verhoeven, [ldesignmedia.nl](https://ldesignmedia.nl/)
* Author: Gemma Lesterhuis, [Lesterhuis Training & Consultancy](https://ltnc.nl/)
* Min. required: Moodle 3.9.x
* Supports PHP: 7.2,7.3,7.4

![Moodle39](https://img.shields.io/badge/moodle-3.9-brightgreen.svg)
![PHP7.2](https://img.shields.io/badge/PHP-7.2-brightgreen.svg)

## List of features
- Global settings
- GDPR provider
- Separate login page `/local/oauthdirectsso/login.php`
- Redirect can be passed by adding `?wantsurl=https://moodle.lms.nl/course/view.php?id=1` 

## Installation
1.  Copy this plugin to the `local\oauthdirectsso` folder on the server
2.  Login as administrator
3.  Go to Site Administrator > Notification
4.  Install the plugin

## Security

If you discover any security related issues, please email [servicedesk@ltnc.nl](mailto:servicedesk@ltnc.nl) instead of using the issue tracker.

## License

Freeware -  Please see https://ltnc.nl/ltnc-plugin-freeware-licentie for more information.
