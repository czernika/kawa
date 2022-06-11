# Kawa Framework

Developer-friendly framework for WordPress theme development with latte template engine and bedrock structure

[![Build Status](https://app.travis-ci.com/czernika/kawa.svg?token=dnoAxtq1npfjzQ8rFLq7&branch=master)](https://app.travis-ci.com/czernika/kawa)

## Docs

[In progress](https://czernika.github.io/kawa-docs/)

## Installation

This package will be separated on core package, some helper packages for template engines and console generator. Primary app will be created as composer project to be installed like

```sh
composer create project czernika/kawa
```

## Getting Started

Fill `.env` with correct for local development environment

### With Docker

Run `docker compose up -d`

All interactive commands available under `docker exec -it kawa <command>` like

```sh
docker exec -it kawa composer require some/package
docker exec -it kawa npm install npm-package
docker exec -it kawa wp plugin list
docker exec -it kawa php bin/kawa new:controller SomeController
docker exec -it kawa bash
```

To create database run (if `.env` filled in)

```sh
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

### Routing

- [x] Conditional tag routes
- [x] GET|POST|PATCH|PUT|DELETE|OPTIONS routes
- [x] Regex routes with custom patterns
- [x] Group routes (nested groups included - uri, name, controller namespace)
- [ ] Query filter for custom routes
- [ ] Redirect routes
- [ ] View routes
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
- [ ] Controller middleware

### Request

- [ ] FormRequest
- [ ] Request Validator
- [ ] Controller validator
- [x] Bind request into routes

### Response

- [x] View Response
- [ ] Output Response
- [x] Exception Response
- [ ] Redirect Response
- [ ] JSON Response

### Models

- [ ] Post Type models
- [ ] Taxonomy models
- [ ] Model registration
- [ ] Users
- [ ] Authenticated model
- [ ] Comments
- [ ] Attachments
- [ ] Metaboxes (Carbon Fields)
- [ ] Metaboxes (ACF)
- [ ] CRUD

### Queries

- [ ] Simple queries
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
- [ ] Pagination
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
- [ ] Multisite
- [ ] Block theme

Child themes will **NOT** be tested as it is not the purpose of this framework. Theme will be created by developer itself
