# Marketplace Application

Welcome to the Marketplace Application. This application consists of four services that communicate to each other via REST APIs. Shared components make it easier to develop and scale this application effectively.

## Setting up the Application and Running the Tests

To launch the application please run the following commands:
```
git clone https://github.com/lava4991/marketplace.git
cd marketplace 
docker-compose up
```

The application should now be accessible on http://localhost.

The application contains a Showcase test suite that represents features of the services. To run these tests please launch the following command:
```
docker exec -it -u project frontend-service-php 'vendor/bin/simple-phpunit'
```

The tests themselves can be reviewed in `frontend-service/tests/Showcase/`.

## Service Overview

The application consists of four self-explanatory services:
 - `frontend-service`
 - `auth-service`
 - `order-service`
 - `product-service`

Frontend application is a storage-less service that uses clients to communicate with the domain-specific services. The authorization of inter-service requests is ensured by HS256 encoded JWT tokens.

The reasoning behind implementing separate services for `product` and `order` handling is the following:
 - the concepts of products and orders are related, but each of them may require significant sets of business logic that should, in my opinion, be separated
 - it is likely that the product service will have to serve wastly more reads than writes which might be a good reason to consider some specific technology stack in the future
 - despite this being a tracer app, I wanted to showcase some service choreography

## Additional Notes

In order to make the application development and testing more straightforward, the following non-industry-standard decisions have been made:
 - a single repository is used for all the services and development environment configuration
 - shared packages are placed alongside the application rather than put into separate composer packages
 - `.env` file is commited into the repository

At the moment the application lacks client-level caching. Furthermore, an API server framework should be considered to make the development of future endpoints easier.
