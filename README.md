#What is BitWasp
BitWasp is an open source project which aims to lower the barrier for anyone to set up there own secure, anonymous marketplace. It is envisaged that BitWasp will be used on Tor hidden services. As such it is designed with speed in mind. This project will also eventually full integrate with BitCoin providing a secure escrow service for buyers and sellers. This project is still in its very early stages. There is a preliminary planning document at https://piratenpad.de/p/bitwasp-planning

If you can help or have any ideas please join us on http://www.thelaboratory.org

#Installation and Configuration
To setup BitWasp please import the schema.sql file from this directory into your MySQL database. Please configure the settings in ./application/config/database.php and ./application/config/config.php to match your enviroment. Finally if your site is not in your root directory please update the .htaccess file to the correct base directory.
