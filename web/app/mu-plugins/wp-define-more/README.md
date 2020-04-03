![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)
# WP Plugin: Define More
[![Build Status](https://travis-ci.org/devgeniem/wp-define-more.svg?branch=master)](https://travis-ci.org/devgeniem/wp-define-more) [![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-define-more/v/stable)](https://packagist.org/packages/devgeniem/wp-define-more) [![Total Downloads](https://poser.pugx.org/devgeniem/wp-define-more/downloads)](https://packagist.org/packages/devgeniem/wp-define-more) [![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-define-more/v/unstable)](https://packagist.org/packages/devgeniem/wp-define-more) [![License](https://poser.pugx.org/devgeniem/wp-define-more/license)](https://packagist.org/packages/devgeniem/wp-define-more)

WordPress contains multiple nice options which you can set with `define()`.

You can see good list of all them here: http://wpengineer.com/2382/wordpress-constants-overview/

This plugin adds even more stuff you can `define()`.

## Current custom definable variables

### WP_UPLOADS_MAX_SIZE
`WP_UPLOADS_MAX_SIZE`  - Set this to tell WordPress maximum uploads size. This is useful to tell /wp-admin/media.php javascript the maximum filesize in case your WordPress is running behind reverse proxy.

**Example:**

```php
define('WP_UPLOADS_MAX_SIZE','10M');
```

### WP_UPLOADS_DIR
`WP_UPLOADS_DIR` - Set custom directory for your uploads. This helped us to use glusterfs to synchronize only uploads folder between multiple nodes. It was too heavy process and much too unreliable to sync everything.

**Example:**
```php
define('WP_UPLOADS_DIR','/var/www/uploads');
```

### WP_UPLOADS_URL
`WP_UPLOADS_URL` - Set custom url for your uploads. We used this for mapping custom `http://wordpress.test/uploads/` url with custom nginx `root` to `WP_UPLOADS_DIR`.

**Example:**
```php
define('WP_UPLOADS_URL', WP_SITEURL . '/uploads/');
```
