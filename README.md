# smartphones
Smartphones + REST API + Symfony 4 + PHPUnit + CQRS + Docker in action

To set up application exec the following commands:

    composer install

    docker-compose build
    docker-compose up -d

The website is running under **8080** port.

If you don't have docker yet:
https://docs.docker.com/install/

**Tests**

To run tests execute following command:

    php bin/phpspec run

**TODO**

- [x] Have a cup of coffee!
- [ ] Write a short documentation about the REST API.
- [ ] Refactor specification constants for God's sake!
- [ ] Refactor API's handling of errors
