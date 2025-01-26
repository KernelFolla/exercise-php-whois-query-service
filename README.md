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

---

## Requirements

- Docker and Docker Compose

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/KernelFolla/exercise-php-whois-query-service.git
   cd whois-query-service-exercise
   ```

## Contributing

This is an exercise, so contributions are not expected. However, feedback and suggestions are welcome!

---

## Author

- **[Marino Di Clemente](https://github.com/KernelFolla)**

---

