## About

An API that receives a domain name and the type of requested data (domain information/contact information) and returns the corresponding data from the Whois API.

### Installation

To set up for the first time on a local environment:

1. Run the `composer install`
2. Execute the `cp .env.example .env`
3. Run the `php artisan key:generate`
4. Update all the .env variables for `DB_` accordingly
6. Run the `php artisan migrate`
7. Update `WHOIS_API_KEY`

### Development Server

Start the development server:

```bash
php artisan serve
```
