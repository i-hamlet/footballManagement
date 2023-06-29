# Football Management APP
This app allows you to create team, add player and transfer players between teams

## Installation
- rename ```.env.example``` to ```.env```
- modify env variables if you want (suggested to keep default)
- Make sure you have ```app-net``` docker network, if not then create one ```make network```
- Bring up docker containers and install dependencies ```make install```
- Build DB with fixtures ```make db```
- That's it, now you have application installed, visit ```localhost:8080```
- Test the app ```make test```

## Useful commands
All useful commands described in `Makefile`, run `make` command to see description  
Duplicate it here:
```bash
    network                        Creates docker network
    up                             Bringing up the containers
    install                        Bringing up the containers and install dependencies
    stop                           Stop containers
    test                           Execute unit tests
    php                            Execute php container bash
    db                             Recreate database for dev
```