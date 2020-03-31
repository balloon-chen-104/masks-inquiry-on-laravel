# Masks Inquiry

This project can provide the masks information which is filtered by the area of user's input.

## Getting Started



### Prerequisites

This project is build in PHP with laravel framework and run on laradock. To install the project, you need to install PHP, [composer](https://getcomposer.org) and [docker](https://www.docker.com) first.

### Installing

After you clone the project, you can enter the root folder and install all packages.

```
masks-inquiry-on-laravel$ composer install
```

While I call internal api in some of PHP files, you need to edit your environment in your computer, but NOT in the project.

```
masks-inquiry-on-laravel$ sudo vim /etc/hosts
```
And add the following rows in the file.

```
# docker laradock nginx use
127.0.0.1 laravel.api
```

Next, copy the .env in laradoc.

```
masks-inquiry-on-laravel$ cd laradock
masks-inquiry-on-laravel/laradoc$ cp env.exemple .env
```

To run the server on localhost, you need to run the command below.

```
masks-inquiry-on-laravel/laradoc$ docker-compose up -d nginx mysql redis workspace 
```

Well done! You can see the default laravel website on 127.0.0.1

## Usage

We have two main websites.

* http://127.0.0.1/masks-inquiry
Which you can search masks infromation by area.
* http://127.0.0.1/api/documentation
Which you can see the api of swagger page that I called in /masks-inquiry.

## Author

* Balloon Chen
