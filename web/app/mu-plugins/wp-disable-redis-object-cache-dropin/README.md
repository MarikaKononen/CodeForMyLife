![geniem-github-banner](https://cloud.githubusercontent.com/assets/5691777/14319886/9ae46166-fc1b-11e5-9630-d60aa3dc4f9e.png)
# Redis Object Cache for WordPress Disabling Handler
[![Latest Stable Version](https://poser.pugx.org/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler/v/stable)](https://packagist.org/packages/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler) [![Total Downloads](https://poser.pugx.org/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler/downloads)](https://packagist.org/packages/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler) [![Latest Unstable Version](https://poser.pugx.org/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler/v/unstable)](https://packagist.org/packages/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler) [![License](https://poser.pugx.org/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler/license)](https://packagist.org/packages/devgeniem/wp-disable-redis-object-cache-dropin-disable-handler)

This WordPress mu-plugin controls disabling the [Redis Object Cache for WordPress](https://github.com/devgeniem/wp-redis-object-cache-dropin) dropin at various occasions.

The plugin currently supports disabling the Redis while previewing a WordPress article or page. If you want to extend the disabling functionality to other events, please write an issue about it or make a pull request.

## Installation

```
$ composer require devgeniem/wp-disable-redis-object-cache-dropin
```

## Disabling events

### Preview

Read and write requests to the Redis cache should be prevented while a user is previewing an article or a page. This is done by disabling the Redis connection altogether by returning a false value with the object cache dropin's `redis_object_cache_redis_status`.

Note that the disabling starts after the global WP query is set thus enabling initial cache functions like options loading and updating.

## License

GPLv3

## Maintainers
- [@villesiltala](https://github.com/villesiltala)