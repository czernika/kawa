# Kawa Framework

Developer-friendly framework for WordPress theme development with latte template engine and bedrock structure

[![Build Status](https://app.travis-ci.com/czernika/kawa.svg?token=dnoAxtq1npfjzQ8rFLq7&branch=master)](https://app.travis-ci.com/czernika/kawa)

## Docs

[In progress](https://czernika.github.io/kawa-docs/)

## Why Kawa

To simplify development workflow in Laravel-like way, for example

### Routing Example

**Native:**

Using templates only and pages within admin-panel, no middleware

**With Kawa:**

Create own routes or use native WordPress callables

```php
Route::isFrontPage([Controller::class, 'method']);
Route::get('/foo', fn() => 'Hello From Foo')->middleware('bar');
```

### The Loop Example

**Native:**

```php
<?php if($posts->have_posts()) : ?>
  <ul>
    <?php while($posts->have_posts()) :
      $posts->the_post(); ?>
      <li>
        <?php the_title(); ?>
      </li>
    <?php endwhile;
    wp_reset_postdata(); ?>
  </ul>
<?php endif; ?>
```

**With Kawa (using Latte):**

> Planning support for both blade and twig template engines, and Timber as extra framework

```php
<ul n:ifcontent>
  <li n:foreach="$posts as $post">
    {$post->title}
  </li>
</ul>
```

## Installation

### With Composer

```bash
composer create project czernika/kawa
```

### With Docker

```bash
docker run --rm --interactive --tty \
    --volume $PWD:/app \
    --user $(id -u):$(id -g) \
    composer create-project czernika/kawa:dev-master <project-dir>
```

## Getting Started

Fill `.env` with correct for local development environment

### With Docker

Run `docker compose up -d`

All interactive commands available under `docker exec -it kawa <command>` like

```bash
docker exec -it kawa composer require some/package
docker exec -it kawa npm install npm-package
docker exec -it kawa wp plugin list
docker exec -it kawa php bin/kawa new:controller SomeController
docker exec -it kawa bash
```

To create database run (if `.env` filled in)

```bash
docker exec -it kawa wp db create
```

Or simply using MySQL commands

### On Local Server

Basically same as production deployment

## Production Deployment

Fill `.env` with correct information for production server

Document root for your server must be pointed into `web` directory. More about configuration files can be found [here](https://docs.roots.io/bedrock/master/server-configuration/)

Create `wp-cli.local.yml` file with any production configuration but at least with

```yml
path: web/wp
server:
  docroot: web
```

## Tests

Run `./vendor/bin/phpunit`

## License

Runs under MIT license

## Todo

### General

- [x] Environment based settings
- [x] Dependency Injection Container
- [x] Service providers
- [x] Debugger
- [x] App configuration
- [x] Docker compose (PHP 8.0, Nginx, Mysql, Phpmyadmin, Composer, WP Cli, NodeJS, Mailhog)
- [x] Error handler
- [ ] Maintenance mode
- [ ] Hello World styling
- [ ] Branding
- [ ] Docker executable alias

### Routing

- [x] Conditional tag routes
- [x] GET|POST|PATCH|PUT|DELETE|OPTIONS routes
- [x] Regex routes with custom patterns
- [x] Group routes (nested groups included - uri, name, controller namespace)
- [ ] Query filter for custom routes
- [x] Redirect routes
- [x] View routes
- [x] Named routes
- [ ] Ajax routes
- [x] Controllers
- [x] Route middleware
- [x] Group route middleware
- [ ] Correct response
- [ ] 404 / 200 fallbacks

### Middleware

- [x] Middleware
- [x] Middleware group
- [x] Controller middleware
- [ ] Auth Policies

### Request

- [ ] FormRequest
- [ ] Request Validator
- [ ] Old input
- [ ] Controller validator
- [x] Bind request into routes

### Response

- [x] View Response
- [ ] Output Response
- [x] Exception Response
- [x] Basic Redirect Response
- [ ] Advanced Redirect Response and helpers (to, url, route, with, flash)
- [ ] JSON Response
- [ ] Session
- [ ] Flash messages

### Models

- [x] Post Type model attributes
- [ ] Post type meta fields as attributes
- [ ] Post type taxonomy relations
- [ ] Post type thumb
- [x] Post type author
- [ ] Taxonomy model
- [ ] Taxonomy meta fields as attributes
- [ ] Model registration
- [ ] Users
- [ ] User meta fields as attributes
- [ ] Authenticatable model
- [ ] Comments
- [ ] Comments meta fields as attributes
- [ ] Attachments
- [ ] Metaboxes (Carbon Fields)
- [ ] Metaboxes (ACF)
- [ ] CRUD

### Queries

- [x] Simple queries
- [ ] Advanced queries
- [ ] Loop
- [ ] Reflection API for Routes parameters
- [ ] Raw DB queries
- [ ] Site options

### Front-end

- [ ] Assets compiler
- [ ] Assets optimization and sourcemaps
- [ ] SVG icons and spritemap
- [ ] Images optimization
- [ ] Localization
- [x] Latte template engine
- [ ] Twig template engine
- [ ] Blade template engine
- [ ] Timber support
- [ ] Menus
- [x] List pagination
- [x] Links pagination
- [x] Pagination builder with arguments
- [ ] Customizer sections (Kirki Framework)
- [ ] Theme mods
- [ ] Gutenberg block (Carbon Fields)
- [ ] Global context (view composers)
- [ ] Custom Templates
- [ ] Shortcode

### Mailing

- [ ] Mailer
- [ ] Mailable
- [ ] Notifiers

### API and GraphQL

- [ ] API routes
- [ ] Http API
- [ ] Rest API
- [ ] WPGraphQL
- [ ] Resources (DTO)

### Console commands

- [x] Create controller
- [x] Create middleware
- [ ] Create request
- [ ] Create customizer section
- [ ] Create customizer panel
- [ ] Create menu
- [ ] Create post type model
- [ ] Create taxonomy model
- [ ] Create service provider
- [ ] Cache config
- [ ] Clear cache

### Cron

- [ ] Events
- [ ] Listeners
- [ ] Jobs

### Plugins and core

- [ ] WooCommerce
- [ ] Polylang
- [ ] Multisite
- [ ] Block theme

Child themes will **NOT** be tested as it is not the purpose of this framework. Theme will be created by developer itself
