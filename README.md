# ExploreNusa

<p align="center">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Badge">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Badge">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/PostgreSQL-4479A1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL Badge">
  <img style="margin-right: 8px;" src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript Badge">
</p>

**ExploreNusa** is a PHP-based web application designed to showcase the beauty and diversity of tourist destinations across Indonesia. Although the initial description is brief, the project holds great potential to become an informative and engaging platform for both domestic and international travelers wishing to explore the charms of Indonesia.

## Fitur Utama ✨

*   **Tourist Destinations 🏞️:** Features detailed information on various tourist destinations in Indonesia, complete with images, descriptions, and locations.
*   **Reviews and Ratings ⭐:** Allows users to leave reviews and ratings for destinations they have visited, helping others make informed decisions.
*   **Integrated API 🌐:** Provides an API for accessing destination and review data, enabling integration with other applications.
*   **Admin Management ⚙️:** A user-friendly admin panel for managing destination data, facilities, and users.

## Tech Stack 🛠️

*   Programming Language: PHP
*   Framework: Laravel
*   Database: PostgreSQL
*   Frontend: JavaScript, HTML, CSS

## Installation & Execution 🚀

1.  Clone the repository:
    ```bash
    git clone https://github.com/Lyonworks/ExploreNusa
    ```

2.  Enter the directory:
    ```bash
    cd ExploreNusa
    ```

3.  Install dependencies:
    ```bash
    composer install
    npm install # Or yarn install if using Yarn
    ```

4.  Configure the environment:
    * Copy `.env.example` to `.env`
    * Configure database details and other settings in the `.env` file

5.  Generate the application key:
    ```bash
    php artisan key:generate
    ```

6.  Run database migrations and seeders:
    ```bash
    php artisan migrate --seed
    ```

7.  Run the project:
    ```bash
    php artisan serve
    npm run watch # Or yarn run watch for development
    ```

## How to Contribute 🤝

1.  Fork this repository.
2.  Create a branch for your feature (`git checkout -b feature/new-feature`).
3.  Commit your changes (`git commit -m 'Add new feature'`).
4.  Push to your branch (`git push origin feature/new-feature`).
5.  Create a Pull Request.

