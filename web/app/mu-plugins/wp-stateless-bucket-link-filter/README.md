![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)

# WP Stateless Bucket Link Filter

[![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-stateless-bucket-link-filter/v/stable)](https://packagist.org/packages/devgeniem/wp-stateless-bucket-link-filter)
[![Total Downloads](https://poser.pugx.org/devgeniem/wp-stateless-bucket-link-filter/downloads)](https://packagist.org/packages/devgeniem/wp-stateless-bucket-link-filter)
[![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-stateless-bucket-link-filter/v/unstable)](https://packagist.org/packages/devgeniem/wp-stateless-bucket-link-filter)
[![License](https://poser.pugx.org/devgeniem/wp-stateless-bucket-link-filter/license)](https://packagist.org/packages/devgeniem/wp-stateless-bucket-link-filter)

This WordPress **mu-plugin** enables filtering the Google Storage bucket link in the [WP Stateless Media Plugin](https://github.com/wpCloud/wp-stateless) with a PHP constant.

## Installation

Install with composer:

```shell
$ composer require devgeniem/wp-stateless-bucket-link-filter
```

## Usage

### WP_STATELESS_BUCKET_LINK_REPLACE

The bucket link in WP Stateless Media Plugin replaces all upload urls. Define this constant to replace the default bucket link `https://storage.googleapis.com/{bucket-name}/`.

**Example:**

```
// This will set the bucket link point to 'https://my-test-site.test/uploads/'
define( 'WP_STATELESS_BUCKET_LINK_REPLACE', 'https://my-test-site.test/uploads' );
```

