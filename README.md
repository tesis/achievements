# Achievements and Badges System

This project is a Laravel application that manages and displays user achievements and badges based on their interactions, such as watching lessons and writing comments. In real app - users are students enrolled to particular classes.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Contributing](#contributing)
- [License](#license)

## Overview

The Achievements and Badges System tracks user activities and awards achievements and badges based on their interactions. This system is built using Laravel and includes:

- Tracking lessons watched and comments written.
- Assigning achievements based on these interactions.
- Awarding badges as users accumulate achievements.

## Features

- **Achievements**: Users earn achievements for watching lessons and writing comments.
- **Badges**: Users receive badges based on their total achievements.
- **API Endpoints**: Provides endpoints to fetch achievements and badges for a user.

## Installation

Follow these steps to set up the project locally:

1. **Clone the Repository**

   ```bash
   git clone https://github.com/tesis/achievements-badges-system.git
   cd achievements-badges-system
   ```

2. **Install Dependencies**

   Make sure you have Composer installed, then run:

   ```bash
   composer install
   ```

3. **Set Up Environment**

   Copy the example environment file and edit the `.env` file as needed:

   ```bash
   cp .env.example .env
   ```

   Generate an application key:

   ```bash
   php artisan key:generate
   ```

4. **Run Migrations**

   Apply the database migrations:

   ```bash
   php artisan migrate
   ```

5. **Seed the Database (Optional)**

   If you have seed data, you can populate the database with:

   ```bash
   php artisan db:seed
   ```

6. **Serve the Application**

   Start the Laravel development server:

   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser to see the application.

## Usage

### Fetch Achievements and Badges

You can fetch achievements and badges for a user through the API endpoint:

**GET** `/api/achievements/{user}`

**Parameters:**

- `user` (int): The ID of the user whose achievements and badges are being fetched.

**Response:**

Returns a JSON object with the user's achievements and badges.

### Example

**Request:**

```http
GET /api/achievements/1
```

**Response:**

```json
{
    "watched_count": 10,
    "comments_count": 5,
    "unlocked_achievements": [
        "First Lesson Watched",
        "5 Lessons Watched"
    ],
    "next_available_achievements": [
        "10 Lessons Watched"
    ],
    "current_badge": "Intermediate: 4 Achievements",
    "next_badge": "Advanced: 8 Achievements",
    "remaining_to_unlock_next_badge": 3
}
```

## API Endpoints

- **`GET /api/achievements/{user}`**: Retrieve achievements and badges for the specified user.

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix.
3. Make your changes and ensure that the tests pass.
4. Submit a pull request with a clear description of your changes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.









