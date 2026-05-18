# Portfolio — Rodrigo Dias Sales

> Personal portfolio and project showcase for [portfolio.daysrodrigo.com](https://portfolio.daysrodrigo.com)

## Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.4+, Laravel 11 |
| Frontend | Tailwind CSS v3, Preline v2, Alpine.js |
| Auth | Laravel Breeze (Blade) |
| Database | MySQL 8.4 |
| Cache (dev) | Redis |
| Cache (prod) | Database (MySQL) |
| Tests | Pest v3 |
| Quality | PHPStan level 6, php-cs-fixer |
| Infra | Docker, Docker Compose |
| CI/CD | GitHub Actions → Railway |

## Requirements

- Docker Desktop
- Git

No local PHP or Composer installation required — everything runs inside Docker.

## Setup

```bash
git clone https://github.com/DaysRodrigo/portfolio.git
cd portfolio
cp .env.example .env
docker compose up -d
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Application available at **http://localhost:8080**

## Daily Commands

```bash
# Start environment
docker compose up -d

# Stop environment
docker compose down

# Artisan
docker compose exec app php artisan <command>

# Composer
docker compose exec app composer <command>

# Tests
docker compose exec app ./vendor/bin/pest

# Tests with coverage
docker compose exec app ./vendor/bin/pest --coverage --min=80

# PHPStan
docker compose exec app ./vendor/bin/phpstan analyse

# php-cs-fixer (dry-run)
docker compose exec app ./vendor/bin/php-cs-fixer fix --dry-run --diff
```

## Project Structure

```
app/
├── Actions/
│   ├── Projects/          # CreateProjectAction, UpdateProjectAction, ReorderProjectsAction
│   └── GitHub/            # SyncRepositoryDataAction
├── Enums/
│   ├── ProjectStatus.php  # draft, published, archived
│   └── SkillCategory.php  # backend, frontend, devops, database, tools
├── Http/
│   ├── Controllers/
│   │   ├── Public/        # Public-facing pages
│   │   └── Admin/         # Admin panel (auth required)
│   ├── Middleware/
│   │   ├── SecurityHeaders.php
│   │   ├── SetLocale.php
│   │   └── HibernationWindow.php
│   └── Requests/Projects/
├── Models/
│   ├── Project.php
│   └── SkillTag.php
├── Services/
│   └── GitHubService.php  # GitHub API with 1h cache
└── View/Components/

lang/
├── en.json                # Default (English) UI strings
├── pt_BR.json             # Portuguese UI strings + validation
└── pt_BR/                 # Validation, auth, pagination (laravel-lang)

docker/
├── nginx/default.conf
└── php/php.ini
```

## Database Schema

```
projects       — title, slug, description, long_description, repo_url,
                 live_url, cover_image, status (enum), display_order,
                 tech_stack (json), github_stars, github_forks,
                 github_last_push, github_synced_at

skill_tags     — name, category (enum)

project_skill  — project_id FK, skill_tag_id FK (pivot)

users          — standard Laravel/Breeze table
cache          — database cache (prod)
```

## Internationalisation

Default locale: **English (`en`)**. Portuguese Brazilian (`pt_BR`) supported out of the box.

Language is stored in the `app_locale` cookie (set via language toggle in the navbar).

To add a new language:
1. `docker compose exec app php artisan lang:add <locale>` — installs validation translations
2. Create `lang/<locale>.json` copying `lang/en.json` and translating the values
3. Add `'<locale>'` to `SUPPORTED_LOCALES` in `app/Http/Middleware/SetLocale.php`

## Environment Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_KEY` | Laravel application key | generated |
| `APP_URL` | Application URL | `http://localhost:8080` |
| `DB_HOST` | MySQL host | `mysql` (Docker) |
| `DB_DATABASE` | Database name | `portfolio` |
| `DB_USERNAME` | Database user | `portfolio` |
| `DB_PASSWORD` | Database password | — |
| `REDIS_HOST` | Redis host | `redis` (Docker) |
| `ADMIN_EMAIL` | Admin panel login | — |
| `ADMIN_PASSWORD` | Admin panel password | — |
| `GITHUB_TOKEN` | GitHub read-only personal token | — |
| `CACHE_STORE` | Cache driver | `redis` (dev) / `database` (prod) |

## CI/CD

```
Push to main → GitHub Actions
  ├── tests  (PHP 8.4 + MySQL 8.4 + Redis, Pest --coverage --min=80)
  └── lint   (php-cs-fixer + PHPStan level 6)
        └── deploy → Railway CLI (railway up --detach)
```

## License

Private project — all rights reserved.
