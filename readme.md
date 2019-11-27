
# NerdHerd
NerdHerd is a project that simulates an ecommerce for nerds, geeks and otaku where they can find videogames, T-shirts, blu-ray and other themed objects.

This project was designed to pass the practical examination of Web Technologies so it had guidelines and features to be implemented obligatorily.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### Prerequisites

**For Ubuntu:**

- LAMP
- Git
- Zip
- PHP > 7.2
- Composer ([Composer Documentation](https://getcomposer.org/doc/03-cli.md))

  `sudo apt-get install composer`
- Laravel Framework 5.8 --> [Laravel installation guide](https://laravel.com/docs/5.5/installation)

### Installing

After `git clone`, go to the terminal in the **repository directory** and run these commands:
- `composer install` to add missing files, except for configuration files
- `cp .env.example .env` to generate new .env file. 
- Open .env file and for `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, enter your credentials to access your database.
- `php artisan migrate` to update the database structure. [E-R Diagram](E-R_Diagram.png)
- `php artisan key:generate` to generate application key

## Running

Open the terminal in the **repository directory**, run `php artisan serve` and open the link to the localhost.

## Built With

* [Laravel](https://laravel.com/docs/5.8) - The web framework used

## Authors

* **Giulia Vantaggiato** [Giulia Vantaggiato](https://github.com/Celian87)
* **Andrea Bercè** [Andrea Bercè](https://github.com/AndreaBerce)

## License

This project is licensed under the MIT License - see the [LICENSE.md](./LICENSE) file for details
