GiG Media Take-home Test: Simplified CMS
========================================

This repository contains two implementations of a simplified CMS, developed as a response to GiG Media’s PHP test. Each version demonstrates different architectural approaches with the aim of showcasing flexibility and depth of knowledge. The project was built with Laravel 8, PHP 8, and MySQL 5.7, and includes Docker for easy setup.

Project Structure
-----------------

The project is divided into two versions:

1.  **MVC Version**:
    
    *   Implements a straightforward MVC (Model-View-Controller) structure.
        
    *   Includes the repository pattern as an additional abstraction layer for data management with Eloquent models.
        
    *   Controller logic is minimized and handled by dedicated service classes.
        
    *   Designed for simplicity while maintaining separation of concerns and testability.
        
2.  **DDD Version with CQRS**:
    
    *   Follows Domain-Driven Design (DDD) principles with CQRS (Command Query Responsibility Segregation).
        
    *   Organized into specific folders for Domain, Application, and Infrastructure, providing clear boundaries between business logic and infrastructure code.
        
    *   Uses a shared Query and Command Bus, demonstrating a layered architecture suited for scalable, complex applications.
        

Features
--------

*   **Database Models**: Includes Post and Comment models with relationships, following the specified schema.
    
*   **Data Seeding**: Populates the database with fake data (5 posts and 8191 comments) using Laravel factories.
    
*   **API Endpoints**: Both versions provide API endpoints for retrieving, creating, and deleting records, supporting pagination, filtering, and sorting.
    
*   **Tests**: Unit tests validate core functionalities, ensuring accuracy and reliability.
    

Quick Start
-----------

This project is Dockerized for easy setup and includes Makefile commands to install dependencies, run migrations, and seed the database.

### Installation Steps

1.  Clone the repository and navigate to its directory.
    
2.  Use the Makefile commands to build the environment, install dependencies, run migrations, and seed the database.
    

After completing these steps, your local environment should be set up and ready to use.

### API Endpoints

The main endpoints include:

*   **Posts**: GET /posts, DELETE /posts/{id}
    
*   **Comments**: GET /comments, DELETE /comments/{id}, POST /comments
    

Each endpoint supports pagination, filtering, and sorting.