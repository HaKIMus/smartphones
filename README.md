# smartphones
Smartphones + REST API + Symfony 4 + PHPUnit + Docker in action

To set up application exec the following commands:

    composer update

    docker-compose build
    docker-compose up -d

The website is running under **8080** port.

If you don't have docker yet:
https://docs.docker.com/install/

**Tests**

To run tests execute following command:

    php bin/phpspec run