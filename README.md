# Welcome!<br>
This is my demo laravel project, I can't host this project on web because the platforms do not provide the ssh function on free web hosting version (inorder to install composer, nodejs and other dependencies.) 

Please follow the instruction step by step -<br>
(1) please install **xampp** on your machine, and make sure **php version is > 7.3 and < 8.0** <br>
(2) please install **composer** <br>
(3) please install **nodejs** <br>
(4) please download project zip file <br>
(5) extract zip file to path **c/xampp/htdocs** <br>
(6) open **command box** and go to the **project path** and _run command_ **composer install**, after that _run_ **npm install**. <br>
(7) open **command box** and go to the **project path** and _run command_ **copy .env.example .env** <br>
(8) open **xampp control panel** and _run_ **apache service** and **mysql**<br>
(9) open your **web broswer** and _type_ **localhost/phpmyadmin** and create one database and name it **kuaidi** (in this case my database name is kuaidi)<br>
(10) go to the **.env file** and insert the representative parameters -- <br>
        at the line no **12** : DB_DATABASE=**kuaidi**<br>
        at the line no **29** : MAIL_USERNAME=**luoxiangxu66@gmail.com** <br>
        at the line no **30** : MAIL_PASSWORD=**09784028944**<br>
        at the line no **32** : MAIL_FROM_ADDRESS=**luoxiangxu66@gmail.com**<br>
(11) open **command box** and go to the **project path** and _run command_ **composer require laravel/passport "~9.0"**, after that _run command_ **php artisan migrate** <br>
(12) open **command box** and go to the **project path** and _run command_ **php artisan key:generate**, after that _run command_ **php artisan cache:clear** <br>
(13) open **command box** and go to the **project path** and _run command_ **php artisan serve**, _copy the address_ that project currently running and _paste_ it to the **web broswer** and then open **new command box** and go to the **project path** _run command_ **npm run watch**.<br>
(14) go to the **config/kuaidi.php** and you can add **administrator** to the website<br>
## We are ready to go!

