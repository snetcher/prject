# WordPress Development Environment

This repository contains a Docker-based development environment for WordPress themes and plugins development.

## Requirements

- Docker
- Docker Compose
- Make

## Project Structure

```
.
├── .env                # Environment variables
├── docker-compose.yml  # Docker services configuration
├── Makefile           # Development commands
├── plugin/            # Plugin development directory
└── theme/             # Theme development directory
```

## Quick Start

1. Clone this repository:
```bash
git clone [repository-url]
cd [repository-name]
```

2. Copy the environment file and configure it:
```bash
cp .env.example .env
```

3. Start the development environment:
```bash
make up
```

4. Access the following services:
- WordPress: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## Available Commands

- `make help` - Show available commands
- `make up` - Start the development environment
- `make down` - Stop the development environment
- `make clean` - Remove all containers, volumes, and data
- `make reinstall` - Perform a clean installation (removes all data and starts fresh)

## Environment Configuration

The `.env` file contains the following configuration options:

```env
PROJECT_NAME=mywordpress    # Base name for containers, networks, and DB
DB_NAME=${PROJECT_NAME}_db  # Database name
DB_USER=${PROJECT_NAME}_user
DB_PASSWORD=your_secure_password
DB_ROOT_PASSWORD=your_secure_root_password
WP_TABLE_PREFIX=${PROJECT_NAME}_
```

## Development

### Theme Development
Place your theme files in the `theme/` directory. They will be automatically mounted to `/var/www/html/wp-content/themes/wp-start-theme` in the WordPress container.

### Plugin Development
Place your plugin files in the `plugin/` directory. They will be automatically mounted to `/var/www/html/wp-content/plugins/wp-start-plugin` in the WordPress container.

## Docker Services

The environment includes the following services:

- **WordPress (wp)**
  - PHP 8.2
  - Development mode enabled (WP_DEBUG and SCRIPT_DEBUG)
  - Port: 8080

- **MariaDB (db)**
  - Latest version
  - Persistent data storage

- **phpMyAdmin**
  - Web-based database management
  - Port: 8081

## Troubleshooting

1. If you need to start fresh:
```bash
make reinstall
```

2. To access the database directly:
```bash
docker exec -it [project-name]_db mysql -u root -p
```

3. To view logs:
```bash
docker compose logs -f
```

## Security Notes

- This is a development environment and is not suitable for production use
- Change default passwords in the .env file
- Consider changing the default table prefix for better security
- Restrict access to phpMyAdmin in production environments

## License

MIT License

Copyright (c) 2025 [optional: Snetcher]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

## Contributing

[Your Contributing Guidelines Here] 