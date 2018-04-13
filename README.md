# CRUD
We have put together a CRUD command. It will set up all the core files necessary to create a well put together crud. Routes and Views will need to be added separately.

For command help
```shell
$ php artisan -h mwi:crud
```

First argument is the name of the model. Second Argument is the plural version.
This will also create a migration for the new model. If you'd prefer to not create the migration use the `--no-migration` option.
If you do not wish to include all resources you may use the `--with` option. This will prompt for you to specify which resources you need.
```shell
$ php artisan mwi:crud UserTerritory UserTerritories
```