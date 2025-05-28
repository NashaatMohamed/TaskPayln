#  Content Scheduler – TaskPayIn

Simplified Laravel-based content scheduling application that allows users to create and schedule posts across multiple social media platforms.

##  Features

- User Authentication with Laravel Sanctum
- Create, edit, delete, and list posts
- Schedule posts for future publication
- Multi-platform support (Twitter, Instagram, LinkedIn, etc.)
- Character limit validation per platform
- Job to auto-publish scheduled posts
- Toggle platform availability per user
- Activity logging
- Rate limiting (Max 10 scheduled posts per day)
- Post analytics (published vs. scheduled, per-platform stats)

---

## Tech Stack

- **Backend:** Laravel 12+
- **Frontend:** Blade (admin views)
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Scheduler:** Laravel Jobs / Cron

---

## Installation Instructions

```bash
# 1. Clone the repository
git clone https://github.com/NashaatMohamed/TaskPayln.git

# 2. Go into the project directory
cd TaskPayln

# 3. Install dependencies
composer install
npm install && npm run dev

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure database in .env
# DB_DATABASE=your_db
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Run the scheduler and queue workers
php artisan schedule:work
php artisan queue:work

# 8. Start the server
php artisan serve
