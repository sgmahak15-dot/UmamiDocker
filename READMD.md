# Drupal 10 Project with Umami Demo Profile

This project runs **Drupal 10** using the **Umami demo profile**.  
No database is included; the configuration is exported in the `config/` folder.  
Docker is used for local development  setup.

---

## Prerequisites

- Docker & Docker Compose
- Composer
- Drush
- WSl2(windows operating system)


---

## Project Structure

UnamiSeed-docker/
├─ docker-compose.yml        
├─ drupal/                   
│   ├─ web/                  
│   │   ├─ core/             
│   │   ├─ modules/          
│   │   ├─ themes/           
│   │   ├─ profiles/         
│   │   ├─ sites/
│   │   │   └─ default/
│   │   │       ├─ files/ 
|   |   |           └─ config/
|   |   |               └─ sync/
│   │   │       └─ settings.php
│   │   
|   |   |_           
│   └─ composer.json         
│   └─ composer.lock
└─ README.md               

## Comands

1. Take git clone- git clone repository url
2. Open cmd - docker compose up -d
3. Install Drupal after importing config - 
   docker exec -it drupal_app bash
    # Import configuration 
    drush config-import -y

    # Clear caches
    drush cr

    exit

4. Visit the browser - http://localhost:8080
admin login:

Username: admin

Password: admin

5. Url To Visit the Assignment Task url
  1. Facet Search - http://localhost:8080/en/faceted-search
  2. Recipe Advance Search - http://localhost:8080/en/recipe-advanced-search
  3. Run the cmd inside the conatiner - drush recipe:stats

## Note: The Given Custom Task Handled using Custom Module and Custom theme :- Custom Module - recipe_access and custom theme - umami_sub