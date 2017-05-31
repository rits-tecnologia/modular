# Modular

[![Build Status](https://travis-ci.org/rits-tecnologia/modular.svg?branch=master)](https://travis-ci.org/rits-tecnologia/modular)
[![Coverage Status](https://coveralls.io/repos/github/rits-tecnologia/modular/badge.svg?branch=master)](https://coveralls.io/github/rits-tecnologia/modular?branch=master)
[![Code Climate](https://codeclimate.com/github/rits-tecnologia/modular/badges/gpa.svg)](https://codeclimate.com/github/rits-tecnologia/modular)
[![Total Downloads](https://poser.pugx.org/rits/modular/d/total.svg)](https://packagist.org/packages/rits/modular)
[![Latest Stable Version](https://poser.pugx.org/rits/modular/v/stable.svg)](https://packagist.org/packages/rits/modular)
[![Latest Unstable Version](https://poser.pugx.org/rits/modular/v/unstable.svg)](https://packagist.org/packages/rits/modular)
[![License](https://poser.pugx.org/rits/modular/license.svg)](https://packagist.org/packages/rits/modular)

Offers a easy way to modularize your laravel app.

## Installation

Require this package with composer:

```bash
composer require rits/modular
```

After updating composer, add the ModularServiceProvider to the providers array in config/app.php. Use vendor:publish command to create the configuration file.

```bash
php artisan vendor:publish --tag=rits/modular
```

## Usage

You can choose wherever you want to store your modules. In most cases app/Modules is a good choice. Create a class that extends the ModuleDefinition class, and add the class name in the modular.php config file.

Example:

- Create the app/Modules/Frontend/Module.php file;
- Create the class with the correct namespace and extend Rits\Modular\ModuleDefinition;
- Add App\Modules\Frontend\Module::class to the available array in the modular.php config file.

## Restrictions

All module's controllers must be in a Controllers folder in the module main directory.

## Roadmap

1. Create a command to easily create a new module;
2. Rewrite the README.md with better examples;
3. Provide a example repository.
