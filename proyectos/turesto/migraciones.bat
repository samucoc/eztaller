@rem Controladores de mantenedores
@rem Autor: yo



@echo off

php artisan make:migration create_estados_table
php artisan make:migration create_marcas_table
php artisan make:migration create_categorias_table
php artisan make:migration create_marcas_has_categorias_table
php artisan make:migration create_tipo_productos_table
php artisan make:migration create_modelos_table
php artisan make:migration create_productos_table
php artisan make:migration create_productos_detalles_table
php artisan make:migration create_productos_stock_table
php artisan make:migration create_productos_detalles_has_ventas_detalles_table

