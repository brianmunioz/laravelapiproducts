
# API REST para la gestión de stock de productos

Esta API REST esta diseñada para como aplicación interna de una empresa con depósito.
Cuenta con 3 roles: client, office, admin.

## Tecnologías Utilizadas

- Laravel 11.31
- PHP 8.2
- MySql
- Docker

## Despliegue del proyecto

```bash
  docker compose up -d
  docker compose exec app php artisan migrate
```
## Diagrama entidad-relación

![Diagrama entidad-relación](./UML/ENTIDAD-RELACION.webp)

