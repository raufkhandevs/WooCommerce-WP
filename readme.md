# WordPress ReadMe

![WordPress Logo](wp-admin/images/wordpress-logo.png)

Semantic Personal Publishing Platform

## First Things First

Welcome to WordPress! Every developer and contributor adds something unique to the mix, and together we create something beautiful. Thank you for making it part of your world.

— Matt Mullenweg

## Installation: Famous 5-minute install

1. Unzip the package in an empty directory and upload everything.
2. Open [wp-admin/install.php](wp-admin/install.php) in your browser. It will guide you through setting up a `wp-config.php` file with your database connection details.
   - If it doesn't work, open `wp-config-sample.php`, fill in your database details, save it as `wp-config.php`, and upload it.
   - Open [wp-admin/install.php](wp-admin/install.php) in your browser again.
3. The installer will set up the tables needed for your site. If there is an error, double-check your `wp-config.php` file, and try again. If it fails, visit the [WordPress support forums](https://wordpress.org/support/forums/).
4. If you did not enter a password, note the password given to you. If you did not provide a username, it will be `admin`.
5. The installer should then send you to the [login page](wp-login.php). Sign in with the username and password you chose during the installation.

## Updating

### Using the Automatic Updater

1. Open [wp-admin/update-core.php](wp-admin/update-core.php) in your browser and follow the instructions.
2. That's it!

### Updating Manually

1. Before updating, make sure you have backup copies of modified files (e.g., `index.php`).
2. Delete your old WordPress files, saving ones you've modified.
3. Upload the new files.
4. Point your browser to [wp-admin/upgrade.php](wp-admin/upgrade.php).

## Migrating from other systems

WordPress can [import from a number of systems](https://wordpress.org/documentation/article/importing-content/). First, get WordPress installed and working, then use [our import tools](wp-admin/import.php).

## System Requirements

- [PHP](https://secure.php.net/) version **7.0** or greater.
- [MySQL](https://www.mysql.com/) version **5.0** or greater.

### Recommendations

- [PHP](https://secure.php.net/) version **7.4** or greater.
- [MySQL](https://www.mysql.com/) version **5.7** or greater OR [MariaDB](https://mariadb.org/) version **10.4** or greater.
- [mod_rewrite](https://httpd.apache.org/docs/2.2/mod/mod_rewrite.html) Apache module.
- [HTTPS](https://wordpress.org/news/2016/12/moving-toward-ssl/) support.
- A link to [wordpress.org](https://wordpress.org/) on your site.

## Online Resources

- [HelpHub](https://wordpress.org/documentation/): The encyclopedia of all things WordPress.
- [The WordPress Blog](https://wordpress.org/news/): Latest updates and news.
- [WordPress Planet](https://planet.wordpress.org/): News aggregator from WordPress blogs.
- [WordPress Support Forums](https://wordpress.org/support/forums/): Active community for support.
- [WordPress IRC Channel](https://make.wordpress.org/support/handbook/appendix/other-support-locations/introduction-to-irc/): Online chat channel for discussion. (irc.libera.chat #wordpress)

## Final Notes

- For suggestions, ideas, or bug reports, join us in the [Support Forums](https://wordpress.org/support/forums/).
- WordPress has a robust [Plugin API](https://developer.wordpress.org/plugins/) for developers. Don't modify the core code.

## Share the Love

WordPress has no multi-million dollar marketing campaign, but we have something better — you. If you enjoy WordPress, consider telling a friend, setting it up for someone less knowledgeable, or writing about it.

WordPress is the official continuation of [b2/caf&eacute;log](https://cafelog.com/), continued by the [WordPress developers](https://wordpress.org/about/). To support WordPress, consider [donating](https://wordpress.org/donate/).

## License

WordPress is free software, released under the terms of the [GPL (GNU General Public License)](license.txt) version 2 or any later version.
