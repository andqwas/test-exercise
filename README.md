# Тестовое задание "Task Manager API"

Для удобства обзора приложения присутствует **swagger-документация**

**В случае 500-й ошибки при запросах (проблема с правами):**
 ```bash
   sudo chmod 777 -R ./
```
**Затем перезапустить контейнеры:**
 ```bash
   make app-start
```
**Запустить повторный seed**
 ```bash
   make seed
```

## Инструкция по запуску (с Makefile)

1. Клонировать репозиторий и перейти в созданную папку *test-exercise*:
    ```bash
    git clone https://github.com/andqwas/test-exercise.git
    ```
2. Собрать, поднять все контейнеры и запустить сервер:
    ```bash
    make app-start
    ```
3. При первом запуске заполнить БД тестовыми данными:
     ```bash
    make seed
    ```
4. Приложение будет доступно по адресу:
    ```bash
    http://localhost:8080/api/documentation#
    ```
---

## Инструкция по запуску (без Makefile)

1. Клонировать репозиторий и перейти в созданную папку *test-exercise*:
    ```bash
    git clone https://github.com/andqwas/test-exercise.git
    ```
2. Собрать, поднять все контейнеры и запустить сервер:
    ```bash
    docker compose up --build -d
    ```
3. Запустить миграции и заполнить БД тестовыми данными (для первого запуска):
    ```bash
   docker compose exec -d app php artisan migrate --seed --force
   ```
4. Запустить обработчик очередей:
    ```bash
   docker compose exec -d app php artisan queue:work
    ```
5. Запустить планировщик задач:
    ```bash
   docker compose exec -d app php artisan schedule:work
    ```
6. Приложение будет доступно по адресу:
    ```bash
    http://localhost:8080/api/documentation#
    ```
---

Если нужно подключиться к БД напрямую:
```bash
Host: localhost
Database: db
Port: 8081
Username: user
Password: user
```

---
### Примечание:
- На данном тестовом проекте **не реализованы** механизмы аутентификации и авторизации. Соответственно, эндпоинты не защищены, API предназначено для демонстрационных целей
