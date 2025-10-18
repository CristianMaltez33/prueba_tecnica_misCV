# Instrucciones de Instalación

## Requisitos previos
- Docker y Docker Compose instalados

## Pasos de instalación

1. **Construir e iniciar los contenedores:**
```bash
   docker compose up -d --build
```

2. **Configurar permisos en las carpetas de Laravel:**
```bash
   docker compose exec app chmod -R 775 /app/storage /app/bootstrap/cache
   docker compose exec app chown -R www-data:www-data /app/storage /app/bootstrap/cache
```

3. **Instalar dependencias de Composer:**
```bash
   docker compose exec app composer install
```

## Configuración de MongoDB

1. Abre **MongoDB Compass** y conecta con:
```
   mongodb://localhost:27018
```

2. Crea las siguientes colecciones en la base de datos `db`:
   - `misCV`
   - `departamentos`
   - `nivel_academico`

3. Importa los datos desde los archivos JSON en la carpeta `database/collections`

## Acceso a la aplicación

Abre tu navegador y ve a:
```
http://localhost:8002
```

## Comandos útiles

- Ver logs: `docker compose logs -f app`
- Ejecutar migraciones: `docker compose exec app php artisan migrate`
- Acceder a la consola de Laravel: `docker compose exec app php artisan tinker`