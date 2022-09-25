# DOCS

### Introduction

Application will simulate the battle of two armies and return battle results table.

### Docker setup
Docker setup from symfony docs is used https://symfony.com/doc/current/setup/docker.html, https://github.com/dunglas/symfony-docker

1. If not already done, install Docker Compose
2. Run docker compose build --pull --no-cache to build fresh images
3. Run docker compose up (the logs will be displayed in the current shell)
4. Open https://localhost in your favorite web browser and accept the auto-generated TLS certificate
5. Run docker compose down --remove-orphans to stop the Docker containers.

### Initial setup

* Run ```php bin/console doctrine:migrations:migrate```
* Run ```php bin/console doctrine:fixtures:load```

### Battle configuration

In *config/battle_configuration.yaml* you can define some options for battle. 
Default config:

```yaml
battle_configuration:
    enable_special_events: true
    valid_unit_types:
        - infantry
        - cavalry
        - artillery
```

* *enable_special_events* - if set to true special events will be available which will affect army stats
* *valid_unit_types* - define unit types from which army will be built, current options are *infantry*, *cavalry*, *artillery*

### How it works

Fixtures are used to populate database with Units, UnitTypes, Terrains and SpecialEvents. 
User needs to send two positive integer values *army1* and *army2* that represent army sizes to route */battle-simulator*.

#### Unit types
* There are 3 currently supported unit types: *infantry*, *cavalry*, *artillery*

#### Units
* Units have specific attack and defense points and belong to specific unit type (e.g. Samurai (a: 3, d: 10) belong to infantry type)

#### Army creation
Army consists of regiments, moral, modifiers.
* Regiments are consisted of Unit of a specific UnitType and Amount of those units (e.g. Samurai regiment of a size of 100), each
army will have only one regiment of specific unit type (e.g. army can have only one infantry regiment)
* Moral represents armies will to fight (start value is 100)
* Modifiers are condition that affect armies combat ability

Firstly, for each valid unit type a random unit is selected from database, then army regiments are created for select units. 
Number of units inside regiment is random but in sum all the regiments must match total army size that was defined.

#### Battle creation
Battle is consisted of two armies and terrain. One army will be attacker and the second one will be defender (randomly selected).
Terrain is a battle specific modifier which gives some kind of buff to armies (e.g. Mountains terrain, it's harder to attack
on mountains then it is to defend, so attacker will have a negative buff).

### Fight
Battle will play out in phases. During each phase armies roll a dice, and then based on army moral modifier, 
battle modifiers (e.g. terrain), special event modifier (e.g there is a small chance that special event will trigger and add buff to army),
army stats (attack, defense), dice roll a phase winner is calculated and each army loses some troops and moral based
on all those modifiers.

Fight will continue until one army loses moral or all troops.






