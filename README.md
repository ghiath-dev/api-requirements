### Tests
Running tests for all features required with``php artisan test``

### Steps to see the results in browser
- Create database
- Update .env File
- Run ``php artisan migrate:fresh --seed``
- Run ``php artisan serve``
- Navigate to http://127.0.0.1:8000/products 
- Filtering by category http://127.0.0.1:8000/products?category=vehicle
