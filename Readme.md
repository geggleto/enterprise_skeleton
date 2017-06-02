# ¿Framework?

## Requirements

The unit tests require:

- an active RabbitMQ Server
- XDEBUG configured and enabled to generate coverage reports


## Features

- Persistence
- Events
    - Event Bus
    - Event Middleware
- Messaging
    - RabbitMQ
    - Command Bus
- Value Objects


## Problems

- Hydration of HTTP Body to Entities


## Entity Validation

- define `isValid`
- use `fromArray`
- check to see if the result from FromArray is an array