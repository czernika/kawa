# Kawa Framework

Developer-friendly framework for WordPress theme development with latte template engine and bedrock structure

[![Build Status](https://app.travis-ci.com/czernika/kawa.svg?token=dnoAxtq1npfjzQ8rFLq7&branch=master)](https://app.travis-ci.com/czernika/kawa)

## Todo

### General

- [x] Environment based settings
- [x] Dependency Injection Container
- [x] Service providers
- [x] Debugger
- [ ] App configuration

### Routing

- [x] Conditional tag routes
- [x] GET|POST|PATCH|PUT|DELETE|OPTIONS routes
- [x] Regex routes with custom patterns
- [x] Group routes (nested groups included - uri, name, controller namespace)
- [ ] Query filter for custom routes
- [ ] Redirect routes
- [ ] View routes
- [ ] Named routes
- [ ] Ajax routes
- [x] Controllers
- [ ] Correct response
- [ ] 404 / 200 fallbacks

### Middleware

- [ ] Middleware
- [ ] Middleware group
- [ ] Controller middleware

### Request

- [ ] FormRequest
- [ ] Request Validator
- [ ] Controller validator
- [ ] Bind request into routes

### Response

- [x] View Response
- [ ] Output Response
- [ ] Exception Response
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

- [ ] Create controller
- [ ] Create middleware
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