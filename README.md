Welcome!<br>
This is my demo laravel project, I can't host this project on web because the platforms do not provide the ssh function on free web hosting version (to install composer, nodejs and other dependencies.) 

Please follow the instruction step by step -<br>
(1) please install xampp on your machine, and make sure php version is < 7.3 <br>
(2) please install composer <br>
(3) please install nodejs <br>
(4) please download project zip file <br>
(5) extract zip file to path c/xampp/htdocs <br>
(6) open command box and go to the project path and run <block>composer install<block>, after that run npm install. <br>
(7) run command cp .env.example .env <br>
(8) open xampp control panel and run apache service and mysql<br>
(9) open your broswer and type localhost/phpmyadmin and create one database (in this case my database name is kuaidi)<br>
(10) go to the .env file and insert the representative parameters -- <br>
        at the line no 12 : DB_DATABASE=kuaidi<br>
        at the line no 29 : MAIL_USERNAME=luoxiangxu66@gmail.com <br>
        at the line no 30 : MAIL_PASSWORD=09784028944<br>
        at the line no 32 : MAIL_FROM_ADDRESS=luoxiangxu66@gmail.com<br>
(11)

 
