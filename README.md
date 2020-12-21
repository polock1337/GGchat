# projet-social-2020-CharlesC1337

Thème de l'application : Application de chat


Équipe :

- Charles
- Antoine
- Gabriel
- Jacob

## Commande CRON pour optimisation archivage (Charles) : 

Script dans ggchat_php\optimisations\Archivage.php

### 1 : Importer le script php sur le serveur

### 2 : Rendre le script php executable

cd path/of/php/script

chmod +x Archivage.php

### 3 : Trouver le chemin vers php (pour étape suivante): 

whereis php

### 4 : CRONTAB

crontab -e

0 0 * * * path/of/php path/of/php/script

ex : 0 0 * * * /usr/local/bin/php /var/scripts/Archivage.php

## Commande pour Redis (Antoine) :

sudo apt-get install php-redis
sudo apt install redis-server
## 2 Crontab
crontab -e
0 0 * * * /usr/local/bin/php /var/scripts/UpdateListeSalonRedis.php
