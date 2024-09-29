# Laravel Chatroom

Laravel Chatroom is a real-time chat application built using Laravel, Vue.js, and Pusher. This project demonstrates the implementation of a modern, interactive chat system with user authentication and real-time message updates.

## Features

- User registration and authentication
- Real-time messaging
- Multiple chat rooms - (pending)
- User presence indicators - (pending)
- Message timestamps - (pending)
- Responsive design for desktop and mobile devices - (pending)

## Requirements

- PHP 7.4 or higher
- Composer
- Node.js and npm
- Laravel 8.x
- Vue.js 3.x
- Laravel echo & Pusher account for real-time functionality

## Installation and Setup

1. Clone the repository:
   ```
   git clone https://github.com/yourusername/laravel-chatroom.git
   cd laravel-chatroom
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Copy the `.env.example` file to `.env` and configure your database and Pusher credentials:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Run database migrations:
   ```
   php artisan migrate
   ```

7. Compile assets:
   ```
   npm run dev
   ```

8. Start the development server:
   ```
   php artisan serve
   ```

9. Start the Laravel Reverb server:
   ```
   php artisan reverb:start
   ```

10. Visit `http://localhost:8000` in your web browser to access the application.

## Usage

1. Register a new account or log in with existing credentials.
2. Select a chat room or create a new one.
3. Start sending and receiving messages in real-time.






# laravel-chatroom
 Laravel chat room app
