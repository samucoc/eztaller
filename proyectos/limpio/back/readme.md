# Proyecto MDS

## Prerequisitos
- Tener instalado **Docker**

## Instalación y configuración
**Descargar el archivo:**
https://download.oracle.com/otn/linux/oracle11g/xe/oracle-xe-11.2.0-1.0.x86_64.rpm.zip

**Copiar el archivo descargado en la carpeta del proyecto:**  
*oracle/11.2.0.2/*

**Variables de entorno:**
- Crear un archivo *.env* en la carpeta raiz del proyecto.
- Copiar el contenido del archivo *.env.docker* hacia el archivo *.env* creado.

## Ejecucion del proyecto
**Ejecutar en una consola:**  
`docker-compose up -d`

## Ejecucion de scripts para configurar el proyecto
`docker-compose exec app chown www-data /var/www/storage -R`  
`docker-compose exec app chown www-data /var/www/bootstrap/cache -R`  
`docker-compose exec app php artisan key:generate --force`  
`docker-compose exec app php artisan jwt:secret --force`  
`docker-compose exec app php artisan migrate:refresh --seed`  

**Visitar el enlace:**  
http://localhost:8080
