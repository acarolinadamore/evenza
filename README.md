# Evenza

Sistema de gerenciamento de eventos em Laravel.

## Tecnologias

-   Laravel 11
-   PostgreSQL
-   Tailwind CSS

## Requisitos

-   PHP 8.2+
-   Composer
-   PostgreSQL (ou MySQL)

## Instalação

```bash
git clone https://github.com/acarolinadamore/evenza-laravel
cd evenza
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Adicionar dados teste

```
php artisan db:seed --class=DadosTesteSeeder
```

## Como rodar

```bash
php artisan serve
```

Acesse: http://localhost:8000
