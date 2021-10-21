## Prérequis
Afin de pouvoir exécuter l'application sur votre poste, vous devez d'aborder installer les dépendances suivantes :
  * php7.3 (min)
  * Mysql
  * NodeJS
  * git
 
### Installation
#### php
  1. sudo apt install php php-cli

#### Mysql
  1. récupérer le lien de téléchargement sur : https://dev.mysql.com/downloads/repo/apt/
  2. sudo wget lienDeTelechargement
  3. sudo dpkg -i fichierReçu 
  4. choisir les valeurs par défault (recommandé) 
  5. sudo apt update 
  5. sudo apt install mysql-server
  6. vérifier l'installation : sudo systemctl status mysql
  
#### Node
  1. sudo apt install nodejs
  
#### Git
  1. sudo apt install git-all

## Installation de l'application

### Télécharger le projet
  1. En vous connectant à votre serveur en ssh (dossier /var/www)
    * git clone git@github.com:guillaume60240/ECF-mediatheque.git nomDuDossier       
  2. Vous rendre dans le dossier ainsi créé

### Installation des dépendances
  1. composer install jquery
  2. composer install @poppersjs/core
  3. composer install
  4. composer update (pour que tout soit à jour)
  5. npm run build (pour créer le fichier style et js)

### La base de données
  1. créer un fichier .env.local pour y renseigner
    * l'utilisateur
    * le mot de passe
    * l'url
    * nom de la base de données
    DATABASE_URL="mysql://user:mdp@url/dbname?serverVersion=5.7"
  2. php bin/console doctrine:database:create (crée la base de donées)
  3. Vérification sql 
    * show databases;
  4. Créer les tables
#### Avec Doctrine (recommandé)
* php bin/console doctrine:migrations:migrate (à partir du dossier du projet)
#### Avec mysql
1. table book :   
    CREATE TABLE `book` (   
        `id` int(11) NOT NULL,   
        `category_id` int(11) NOT NULL,   
        `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `parution` int(11) NOT NULL,   
        `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `available` tinyint(1) NOT NULL,   
        `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,   
        `title_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `author_slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL   
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;   
2. table category :   
    CREATE TABLE `category` (   
        `id` int(11) NOT NULL,    
        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,    
        `sub_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,    
        `name_crud` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,    
        `sub_category_crud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL    
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;   
3. table reservation    
    CREATE TABLE `reservation` (   
        `id` int(11) NOT NULL,    
        `user_id` int(11) NOT NULL,   
        `book_id` int(11) NOT NULL,   
        `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',   
        `validate` tinyint(1) NOT NULL,   
        `validate_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',   
        `restitution` tinyint(1) NOT NULL   
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;   
4. table user    
    CREATE TABLE `user` (   
        `id` int(11) NOT NULL,   
        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,  
        `roles` json NOT NULL,   
        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,   
        `birthday` date NOT NULL,   
        `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,    
        `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',   
        `mail_validate` tinyint(1) NOT NULL,   
        `account_validate` tinyint(1) NOT NULL,   
        `location` int(11) NOT NULL   
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;   
5. table validation   
    CREATE TABLE `validation` (   
        `id` int(11) NOT NULL,   
        `user_id` int(11) NOT NULL,   
        `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL   
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;   
6. Ajout des clés primaires   
    ALTER TABLE `book`    
        ADD PRIMARY KEY (`id`),    
        ADD KEY `IDX_CBE5A33112469DE2` (`category_id`);     
    ALTER TABLE `book`   
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;     
    ALTER TABLE `category`   
        ADD PRIMARY KEY (`id`);   
    ALTER TABLE `category`   
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;    
    ALTER TABLE `reservation`   
        ADD PRIMARY KEY (`id`),   
        ADD KEY `IDX_42C84955A76ED395` (`user_id`),   
        ADD KEY `IDX_42C8495516A2B381` (`book_id`);   
    ALTER TABLE `reservation`    
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;     
    ALTER TABLE `user`   
        ADD PRIMARY KEY (`id`),   
        ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);     
    ALTER TABLE `user`   
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;    
    ALTER TABLE `validation`    
        ADD PRIMARY KEY (`id`),   
        ADD KEY `IDX_16AC5B6EA76ED395` (`user_id`);   
    ALTER TABLE `validation`    
        MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;    
7. Ajout des contraintes    
    ALTER TABLE `reservation`    
        ADD CONSTRAINT `FK_42C8495516A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),   
        ADD CONSTRAINT `FK_42C84955A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);    
    ALTER TABLE `validation`    
        ADD CONSTRAINT `FK_16AC5B6EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);     

### Droits et permissions pour symfony
    Permet d'allouer des droits d'écriture à symfony dans le dossier var (doc symfony)
  1. HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
  2. sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
  3. sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
  4. Si problèmes de droits => chmod 777 public/uploads/books

### Nommer un super admin
  1. Commande symfony    
    php bin/console app:user:superadmin ‘adresseMailUtilisateur’
  2. Commande sql (si besoin)   
    UPDATE `user` SET `roles` = '["ROLE_ADMIN", "ROLE_SUPER_ADMIN", "ROLE_MEMBER" ]' WHERE `user`.`email` = "mailUtilisateur";
    UPDATE `user` SET `account_validate` = '1' WHERE `user`.`email` = "mailUtilisateur";

### Tâches récurrentes (Cron Job)
  1. Suppressions automatiques des réservations arrivées à échéances (3jours)   
    app:reservations:cleanup
  2. Suppressions des inscrits non validés (après 15 jours)   
    app:users:cleanup
