<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## EcoVerse Chat Features

The EcoVerse Chat system enables seamless communication between different stakeholders within the application using Laravel Reverb for real-time WebSockets:

### Features

- **Real-time Messaging**: Instant message delivery using WebSockets
- **User Presence**: See when users are online/offline
- **Role-Based Access**: Different stakeholders can communicate based on their roles
- **Unread Messages**: Track and display unread message counts
- **Group & Private Chats**: Support for both one-on-one and group conversations
- **Message History**: Persistent chat history with pagination
- **Admin Oversight**: Administrators can see and respond to all conversations
- **Notifications**: Real-time notifications for new messages
- **Auto-Joining**: Admins automatically added to relevant conversations

### User Roles & Communication Paths

- **Administrators**: Can message all user types and access all conversations
- **Staff**: Can message administrators, vendors, customers
- **Vendors**: Can message administrators, staff, and customers
- **Customers**: Can message administrators, staff, and vendors
- **Wholesalers**: Can message administrators, staff, and vendors

### Technical Implementation

The chat system uses:

- **Laravel Reverb**: WebSocket server for real-time communication
- **Private Channels**: Secured communication channels
- **Event Broadcasting**: For real-time updates across users
- **Laravel Echo**: Frontend WebSocket client
- **Notifications**: Database and broadcast notifications
- **User Status Tracking**: Track user online/offline status

### Starting the WebSocket Server

To start the Laravel Reverb server:

```bash
php artisan reverb:start
```

For development, you can use the combined server command:

```bash
php artisan ecoverse:serve
```

This starts the Laravel development server, Vite asset server, and Laravel Reverb WebSocket server together.

### Admin Features

Administrators have special privileges in the chat system:

1. **Access All Chats**: Admins can see and participate in all chat rooms
2. **Auto-Notification**: Admins receive notifications for all new chat messages
3. **Message Highlighting**: Admin messages are highlighted in green for visibility
4. **Chat Room Management**: Admins can see chat analytics and manage chat rooms

### Testing Chat Functionality

You can test the chat functionality using the provided Artisan commands:

```bash
# Test admin reply functionality
php artisan chat:test-admin-reply

# Run the chat system tests
php artisan test --filter=AdminChatAccessTest
```

### Chat Routes

- **Chat Dashboard**: `/chat`
- **Chat History**: `/chat/history/{roomId?}`
- **Start New Chat**: `/chat/start`
