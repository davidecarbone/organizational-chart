# Organizational chart API

A simple API to list company organizational charts.

## Getting Started

### Installing

You can use docker-compose to build a container network with all requirements:
```
$ docker-compose up -d
```

This will run three containers with:
 - the main web application
 - a MySQL database
 - an admin web interface for the database
 
The web container will also execute migrations to provide the chart nodes structure.

### Usage
This API provides a single endpoint to get all child nodes of a given parent node:
```
GET /nodes/{nodeId}/children
```

Params:

The following params are accepted in the querystring:
- language (string, required) - language identifier. Possible values: "english", "italian";
- search_keyword (string, optional) - a search term used to filter results;
- page_num (integer, optional) - the 0-based identifier of the page to retrieve. If not provided, defaults to “0”;
- page_size (integer, optional) - the size of the page to retrieve, ranging from 0 to 1000. If not provided, defaults to “100”.

Example:
```
GET http://localhost:8080/nodes/5/children?language=english
```

## Running the tests

To run unit tests simply run from the project root:
```
$ vendor/bin/phpunit
```

Integration and End2end tests are not run by default. To run them:
```
$ vendor/bin/phpunit --testsuite end2end
```

## Disclaimer
This is a case study and it's not meant for production! Even though some basic validation is provided, this code is not suitable for a production environment.

## Built With
* PHP 7
* [MySQL](https://www.mysql.com/)

## Authors
* **Davide Carbone** - *Initial work* - [Davide Carbone](https://github.com/davidecarbone)

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
