# WordPress Development Environment (v0.2.0)

This repository contains a Docker-based development environment for WordPress themes and plugins development.

## Requirements

- Docker
- Docker Compose
- Make

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

## Available Commands

- `make help` - Show available commands
- `make up` - Start the development environment
- `make down` - Stop the development environment
- `make clean` - Remove all containers, volumes, and data
- `make reinstall` - Perform a clean installation (removes all data and starts fresh)
- `make logs` - View WordPress debug logs
- `make status` - Show status of containers
- `make exec s=service cmd=command` - Execute command in container
- `make shell s=service` - Access container's shell
- `make update` - Check and update WordPress core, plugins, and themes
- `make versions` - Display current versions of all components

### Update Commands
- `make update-check` - Check available updates for WordPress core, plugins, and themes
- `make update-core` - Update WordPress core and database
- `make update-plugins` - Update all WordPress plugins
- `make update-themes` - Update all WordPress themes

Examples:
```bash
# Check for available updates
make update-check

# Update everything (core, plugins, themes)
make update

# Update only plugins
make update-plugins

# Check current versions
make versions

# Execute WP-CLI command
make exec s=wp cmd='wp plugin list'

# Access WordPress container shell
make shell s=wp

# Access database shell
make shell s=db

# Execute MySQL query
make exec s=db cmd='mysql -u root -p${DB_ROOT_PASSWORD} -e "SHOW DATABASES;"'
```

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

### Email Configuration

The environment includes Mailpit for email testing. All emails sent by WordPress will be automatically captured.

1. Default configuration:
   - SMTP Host: mailpit
   - SMTP Port: 1025
   - No authentication required
   - TLS disabled

2. Viewing emails:
   - Open Mailpit interface: http://localhost:8025
   - All sent emails will appear here immediately

3. Testing email:
   ```bash
   # Send test email via WP-CLI
   make exec s=wp cmd='wp eval "wp_mail(\"test@example.com\", \"Test Email\", \"This is a test\");"'
   ```

4. Troubleshooting:
   - Check Mailpit is running: `docker compose ps mailpit`
   - View mail logs: `docker compose logs mailpit`
   - Check WordPress logs for mail errors: `make logs`

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

## Docker Compose Configuration

The `docker-compose.yml` file defines the complete development environment. Here's a detailed breakdown of its configuration:

### Network Configuration
```yaml
networks:
  network:
    name: ${PROJECT_NAME}_network
```
Creates an isolated network for all services to communicate securely.

### Volumes Configuration
```yaml
volumes:
  mysqldata:
    name: ${PROJECT_NAME}_mysqldata
  wpcontent:
    name: ${PROJECT_NAME}_wpcontent
```
- `mysqldata`: Persistent storage for the database
- `wpcontent`: Persistent storage for WordPress files

### WordPress Service
```yaml
wp:
  build:
    context: .
    dockerfile: Dockerfile
  volumes:
    - wpcontent:/var/www/html
    - ./config/mu-plugins:/var/www/html/wp-content/mu-plugins
    - ./theme:/var/www/html/wp-content/themes/${THEME_NAME}
    - ./plugin:/var/www/html/wp-content/plugins/${PLUGIN_NAME}
  environment:
    WORDPRESS_DB_HOST: db
    WORDPRESS_DB_NAME: ${DB_NAME}
    WORDPRESS_DB_USER: ${DB_USER}
    WORDPRESS_DB_PASSWORD: ${DB_PASSWORD}
    WORDPRESS_TABLE_PREFIX: ${WP_TABLE_PREFIX}
    WORDPRESS_DEBUG: 1
```
Key features:
- Custom Dockerfile for WordPress with WP-CLI
- Volume mounts for themes, plugins, and must-use plugins
- Environment variables for database connection
- Debug mode enabled for development

### Database Service
```yaml
db:
  image: mariadb
  volumes:
    - mysqldata:/var/lib/mysql
  environment:
    MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
    MYSQL_DATABASE: ${DB_NAME}
    MYSQL_USER: ${DB_USER}
    MYSQL_PASSWORD: ${DB_PASSWORD}
```
Key features:
- MariaDB with persistent storage
- Automatic database creation
- Secure password configuration
- User privileges setup

### phpMyAdmin Service
```yaml
phpmyadmin:
  image: phpmyadmin
  environment:
    PMA_HOST: db
    MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
  ports:
    - "8081:80"
```
Key features:
- Automatic connection to database
- Root password configuration
- Web interface exposed on port 8081

### Mailpit Service
```yaml
mailpit:
  image: axllent/mailpit
  ports:
    - "1025:1025"
    - "8025:8025"
```
Key features:
- SMTP server on port 1025
- Web interface on port 8025
- No authentication required for development
- Captures all outgoing emails

### Health Checks
Each service includes health checks to ensure proper operation:
- WordPress: Checks HTTP response
- MariaDB: Verifies database connection
- phpMyAdmin: Validates web interface
- Mailpit: Confirms SMTP availability

### Resource Limits
```yaml
deploy:
  resources:
    limits:
      memory: 1G
    reservations:
      memory: 512M
```
Configurable resource constraints for each service to prevent container issues.

## Plugin Management

The project includes an automatic plugin manager (`/wp-content/mu-plugins/manage-plugins.php`) that performs the following actions during WordPress installation or theme activation:

### Automatic Plugin Installation
- Admin and Site Enhancements (ASE)
- UpdraftPlus: WP Backup & Migration Plugin

### Default Plugin Removal
- Akismet Anti-spam
- Hello Dolly

### Automatic Configuration
- Sets permalink structure to `/%postname%/` format
- Activates all installed plugins

### Features
- Automatic execution during first installation
- Settings verification and restoration during theme activation
- Detailed operation logging
- Safe removal of unnecessary plugins
- Automatic activation after installation

## Versioning

This project follows [Semantic Versioning](https://semver.org/).

Current version: **0.2.0**

Version numbers are synchronized across all components:
- Docker environment
- WordPress theme
- WordPress plugin
- Documentation
- Configuration files

### Version History

See [CHANGELOG.md](CHANGELOG.md) for detailed version history.

### Version Components

- Major version: Breaking changes
- Minor version: New features, backwards compatible
- Patch version: Bug fixes, backwards compatible

### Version Files

Version information can be found in:
- `/VERSION` - Central version file
- `theme/package.json` - Theme version
- `plugin/package.json` - Plugin version
- `docker-compose.yml` - Environment version
- `CHANGELOG.md` - Version history

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