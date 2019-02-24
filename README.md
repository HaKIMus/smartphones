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
- [ ] AggregateRoots need for business logic!
- [ ] Value objects need for business logic!
- [ ] Tests aren't coverage everything what is worth testing.

**API**

__v1__

Entry point: /api/v1/

Smartphones resource:

| METHOD        | URI              | RESULTS                  | HTTP_STATUS   | CONTENT (JSON) |
| ------------- | ---------------- | ------------------------ | ------------- | -------------- |
| GET           | /smartphones/    | Gets all smartphones     | 200\|400\|500 | NONE                                                                                                                                                                 |
| GET           | /smartphones/:id | Gets smartphone by id    | 200\|400\|500 | NONE                                                                                                                                                                 |
| POST          | /smartphones/    | Creates new smartphone   | 200\|400\|500 | uuid, array specification\[string company, string model, array details\[string os, array screenSize, array screenResolution, string releaseDate (day-month-year)\]\] |
| PUT           | /smartphones/:id | Updates smartphone by id | 200\|400\|500 | array specification\[string company, string model, array details\[string os, array screenSize, array screenResolution, string releaseDate (day-month-year)\]\]       |
| DELETE        | /smartphones/:id | Deletes smartphone by id | 200\|400\|500 | NONE                                                                                                                                                                 |