How to install:

001. Following directories and files should be writable by web server process:
	- app/tmp

002. Load database structure from /.installation/db/. You can also use install.sh file
	> ./install.sh

003. Set host, login and password to database in /app/Config/database.php







php.ini:
memory_limit = 32M
upload_max_filesize = 10M
post_max_size = 20M
