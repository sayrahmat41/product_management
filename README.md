# Product Management API 
Product management API by Rahmat Sayfuddin

Simple Codeigniter, REST Server, JWT implementation.
I'm using boiler plate 
https://github.com/ParitoshVaidya/CodeIgniter-JWT-Sample


Setup using this repo
=====


Set up project on php server (XAMPP/Linux). 

* **.htaccess** file at project root

This project contains .htaccess file for windows machine. Please update this file as per your requirements.  
[Sample htaccess code (Win/Linux)] (http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva)  
* `encryption_key` in `application\config\config.php`  
[Encryption key generator] (http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/)  
```
$config['encryption_key'] = '';
```  

* `jwt_key` in `application\config\jwt.php`

```
$config['jwt_key']	= '';
```

* **For Timeout** `token_timeout` in `application\config\jwt.php`

```
$config['token_timeout']	= ;
```


Setup for existing projects
=====


You will need following files:

Import sql to your database
**/application/config/database.php** <= set up your database here


Please reply, if you need additional details. Happy coding!


Run
=====

example of request :
import Product Management.postman_collection.json to postmant 

Project uses 
=======
[CodeIgniter] (https://www.codeigniter.com/)  
[REST Server] (https://github.com/chriskacerguis/codeigniter-restserver)  
[Reference for JWT implementation] (https://github.com/rmcdaniel/angular-codeigniter-seed)
[combined all] (https://github.com/ParitoshVaidya/CodeIgniter-JWT-Sample)
