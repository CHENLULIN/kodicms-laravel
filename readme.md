## KodiCMS based on Laravel PHP Framework 
### [English Version](https://github.com/teodorsandu/kodicms-laravel/blob/dev/README_EN.md)

[![Join the chat at https://gitter.im/KodiCMS/kodicms-laravel](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/KodiCMS/kodicms-laravel?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

### Установка (Installation):

 * Клонировать репозиторий *(Clone repository)* `git clone https://github.com/KodiCMS/kodicms-laravel.git`
 * Запустить команду *(Run command)* `composer install` для загрузки всех необходимых компонентов
 * Выполнить установку системы *(Install CMS)* `php artisan cms:install` (`php artisan cms:install --help`) Или переименовать .env.example в .env и настроить подключение к БД, затем выполнить комманду *(Or rename .env.example to .env and set database connection, then run artisan command)* `php artisan cms:modules:migrate --seed`
 
---

### Авторизация (Authorization)

Сайт: http://laravel.kodicms.ru/backend

**Русский интерфейс**

username: **admin@site.com**  
password: **password**

**English interface**

username: **admin_en@site.com**  
password: **password**

---

### Консольные команды (Console commands)

 * `php artisan cms:install` - создание .env файла, миграция и добавление сидов (в будущем данная команда будет создавать файл и производить миграцию)
 * `php artisan cms:modules:migrate` - создание таблиц в БД
   - Для отката старых миграций необходимо добавить `--rollback`
   - Для сидирования данных необходимо добавить `--seed`

 * `php artisan cms:modules:seed` - заполнение таблиц тестовыми данными
 
 * `php artisan cms:modules:publish` - публикация `view` шаблонов *(Publish view templates)*
 * `php artisan cms:modules:locale:publish` - генерация пакета lang файлов для перевода. Файлы будут скопированы в `/resources/lang/vendor`
 * `php artisan cms:modules:locale:diff --locale=en` - проверка наличия всех ключей в переводе в папке `/resources/lang/vendor` относительно модулей.
 * `php artisan cms:generate:translate:js` - генерация JS языковых файлов *(Generate javascript translate admin files)*
 
 * `php artisan cms:modules:list` - просмотр информации о добавленных модулях и плагинов *(Show modules information)*
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

### Структура модуля (Module structure)
[https://github.com/KodiCMS/kodicms-laravel/wiki/Modules](https://github.com/KodiCMS/kodicms-laravel/wiki/Modules)

---

### События (Events)
[https://github.com/KodiCMS/kodicms-laravel/wiki/Events](https://github.com/KodiCMS/kodicms-laravel/wiki/Events)

---

### Roadmap

 * ~~Добавление в Laravel модульной структуры~~
 * ~~Перенос ядра системы~~
 * ~~Перенос модуля "API"~~
 * ~~Перенос модуля "elFinder"~~
 * ~~Перенос модуля "Pages"~~
 * ~~Перенос модуля "Layouts"~~
 * ~~Перенос модуля "Snippets"~~
 * ~~Перенос модуля "Email"~~
 * ~~Перенос модуля "Cron jobs"~~
 * ~~Перенос модуля "Widgets"~~
 * ~~Перенос модуля "Dashboard"~~
 * ~~Перенос модуля "Users, Roles, ACL"~~
 * ~~Перенос модуля "Reflinks"~~
 * ~~Реализация подключения плагинов, со структурой аналогичной модулям~~
 * ~~Модуль уведомлений (Notifications)~~
 * Перенос модуля "Datasource"
 * Перенос плагина "Hybrid" и интеграция его в систему с расширенным функционалом
 * Реализация инсталлятора системы
 * Модуль поиска (Mysql, Sphinx)
 * Редактирование изображений

### Отдельное спасибо команде JetBrains за бесплатно предоставленый ключ для PHPStorm
![PHPStorm](https://www.jetbrains.com/phpstorm/documentation/docs/logo_phpstorm.png)
