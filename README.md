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
├── .env.example       # Example environment file
├── docker-compose.yml # Docker services configuration
├── Makefile          # Development commands
├── config/           # Configuration files
│   └── mu-plugins/   # Must-use plugins
├── plugin/           # Plugin development directory
└── theme/           # Theme development directory
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
⚠️ Make sure to change default passwords in your .env file!

3. Start the development environment:
```bash
make up
```

4. Access the following services:
- WordPress: http://localhost:8080
- phpMyAdmin: http://localhost:8081
- Mailpit: http://localhost:8025

## Available Commands

- `make help` - Show available commands
- `make up` - Start the development environment
- `make down` - Stop the development environment
- `make clean` - Remove all containers, volumes, and data
- `make reinstall` - Perform a clean installation (removes all data and starts fresh)
- `make logs` - View WordPress debug logs
- `make status` - Show status of containers

## Environment Configuration

The `.env` file contains the following configuration options:

```env
# Project settings
PROJECT_NAME=mywordpress    # Base name for containers, networks, and DB

# Database settings
DB_NAME=${PROJECT_NAME}_db  # Database name
DB_USER=${PROJECT_NAME}_user
DB_PASSWORD=your_secure_password
DB_ROOT_PASSWORD=your_secure_root_password

# WordPress settings
WP_TABLE_PREFIX=${PROJECT_NAME}_

# Theme and Plugin settings
THEME_NAME=wp-start-theme    # Your theme directory name
PLUGIN_NAME=wp-start-plugin  # Your plugin directory name
```

## Development

### Theme Development
Place your theme files in the `theme/` directory. They will be automatically mounted to `/var/www/html/wp-content/themes/${THEME_NAME}` in the WordPress container.

### Plugin Development
Place your plugin files in the `plugin/` directory. They will be automatically mounted to `/var/www/html/wp-content/plugins/${PLUGIN_NAME}` in the WordPress container.

### Email Testing
All emails sent by WordPress will be captured by Mailpit. You can view them at http://localhost:8025.

## Docker Services

The environment includes the following services:

- **WordPress (wp)**
  - PHP 8.2
  - Development mode enabled (WP_DEBUG and SCRIPT_DEBUG)
  - Port: 8080
  - Custom theme and plugin mounting
  - SMTP configured for email testing

- **MariaDB (db)**
  - Latest version
  - Persistent data storage
  - Container name: ${PROJECT_NAME}_db

- **phpMyAdmin**
  - Web-based database management
  - Port: 8081
  - Container name: ${PROJECT_NAME}_pma

- **Mailpit**
  - Email testing interface
  - SMTP server port: 1025
  - Web interface port: 8025
  - Container name: ${PROJECT_NAME}_mailpit

## Troubleshooting

1. If you need to start fresh:
```bash
make reinstall
```

2. To access the database directly:
```bash
docker exec -it ${PROJECT_NAME}_db mysql -u root -p
```

3. To view WordPress logs:
```bash
make logs
```

4. To check container status:
```bash
make status
```

5. Common Issues:
   - White screen of death: Check WordPress debug logs
   - Email not working: Verify Mailpit is running
   - Database connection issues: Check environment variables

## Security Notes

- This is a development environment and is not suitable for production use
- Change default passwords in the .env file
- Consider changing the default table prefix for better security
- Restrict access to phpMyAdmin and Mailpit in production environments
- Never commit .env file with real credentials

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

### How to Contribute

1. Fork the repository
2. Create your feature branch:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m 'Add some feature'
   ```
4. Push to the branch:
   ```bash
   git push origin feature/your-feature-name
   ```
5. Open a Pull Request

### Development Guidelines

1. Docker Environment
   - Don't commit .env file
   - Test your changes with `make reinstall`
   - Keep docker-compose.yml clean and documented

2. WordPress Development
   - Follow WordPress Coding Standards
   - Test with debug mode enabled
   - Keep theme and plugin directories organized

3. Documentation
   - Update README.md if adding new make commands
   - Document new environment variables
   - Keep configuration examples up to date

### Reporting Issues

When reporting issues, please include:

1. Environment Details:
   - Docker version
   - Operating System
   - Error messages (if any)

2. Problem Description:
   - What happened?
   - What was expected?
   - Steps to reproduce 

## CI/CD

This project uses GitHub Actions for continuous integration testing. The CI pipeline:

1. Tests the complete Docker environment setup
2. Verifies all services are running correctly:
   - WordPress availability
   - Database connection
   - Email service (Mailpit)
3. Performs health checks on all containers
4. Reports detailed logs on any failures

### CI Environment Variables

The following variables are used in the CI environment:

```env
DB_ROOT_PASSWORD=examplepass  # Default password for CI testing
```

### Test Workflow

The test workflow includes:

1. Environment setup
2. Container initialization
3. Service health checks
4. Database connectivity verification
5. WordPress availability check
6. Email service verification

To view test results:
1. Go to the Actions tab in GitHub repository
2. Select the latest workflow run
3. Review the detailed logs and test results

### Local Testing

To run the same tests locally:

```bash
# Start fresh environment
make reinstall

# Check services manually
curl http://localhost:8080  # Should return 200 or 302
curl http://localhost:8025  # Should return 200
docker compose exec db mariadb -uroot -p${DB_ROOT_PASSWORD} -e "SELECT 1;"
``` 