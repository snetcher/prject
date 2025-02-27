# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Custom WordPress Dockerfile with pre-installed WP-CLI
- Version synchronization across all project files
- VERSION file for central version tracking
- Package.json files for theme and plugin
- Version information in documentation
- Make commands for executing commands in containers
- Shell access command for containers
- SMTP configuration documentation
- Email testing instructions
- Mail error logging

### Changed
- Updated WordPress container to use custom Dockerfile
- Updated all component versions to 0.1.0
- Synchronized version numbers in all project files
- Added version numbers to documentation

### Fixed
- Automated WP-CLI installation in WordPress container
- Removed .vscode directory from git tracking
- Fixed environment variables exposure in repository
- Fixed WordPress email sending configuration
- Fixed database authentication in GitHub Actions
- Fixed service health checks in CI pipeline
- Fixed Windows compatibility for make exec and shell commands

## [0.1.0] - 2024-03-20
### Added
- Initial Docker environment setup with WordPress, MariaDB, and phpMyAdmin
- Makefile with basic commands (up, down, clean, reinstall)
- Theme and plugin development directories
- Environment variables configuration
- Basic documentation in README.md
- MIT License
- Mailpit service for email testing
- SMTP configuration for WordPress
- WordPress SMTP configuration for password reset and other emails
- GitHub Actions workflow for automated testing
- Continuous Integration tests for Docker setup
- Automated checks for WordPress, MariaDB, and Mailpit

### Changed
- Removed .env from git tracking
- Added .env.example as a template
- Updated .gitignore to exclude IDE files and sensitive data
- Improved database connection handling in CI

### Fixed
- Removed .vscode directory from git tracking
- Fixed environment variables exposure in repository
- Fixed WordPress email sending configuration
- Fixed database authentication in GitHub Actions
- Fixed service health checks in CI pipeline
- Fixed SMTP configuration in Docker container

## [0.1.1] - 2024-03-21
### Added
- SMTP configuration file for WordPress
- Updated SMTP configuration in Docker container

### Changed
- Updated SMTP configuration in Docker container

### Fixed
- Fixed SMTP configuration in Docker container 