# Architecture

## Overview

Single-server Laravel application with two surfaces: a public-facing portfolio site and a private admin panel. All content is managed through the admin and stored in MySQL.

## Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.3 |
| Framework | Laravel 11 |
| Database | MySQL 8 |
| Cache / Sessions | Redis |
| Frontend build | Vite + Tailwind CSS v3 |
| Web server | nginx |
| Runtime env | Docker Compose (dev), Railway (prod target) |

## Application structure

```
Public routes (throttle:public)
├── /                        HomeController@index
├── /projects                Public\ProjectController@index
├── /projects/{slug}         Public\ProjectController@show
├── /timeline                Public\TimelineController@index
└── /skills                  Public\SkillsController@index

Admin routes (auth + 2FA + throttle:admin)
└── /admin
    ├── /profile              ProfileController (Breeze)
    ├── /projects             Admin\ProjectController (resource)
    ├── /skill-tags           Admin\SkillTagController (resource)
    └── /timeline-entries     Admin\TimelineEntryController (resource)
```

## Authentication flow

1. Breeze handles login/logout/password-reset
2. `throttle.otp` middleware — rate-limits OTP attempts
3. `2fa` middleware — enforces TOTP verification after login
4. All admin pages require both `auth` and `2fa` to pass

## Models

```
User
Project         ──< ProjectImage
Project         >──< SkillTag   (pivot: project_skill)
SkillTag        (category: SkillCategory enum)
TimelineEntry   (type: TimelineType enum)
```

## File storage

Images stored on the `public` disk (`storage/app/public`), served via `/storage` symlink. Path pattern: `projects/{project_id}/{filename}`.

nginx sets `client_max_body_size 10M`. Laravel enforces 1.5 MB per file, max 20 files per upload.
