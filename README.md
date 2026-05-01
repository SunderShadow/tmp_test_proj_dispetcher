# Запуск

1. Заполнить .env
    * DADATA_API_KEY
    * DADATA_API_SECRET
2. `docker compose up` - Docker DB  
3. `php bin/console doctrine:migrations:migrate`
4. Перейти в http://127.0.0.1:8000/companies
