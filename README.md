# Proyecto PHP con Doctrine y PHPUnit

Este proyecto utiliza Docker y Docker Compose para configurar un entorno de desarrollo con PHP, Doctrine y PHPUnit.

## Requisitos

- Docker
- Docker Compose
- Make

## Configuración del entorno

1. Clona el repositorio:

   ```sh
   git clone https://github.com/Rolas444/pruebaPHP.git
   cd tu-repositorio
   ```
2. Crea un archivo .env con el siguiente contenido:

    ```sh
    DB_NAME=dbname
    DB_USER=usuario
    DB_PASSWORD=password
    DB_HOST=host
    DB_DRIVER=pdo_mysql

    TEST_DB_NAME=test_db
    TEST_DB_USER=usuario_test
    TEST_DB_PASSWORD=password
    TEST_DB_HOST=host
    TEST_DB_DRIVER=pdo_mysql
    ```
3. Inicializa el entorno:

    ```sh
    make init
    ```
4. Crea las BD para ambos entornos:

    ```sh
    make create-db
    ```

5. Ejecuta las pruebas:

    ```sh
    make test
    ```

