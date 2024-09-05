# Simple Standelone blog     
Простой движок для standelone блога и собственного облака   
Необходим веб сервер с поддержкой php   
Для корректной работы в корневой папке должны находиться папка uploads,styles.css, index.php, admin.php и posts.html    
Владельцами файлов и папок должны быть пользователь и группа www-data   
Управление осуществляется через /admin.php   
Чтобы избежаеть несанкционированного доступа переименуйте admin.php,   
например в eoifjelfhewljwo.php, тогда управление будет осуществляться   
через /eoifjelfhewljwo.php    
Аналогичная схема управления для облака, которое находится в папке filedrop.   
UPD: добавил скрипт для конфигуррования параметров вашего блога перед установкой configure.sh   
## Установка (в качестве примера на сервер Apache в Ubuntu/Debian от root)   
apt-get install apache2 libapache2-mod-php apache2-utils   
rm /var/www/html/index.html   
   
После чего копируем содержимое репозитория в корневую папку сайта. Удаляем README.
Не забываем выставить владельцем www-data   
chown -R www-data:www-data /var/www/html/    
## Настройка прав доступа       
Вы можете перименовать admin.php для защиты доступа    
Так же вы можете защитить /admin.php средствами web-сервера, например, в конфигурацию apache нужно добавить следующее:   
        <Files "admin.php">   
        AuthType Basic   
        AuthName "Restricted Area"   
        AuthUserFile /etc/apache2/.htpasswd   
        Require valid-user   
        </Files>   

        <Files "filedrop/admin.php">   
        AuthType Basic   
        AuthName "Restricted Area"   
        AuthUserFile /etc/apache2/.htpasswd   
        Require valid-user   
        </Files>   

   
Логин и пароль для доступа устанавливаются следующей командой (от root):   
htpasswd -c /etc/apache2/.htpasswd имя_пользователя   
Добавил в репозиторий для примера файл 000-default.conf    

