# 🧠 Driving School API (Laravel Backend Only)

---

## 🔧 Установка и запуск (Docker)

> Требуется: Docker, Make

```bash
git clone https://github.com/JluMoH-code/DrivingSchool-back.git
cd DrivingSchool
cp api/.env.example api/.env    <-- прописать креды для БД (postgres/postgres)
make setup
```

Make-файл выполнит:
- запуск контейнеров (php, postgres, nginx)
- установку зависимостей
- копирование `.env` и генерацию APP_KEY
- запуск миграций и сидеров

Прописать в /etc/hosts
- 127.0.0.1 api.driving-school

Проект будет доступен по адресу:  
📡 http://api.driving-school

---

## 📘 Swagger-документация

Каждый эндпоинт описан вручную с помощью атрибутов `#[OA\...]`.

🗂 Поддерживаются:
- параметры запроса
- схемы моделей
- перечисления
- ответы
- примеры

Доступ: `http://api.driving-school/api/documentation`

---

## 💡 Технологии

- Laravel 12, PHP 8.2
- PostgreSQL 17.5
- Laravel Sanctum
- OpenAPI (Swagger)
- Docker, Make
- Чистая архитектура: MVC + сервисы + DI

---