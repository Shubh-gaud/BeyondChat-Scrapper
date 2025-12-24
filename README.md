# Project Overview

This repository contains a full-stack application with three main components:
- **backend-laravel/**: Laravel-based RESTful API backend
- **frontend-react/**: React.js frontend application
- **ai-updater-node/**: Node.js service for AI-powered article updates and scraping

---

## Local Setup Instructions

### Prerequisites
- Node.js (v16+ recommended)
- npm (v8+ recommended)
- PHP (v8.0+ recommended)
- Composer (for Laravel)
- MySQL or SQLite (for Laravel database)

### 1. Backend (Laravel)
1. Navigate to the backend folder:
   ```sh
   cd backend-laravel
   ```
2. Install PHP dependencies:
   ```sh
   composer install
   ```
3. Copy the example environment file and configure your settings:
   ```sh
   cp .env.example .env
   # Edit .env as needed (DB credentials, etc.)
   ```
4. Generate application key:
   ```sh
   php artisan key:generate
   ```
5. Run database migrations:
   ```sh
   php artisan migrate
   ```
6. Start the Laravel development server:
   ```sh
   php artisan serve
   ```

### 2. Frontend (React)
1. Navigate to the frontend folder:
   ```sh
   cd frontend-react
   ```
2. Install dependencies:
   ```sh
   npm install
   ```
3. Start the React development server:
   ```sh
   npm start
   ```

### 3. AI Updater Service (Node.js)
1. Navigate to the AI updater folder:
   ```sh
   cd ai-updater-node
   ```
2. Install dependencies:
   ```sh
   npm install
   ```
3. Start the service:
   ```sh
   node index.js
   ```

---

## Data Flow / Architecture Diagram

```
+-------------------+         REST API         +-------------------+         HTTP/API         +-------------------+
|   React Frontend  | <---------------------> |   Laravel Backend | <---------------------> |  AI Updater Node  |
+-------------------+                        +-------------------+                        +-------------------+
        |                                                                                         |
        |                                                                                         |
        +-------------------[User Interactions]---------------------------------------------------+
```

**Description:**
- The **React Frontend** communicates with the **Laravel Backend** via RESTful API endpoints for authentication, CRUD operations, and data retrieval.
- The **Laravel Backend** manages business logic, user authentication, and database operations. It also interacts with the **AI Updater Node** service for AI-powered features (e.g., article scraping, summarization, or updates).
- The **AI Updater Node** service can be triggered by the backend (via HTTP/API calls) to perform tasks like scraping articles or integrating with external AI services.

---

## Additional Notes
- Ensure all services are running on non-conflicting ports (default: Laravel 8000, React 3000, Node.js 5000 or as configured).
- Update environment variables in each service as needed for your local setup.
- For production deployment, further configuration and security hardening are required.

---

For any issues, please refer to the respective README files in each subdirectory or contact the project maintainer.
