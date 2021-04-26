# ftp-filemanager

A web based FTP client application to manage your FTP files, built with a simple MVC architecture, no frameworks or libraries are used (except my owns).

![](https://user-images.githubusercontent.com/49124992/93536723-9d91f400-f941-11ea-86c4-2f942f00b842.gif)

## Features
* Download & upload.
* CRUD operations.
* Move file & folder.
* Rename file & folder.
* Search for files.
* Change file permissions.
* View file details.

## Requirements

* php >= 5.5.0
* Apache rewrite module enabled.

## Dependencies

This application uses :
* [php-ftp-client](https://github.com/lazzard/php-ftp-client) : A library that's wraps the PHP FTP extension functions in an oriented objet way. 
* [filemanager-template](https://github.com/ELAMRANI744/filemanager-template) : A filemanager template that's offer a clean interface, and some other important features.

## How to setup this project

Download the repo or clone it using git:

```
git clone https://github.com/ELAMRANI744/ftp-filemanager
```

Then install composer dependencies :

```
composer install
```

## Deployment

1. Move project files to the production server folder (tipically `public_html` folder).
2. Install the application dependencies (install composer dependencies).
3. Disable the debugging mode in `config/app.php`, and you ready to start.

## Development

For development environment, you need to install npm dependencies (You need also install composer dependencies):

```
npm install
```

## Worth knowing about this project MVC architecture

Before the development process, one of the requirements was building an application that's based on MVC pattern without using any of the existing frameworks (Laravel, Symfony ...), for that I have started with this [tutorial](https://github.com/PatrickLouys/no-framework-tutorial) (Thanks for the author), this tutorial was a great place to understand the MVC pattern and know how the biggest frameworks actually works, however this Tuto uses some of others components that's necessary for every MVC application, and in this point i've decided to not use any of them, but instead trying to understand the basic concepts for each of them, and attempt to build my own components (light and simple ones for this time) - you can find them in the `lib` folder.

## Concepts

This is a full stack project, a lot of things covered here either in front end or backend part, however the project covered this web programming techniques : 

* Design UI/UX
    * This project is designed taking into consideration the UI/UX approach, you can check the design muckop in [behance](https://www.behance.net/gallery/104400253/FTP-Client-web-application).

* Web integration :
	* Using css preprocessors (SASS).
	* Vanilla javascript (trying to make a clean code).
	* Using AJAX (Fetch API & XMLHttpRequest).
	* Using some of ES6 features.
	* Using Gulp Task runner.

* Server side development : 
    * Dependency injection container (The base Controller injection).
    * Basic Http component to simulate Http requests and responses.
    * A very simple template renderer (To separate Php code from Html - Using PHP Raw Templating).
    * A basic routing component (The hard part for me).
    * PHP session management & some of security concerns.
    * Handling PHP errors & exceptions.
    * SOLID principles.
    * Dependency injection.
    * The Front controller pattern.
  
## Contribution

All contributions are welcome, for a features ideas check the `TODO.md` file. Thank you. 

