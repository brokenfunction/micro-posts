# Deep Thought

## Description

Briefly describe your Symfony project and its purpose.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Requirements

- PHP 8.1 or higher;
- Composer;
- Docker Desktop;

## Installation

Provide step-by-step instructions on how to install your Symfony project.

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
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
symfony console doctrine:fixtures:load

# Start the Symfony server
symfony server:start
```
## Usage

Visit the URL where the web server is running. (http://127.0.0.1:8000 by default) </br>
Use MailCatcher to receive the account activation email after registration. (http://localhost:1080) </br>
You can log in with any existing account with default password `123456`



