# Initvel

Initvel is a Laravel package that simplifies the process of setting up multilingual support for your Laravel application.

## Features

- **Define the project languages**: Create dedicated folders for static translations and add default values to simplify the start.
- **Facilitate language management**: Provide easy methods to display available languages and switch the website's language seamlessly.
- **Set up resource files**: Create an assets folder containing `JavaScript`, `CSS`, `images`, and `fonts` files, and link them to the website for quick setup.
- **Organize project structure**: Create folders such as `layouts`, `components`, and some basic `views` to establish a well-organized project foundation.
- **Build central controllers**: Design a `controller` to manage the core operations of the project.
- **Set up Middleware**:
  - A `Middleware` for handling the language.
  - Another `Middleware` for caching, to be activated later after development is complete.
  - Register the middleware considering the different registration methods in Laravel versions.
**Create routes**: Define the `routes` for the website pages to ensure smooth navigation.

---

## Installation

### 1. Install the Package

#### You can install the package via Composer by running the following command in your Laravel project:

```bash
composer require devs/initvel
```

### 2. Setup Languages

#### You can set up the languages by running the following command, replacing `en`, `fr`, `ar`, etc., with the languages you'd like to use:

```bash
php artisan initvel:setup-langs en fr ar
```

(This command will create the **necessary** language **directories** and files in your project.)

### 3. Setup Configurations

#### To set up all necessary files and configurations at once, run the following command:

```bash
php artisan initvel:setup-all
```

(This command will publish **assets**, **language files**, and **configurations** to your main project.)

---