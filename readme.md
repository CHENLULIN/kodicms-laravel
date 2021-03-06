## KodiCMS based on Laravel PHP Framework
### [English Version](https://github.com/teodorsandu/kodicms-laravel/blob/dev/README_EN.md)

[![Build Status](https://travis-ci.org/KodiCMS/kodicms-laravel.svg?branch=dev)](https://travis-ci.org/KodiCMS/kodicms-laravel)
[![Join the chat at https://gitter.im/KodiCMS/kodicms-laravel](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/KodiCMS/kodicms-laravel?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

### Установка (Installation):

 * Клонировать репозиторий *(Clone repository)* `git clone https://github.com/KodiCMS/kodicms-laravel.git`
 * Запустить команду *(Run command)* `composer install` для загрузки всех необходимых компонентов
 * Скопировать .env.example в .env и настроить подключение к БД, затем выполнить комманду *(Copy .env.example and rename to .env. Configure database connection, then run artisan command)* `php artisan modules:migrate --seed`
 * Сгенерировать application ключ `php artisan key:generate`
 * Выполнить установку системы *(Install CMS)* `php artisan cms:modules:install`.
 * Выполнить миграцию модуей `php artisan modules:migrate --seed`.

---

### Авторизация (Authorization)

Сайт: http://demo.kodicms.com/backend

**Русский интерфейс**

username: **admin@site.com**
password: **password**

**English interface**

username: **admin_en@site.com**
password: **password**

---

### Изменения в Laravel.

##### config/app.php

```php
'providers' => [
    ...
   	Illuminate\View\ViewServiceProvider::class,
   	
   	/*
   	 * KodiCMS Service Providers...
   	 */
   	KodiCMS\CMS\Providers\ModuleLoaderServiceProvider::class,
   	
   	/*
   	 * Application Service Providers...
   	 */
   	App\Providers\AppServiceProvider::class,
   	...
]
```

##### config/cms.php
Добавлен конфиг `cms.php`

##### .env
`APP_PROFILING=false`
`ADMIN_DIR_NAME=backend`

#### public/index.php

```php
...
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Tune up KodiCMS
|--------------------------------------------------------------------------
|
*/
require_once __DIR__.'/../vendor/kodicms/core/src/bootstrap/app.php';


/*
|--------------------------------------------------------------------------
| Run The Application
...
```

---

### Консольные команды (Console commands)

 * `php artisan cms:modules:install` - индексация установленных модулей
 * `php artisan modules:migrate` - создание таблиц в БД
   - Для отката старых миграций необходимо добавить `--rollback`
   - Для сидирования данных необходимо добавить `--seed`

 * `php artisan modules:seed` - заполнение таблиц тестовыми данными

 * `php artisan cms:modules:publish` - публикация `view` шаблонов *(Publish view templates)*
 * `php artisan cms:modules:locale:publish` - генерация пакета lang файлов для перевода. Файлы будут скопированы в `/resources/lang/vendor`
 * `php artisan cms:modules:locale:diff --locale=en` - проверка наличия всех ключей в переводе в папке `/resources/lang/vendor` относительно модулей.
 * `php artisan cms:generate:translate:js` - генерация JS языковых файлов *(Generate javascript translate admin files)*

 * `php artisan modules:list` - просмотр информации о добавленных модулях и плагинов *(Show modules information)*
 * `php artisan cms:wysiwyg:list` - список установленных в системе редакторов текста *(Show wysiwyg information)*
 * `php artisan cms:packages:list` - список всех media пакетов *(Show asset packages list)*
 * `php artisan cms:plugins:list` - просмотр информации о добавленных плагинах *(Show plugins information)*

 * `php artisan cms:layout:rebuild-blocks` - индексация размеченых блоков в шаблонах *(Rebuild templates blocks)*
 * `php artisan cms:api:generate-key` - генерация нового API ключа *(Generate API key)*
 * `php artisan cms:reflinks:delete-expired` - Удаление просроченых сервисных ссылок

 * `php artisan cms:make:controller` - создание контроллера (`cms:make:controller TestController --module=cms --type=backend` создаст контроллер в модуле `modules\CMS`. Существует два типа контроллеров `[api, backend]`)

 * `php artisan cms:plugins:activate author:plugin` - активация плагина *(Plugin activation)*
 * `php artisan cms:plugins:deactivate author:plugin [--removetable=no]` - деактивация плагина (удаление таблицы из БД) *(Plugin deactivation)*

---

### RoadMap

 * Убрать конфиги вроде такого https://github.com/KodiComponents/module-datasource/blob/master/src/config/widgets.php и сделать расширение функционала через сервис провайдеры
 * Добавить возможность хранить виджеты в виде JSON файлов.
 * Настроить наконец то разграничение прав доступа
 * Добавить недостающие виджеты для вывода данных из раздела Datasource
 * Доделать интеграцию админки SleepingOwl для более простого создания модулей
 * Upload изображение в таблицу images и использование их в разичных редакторах

### Отдельное спасибо команде JetBrains за бесплатно предоставленый ключ для PHPStorm
![PHPStorm](https://www.jetbrains.com/phpstorm/documentation/docs/logo_phpstorm.png)
