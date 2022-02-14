# Test technique équipe Import 

## Lancer l'application

**1. Clone du project LBC**
   - ```git clone https://github.com/ivan-commits/LBC.git```

**2. Instanciation des containers (depuis le dossier LBC)**
   - ```docker-compose up -d --build```
   - si l'invité de commande vous propose ```Continue with the new image ?``` entrer ```y```

**3. Mise à jour du projet (depuis le container php-container)**
   - accédez au container php : ```docker exec -it php-container bash ```
   - mise à jours des packages : ```composer update```

## Liste de requêtes curl
**Changer l'adresse ip par celle de votre machine virtuel**

> Create
```
curl --location --request POST '192.168.0.41:8080/post' \
--header 'Content-Type: application/json' \
--data-raw '{
    "title": "Titre annonce DS3",
    "content": "Texte annonce ds3",
    "category": "Motorcar",
    "carName": "CrossBack ds 3"
}'
```
> Read
```
curl --location --request GET '192.168.0.41:8080/post/1' \
--header 'Content-Type: application/json' \
--data-raw '{"query":"","variables":{}}'
```
  
> Update
```
curl --location --request PUT '192.168.0.41:8080/post/1' \
--header 'Content-Type: application/json' \
--data-raw '{
    "title": "Annonce RS4",
    "content": "Text annonce Rs4",
    "category": "Motorcar",
    "carName": "rs4 avant"
}'
```
> Delete
```
curl --location --request DELETE '192.168.0.41:8080/post/1' \
--header 'Content-Type: application/json'
```
## Lancer les tests:
   - accédez au container php : ```docker exec -it php-container bash ```
   - php unit : ```php ./vendor/bin/phpunit```

## Information Supplémentaire:
> Mysql
   - **accès au container:** ```docker exec -it mysql-container bash```
   - **user:** ```root```
   - **password:** ```secret```
   - **accès à mysql:** ```mysql -u root -p```
   - **accès à la base:** ```use db_name;```
> PHP
- **accès au container:** ```docker exec -it php-container bash```
