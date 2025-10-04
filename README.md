# 🎯 МойБлог - Личный блог на Yii2

![Yii2](https://img.shields.io/badge/Yii2-Framework-blue)
![PHP](https://img.shields.io/badge/PHP-8.1-purple)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange)
![Docker](https://img.shields.io/badge/Docker-Container-green)

Полнофункциональная платформа для ведения блога с современным дизайном и мощным функционалом.

## ✨ Особенности

- 📝 **CRUD для постов** - создание, редактирование, удаление постов
- 👤 **Система пользователей** - регистрация, аутентификация, роли
- 🖼️ **Загрузка изображений** - аватары и изображения к постам
- 🔍 **Поиск и фильтрация** - умный поиск по контенту
- 📱 **Адаптивный дизайн** - Bootstrap 5, мобильная версия
- 🎨 **Красивый UI** - современный интерфейс
- 🔒 **Безопасность** - валидация, CSRF защита

## 🛠 Технологии

- **Backend:** Yii2 PHP Framework
- **Frontend:** Bootstrap 5, JavaScript
- **Database:** MySQL 8.0
- **Container:** Docker, Docker Compose
- **Web Server:** Apache

## 🚀 Быстрый старт

### Вариант 1: Локальная установка

```bash
# Клонируй репозиторий
git clone https://github.com/yourusername/myblog.git
cd myblog

# Установи зависимости
composer install

# Настрой базу данных в config/db.php
# Запусти миграции
php yii migrate

# Запусти встроенный сервер
php yii serve
```

### Вариант 2: Docker (рекомендуется)

```bash
# Клонируй репозиторий
git clone https://github.com/yourusername/myblog.git
cd myblog

# Запусти контейнеры
docker-compose up -d

# Установи зависимости
docker-compose exec app composer install

# Запусти миграции
docker-compose exec app php yii migrate

# Открой в браузере
http://localhost:8080
```

## 📦 Доступные сервисы

- **Приложение:** http://localhost:8080
- **phpMyAdmin:** http://localhost:8081
- **MySQL:** localhost:3306

## 👤 Учетные данные по умолчанию

- **Администратор:** admin / admin123
- **Автор:** author / author123

## 📁 Структура проекта

```
myblog/
├── controllers/     # Контроллеры
├── models/          # Модели данных
├── views/           # Шаблоны
├── migrations/      # Миграции БД
├── web/            # Web-доступные файлы
├── docker/         # Docker конфигурации
└── config/         # Конфигурации приложения
```

## 🎯 Функционал

### Для гостей:
- Просмотр постов
- Поиск и фильтрация
- Регистрация и вход

### Для пользователей:
- Создание и редактирование постов
- Загрузка изображений
- Личный кабинет
- Управление аватаром

### Для администраторов:
- Полный доступ ко всем функциям
- Управление любыми постами

## 🔧 Разработка

### Запуск тестового окружения:

```bash
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php yii migrate
```

### Просмотр логов:

```bash
docker-compose logs app
docker-compose logs db
```

### Остановка окружения:

```bash
docker-compose down
```

## 📝 Миграции базы данных

```bash
# Создать новую миграцию
docker-compose exec app php yii migrate/create create_new_table

# Применить миграции
docker-compose exec app php yii migrate

# Откатить миграции
docker-compose exec app php yii migrate/down
```
## 👨‍💻 Автор

- GitHub: [@yourusername](https://github.com/Fotonchik)
- Portfolio: [yourportfolio.com](https://hh.ru/resume/4bde0dbeff0b000ce70039ed1f696b666c5642)
<img width="925" height="753" alt="Редактирование профиля" src="https://github.com/user-attachments/assets/6ef51ada-e026-46bb-9b73-b42222de2758" />
<img width="935" height="796" alt="Посты" src="https://github.com/user-attachments/assets/4f01a7f3-4458-431f-843e-debca49baea8" />
<img width="1866" height="843" alt="Главная сайта на yii2" src="https://github.com/user-attachments/assets/b988c7a1-805f-4658-8107-938ace367e1a" />


