# Video Game Management API

This is a Laravel 10.2 API for managing video games, featuring authentication, user roles, filtering, sorting, and reviews.

## Features
- User authentication (register, login, logout) using Laravel Sanctum
- Role-based access (Admin & Regular User)
- Game management (CRUD operations)
- Filtering & sorting (by genre & release date)
- Game reviews & ratings
- API authentication with Laravel Sanctum

## Requirements
- PHP 8.1
- Composer 2.6
- Laravel 10.2
- SQLite, MySQL, or PostgreSQL

## Installation

1. **Clone the Repository**
   ```sh
   git clone https://github.com/StefanosDoul/videogame-api.git
   cd videogame-api
   ```

2. **Install Dependencies**
   ```sh
   composer install
   ```

3. **Set Up Environment**
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**  
   Edit `.env` and set up your database:
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=C:\<your_path>\videogame-api.sqlite
   ```

5. **Run Migrations**
   ```sh
   php artisan migrate
   ```

6. **Seed Admin User (Optional)**
   ```sh
   php artisan tinker
   ```
   Then run:
   ```php
   $admin = App\Models\User::create([
       'name' => 'Admin User',
       'email' => 'admin@example.com',
       'password' => Illuminate\Support\Facades\Hash::make('password'),
       'role' => 'admin'
   ]);
   ```
   Exit with `exit`.

7. **Start the Server**
   ```sh
   php artisan serve
   ```

## API Endpoints

### Authentication
| Method | Endpoint        | Description |
|--------|-----------------|-------------|
| POST   | `/api/register` | Register a new user |
| POST   | `/api/login`    | Log in and get token |
| POST   | `/api/logout`   | Log out (requires token) |

### Games
| Method | Endpoint          | Description |
|--------|-------------------|-------------|
| GET    | `/api/games`      | List games (with filters) |
| POST   | `/api/games`      | Create a new game |
| GET    | `/api/games/{id}` | Get game details |
| PUT    | `/api/games/{id}` | Update a game |
| DELETE | `/api/games/{id}` | Delete a game (Admin or owner only) |

### Reviews
| Method | Endpoint                           | Description |
|--------|------------------------------------|-------------|
| POST   | `/api/games/{gameId}/reviews`      | Add a review |
| GET    | `/api/games/{gameId}/reviews`      | List game reviews |
| PUT    | `/api/games/{gameId}/reviews/{id}` | Edit a review |
| DELETE | `/api/games/{gameId}/reviews/{id}` | Delete a review |

## Authentication
Include the `Authorization` header in all protected API requests:
```
Authorization: Bearer YOUR_ACCESS_TOKEN
```

## Testing with Postman

1. **Import Postman Collection**  
   - Download the Postman Collection from **`postman_collection.json`** (see next step).
   - Open Postman → Click **Import** → Select `Video Game API.postman_collection.json`.

2. **Set Up Environment Variables**  
   - Create a variable **`base_url`** and set it to:
     ```
     http://127.0.0.1:8000/api
     ```
   - Add **`Authorization`** token after login.

## Creating the Postman Collection

1. Open **Postman** and create a **new collection** called:
   ```
   Video Game API
   ```

2. **Add requests**:
   - **Auth Folder:**
     - `POST /api/register`
     - `POST /api/login`
     - `POST /api/logout`
   - **Games Folder:**
     - `GET /api/games`
     - `POST /api/games`
     - `GET /api/games/{id}`
     - `PUT /api/games/{id}`
     - `DELETE /api/games/{id}`
   - **Reviews Folder:**
     - `POST /api/games/{gameId}/reviews`
     - `GET /api/games/{gameId}/reviews`
     - `PUT /api/reviews/{id}`
     - `DELETE /api/reviews/{id}`

3. **Save the collection** and export it:  
   - Click **... (More Actions) → Export**  
   - Select **Collection v2.1**  
   - Save as `postman_collection.json`

4. **Include the file in your Git repo:**
   ```sh
   mv postman_collection.json public/
   git add public/postman_collection.json
   git commit -m "Added Postman Collection"
   git push origin main
   ```

---
### **My Laravel API is Complete!**

