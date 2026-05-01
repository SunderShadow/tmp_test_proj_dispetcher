# Запуск

1. Заполнить .env
    * DADATA_API_KEY
    * DADATA_API_SECRET
2. `composer install`  
3. `docker compose up` - Docker DB  
4. `php bin/console doctrine:migrations:migrate`
5. Перейти в http://127.0.0.1:8000/companies
