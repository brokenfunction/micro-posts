# Deep Thought

## Description

Tt is a simple social media made for studying the Symfony framework purpose.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Requirements

- PHP 8.1 or higher;
- Composer;
- Docker Desktop.

## Installation

Follow step-by-step instructions to install the project:
```bash
# Clone the repository
git clone https://github.com/brokenfunction/micro-posts.git

# Navigate to the project directory
cd micro-posts/

# Install Docker dependencies
docker compose up -d

# Install Composer dependencies
composer install

# Set up the database
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

# Start the Symfony server
symfony server:start
```
## Usage

Visit the URL where the web server is running. (http://127.0.0.1:8000 by default) </br>
You can go through registration or log in with an already existing account (login: admin@micropost.com, pwd: 123456) </br>
Use MailCatcher to receive the account activation email after registration. (http://localhost:1080)

The project has next features:
- Registration/Authorization;
- Email confirmation;
- Add/Edit/Remove/View posts;
- Add/Edit/Remove/View comments;
- Day/Night theme switcher;
- Profile editing/photo upload;
- Like/Unlike posts;
- Follow/Unfollow authors;
- Top liked and People you follow feed;
- Pagination;
- Extra privacy (The post can only be seen by the people that you follow);
- Forms validation;
- Wysiwyg editor;

## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

