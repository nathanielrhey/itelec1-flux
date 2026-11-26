# itelec1-flux

**Group Name:** flux

## Members
- Maglinte, Nathaniel Rhey - Project Lead
- Ramirez, Christian Joseph - QA / Documentation
- Lastimos, Narzues Anthony - Backend / Database 
- Rodrigo, Coolbay John - Frontend

## Project Setup (`fluxPetShop`)
1. Open the Laravel app folder:
   ```bash
   cd fluxPetShop
   ```
2. Install PHP dependencies and create your local environment file (never commit `.env` or secrets):
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```
3. Configure MySQL in `fluxPetShop/.env` (`DB_CONNECTION=mysql`, `DB_DATABASE=flux_petshop`) and make sure MySQL is running, then run migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```
4. Start the local development server:
   ```bash
   php artisan serve
   ```
