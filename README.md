# WHOIS Query Service Exercise (.com Domains)

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

This is an exercise to implement a PHP-based WHOIS query service for `.com` domains using the **Slim Framework**. The service is structured following **Domain-Driven Design (DDD) Hexagonal Architecture** and includes Docker support for containerization. It also features unit and integration tests to validate functionality.

---

## Features

- **RESTful API Endpoint**: Accepts HTTP GET requests to perform WHOIS queries on `.com` domains.
- **Error Handling**: Returns appropriate HTTP status codes for invalid domains, non-`.com` domains, or other errors, conforming to REST API standards.
- **Hexagonal Architecture**: Follows DDD principles for clean separation of concerns and maintainability.
- **Docker Support**: Fully containerized for easy deployment and execution.
- **Testing**:
    - **Unit Tests**: Validate domain logic and use cases.
    - **Integration Tests**: Ensure proper integration with the WHOIS service.

### NOTE

I've not used php-di for dependency injection, as it's not necessary for this exercise. However, it would be a good addition for a more complex application. Also I've not used any ORM/persistence for the same reason, but it would be a good addition for a more complex application.

### Hexagonal Architecture and Domain-Driven Design (DDD) Implementation

This project follows the principles of **Hexagonal Architecture** and **Domain-Driven Design (DDD)** to ensure a clean separation of concerns and maintainability. The project is structured into several layers, each with specific responsibilities.

---

#### Layers

##### Domain Layer
The **Domain layer** encapsulates the core business logic and rules. It includes entities, value objects, and domain services. For example:

- **DomainName** (`src/Domain/ValueObject/DomainName.php`): A value object representing a domain name, ensuring it is valid and a `.com` domain.
- **Domain** (`src/Domain/Entity/Domain.php`): An entity representing a domain with its associated properties.

##### Application Layer
The **Application layer** contains application services and use cases that orchestrate the domain logic. It acts as a mediator between the domain and the outside world. For example:

- **WhoisService** (`src/Application/Service/WhoisService.php`): A service that handles WHOIS queries by interacting with the domain and infrastructure layers.
- **WhoisQuery** (`src/Application/Query/WhoisQuery.php`): A query object used to encapsulate the parameters for a WHOIS query.

##### Infrastructure Layer
The **Infrastructure layer** provides implementations for external systems and frameworks, such as HTTP controllers and WHOIS service adapters. For example:

- **WhoisController** (`src/Infrastructure/Http/Controller/WhoisController.php`): An HTTP controller that handles requests for WHOIS queries.
- **WhoisAdapter** (`src/Infrastructure/Adapter/WhoisAdapter.php`): An adapter that connects to the WHOIS server to perform queries.

##### Port Layer
The **Port layer** defines interfaces (ports) that the Domain layer depends on, allowing the Infrastructure layer to provide specific implementations (adapters). For example:

- **WhoisServiceInterface** (`src/Domain/Port/WhoisServiceInterface.php`): An interface defining the contract for a service that performs WHOIS queries.

---

#### Key Concepts

##### Inbound and Outbound Ports
- **Inbound Ports**: These are interfaces that define how external systems (like HTTP requests) can interact with the application. For example, the `WhoisController` acts as an inbound port, accepting HTTP requests and delegating them to the application layer.
- **Outbound Ports**: These are interfaces that define how the application interacts with external systems (like databases or third-party services). For example, the `WhoisServiceInterface` is an outbound port that defines how the application interacts with a WHOIS service.

##### Adapters
- **Adapters**: Adapters are implementations of inbound or outbound ports. They act as a bridge between the application and external systems. For example:
    - The `WhoisAdapter` (`src/Infrastructure/Adapter/WhoisAdapter.php`) is an outbound adapter that implements the `WhoisServiceInterface` and communicates with the WHOIS server.
    - The `WhoisController` (`src/Infrastructure/Http/Controller/WhoisController.php`) is an inbound adapter that handles HTTP requests and translates them into application commands.

---

#### Example Files

- **Domain Layer**:
    - `src/Domain/ValueObject/DomainName.php`: Contains the `DomainName` value object.
    - `src/Domain/Entity/Domain.php`: Contains the `Domain` entity.

- **Application Layer**:
    - `src/Application/Service/WhoisService.php`: Contains the `WhoisService` application service.
    - `src/Application/Query/WhoisQuery.php`: Contains the `WhoisQuery` query object.

- **Infrastructure Layer**:
    - `src/Infrastructure/Http/Controller/WhoisController.php`: Contains the `WhoisController` HTTP controller.
    - `src/Infrastructure/Adapter/WhoisAdapter.php`: Contains the `WhoisAdapter` WHOIS service adapter.

- **Port Layer**:
    - `src/Domain/Port/WhoisServiceInterface.php`: Contains the `WhoisServiceInterface` port.

---

#### Benefits of This Structure

- **Testability**: The core domain logic is decoupled from external dependencies, making it easy to test.
- **Flexibility**: The use of ports and adapters allows for easy swapping of implementations.
- **Maintainability**: Each layer has a clear responsibility, making the codebase more maintainable and scalable.

---

This structure ensures a clean separation of concerns, making the project robust, maintainable, and ready for future extensions.

---

### OpenAPI Specification

This project includes an **OpenAPI specification** (`openapi.yaml`) that defines the API endpoints and their expected behavior. The OpenAPI specification provides a standard way to describe the RESTful API, making it easier for developers to understand and interact with the service.

You can view and interact with the OpenAPI documentation using tools like **Swagger UI** or **Redoc**. To do this, you can use one the following links:

- [https://editor-next.swagger.io/?url=https://raw.githubusercontent.com/KernelFolla/exercise-php-whois-query-service/main/openapi.yaml](https://editor-next.swagger.io/?url=https://raw.githubusercontent.com/KernelFolla/exercise-php-whois-query-service/main/openapi.yaml)
- [https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/KernelFolla/exercise-php-whois-query-service/main/openapi.yaml](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/KernelFolla/exercise-php-whois-query-service/main/openapi.yaml)
- [https://editor.swagger.io/?url=https://raw.githubusercontent.com/KernelFolla/exercise-php-whois-query-service/main/openapi.yaml](https://editor.swagger.io/?url=https://raw.githubusercontent.com/KernelFolla/exercise-php-whois-query-service/main/openapi.yaml)

## Requirements

- Docker and Docker Compose

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/KernelFolla/exercise-php-whois-query-service.git
   cd whois-query-service-exercise
   ```

## Usage

### Starting the Service

```bash
make start
```

### Stopping the Service

```bash
make stop
```

### Using Composer

You can run Composer commands using the `make` command. For example, to install dependencies, run:
```bash
make composer install
```

You can also pass additional parameters to Composer commands. For example:
```bash
make composer install --no-dev
```

### Running PHPStan

To run PHPStan for static analysis, use:
```bash
make phpstan
```

### Running PHPCS

To run PHP CodeSniffer for code style checks, use:
```bash
make phpcs
```

to fix the code style issues automatically, use:
```bash
make phpcs-fix
```

## Contributing

This is an exercise, so contributions are not expected. However, feedback and suggestions are welcome!

---

## Author

- **[Marino Di Clemente](https://github.com/KernelFolla)**

---

