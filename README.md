# GOPAY Backend

## Requirement

-   PHP >= 8.0
-   BCMath PHP Extension
-   Ctype PHP Extension
-   Fileinfo PHP Extension
-   JSON PHP Extension
-   Mbstring PHP Extension
-   OpenSSL PHP Extension
-   PDO PHP Extension
-   Tokenizer PHP Extension
-   XML PHP Extension

## New Project Setup

-   Create blank new project in Gitlab.
-   Clone this project to the new project folder.

    ```bash
    $ git clone git@gitlab.com:suitmedia/suitcms-laravel-livewire.git {new-project-folder}
    ```

-   Go to the new project folder.

    ```bash
    $ cd {new-project-folder}
    ```

-   Change git origin remote url to the new project git.

    ```bash
    $ git remote set-url origin {new-project-repo.git}
    ```

-   Add SuitCMS Laravel Livewire repository URL to the git remote repository with a new name.
    ```bash
    $ git remote add suitcms git@gitlab.com:suitmedia/suitcms-laravel-livewire.git
    ```
    This way, we can pull directly from SuitCMS Laravel Livewire project every time there is an update.
-   Push the update to the new project repository
    ```bash
    $ git push origin master
    ```

## Installation

-   Run composer install
    ```bash
    $ composer install
    ```
-   Copy the `.env.example` to `.env` file and update the file accordingly.
-   Generate key
    ```bash
    $ php artisan key:generate
    ```
-   Run the migration process
    ```bash
    $ php artisan migrate:fresh --seed
    ```
-   Create superadmin user

    ```bash
    $ php artisan cms:create-admin
    ```

    This will create a superadmin user with credentials:

    -   username: admin@admin.com
    -   password: password

-   Serve
    ```bash
    $ php artisan serve
    ```
-   Go to URL: http://localhost:8000/secret/auth/login to login to the cms.

## Basecode Update

Using the new named repository to the SuitCMS Laravel Livewire, we can directly pull from the repository every time there is an update.

```bash
$ git pull suitcms master
```

Fix the conflict, if any, the push to the project.

```bash
$ git add .
$ git commit -m "Update SuitCMS"
$ git push origin {master/branch}
```
