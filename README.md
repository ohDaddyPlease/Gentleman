# Gentleman

**Features from the box:**
* Logger [`monolog`](https://seldaek.github.io/monolog/)
* Access variables via `.env` file

**Basic usage:**  
* git clone https://github.com/ohDaddyPlease/Gentleman
* execute from terminal: `php startMeFirst.php`
* move your project files to app folder andd add to main php file `use Gentleman\Gentleman`;
* execute static method `Gentleman::configure()`
* use `Gentleman::logger` for invoke monolog methods
* fill necessary variables in `.env` file
