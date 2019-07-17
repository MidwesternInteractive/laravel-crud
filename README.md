# CRUD
We have put together a CRUD command. It will set up all the core files necessary to create a well put together CRUD. Routes and Views will need to be added separately given the complexity of some applications.

The files included are:


For command help
```shell
$ php artisan -h make:crud
```

### Required Arguments
First argument is the name of the model. Second Argument is the plural version.
```shell
$ php artisan make:crud SalesTerritory SalesTerritories
```

### Migration
By default this command will also create a migration for the new model. If you'd prefer to not create the migration use the `--no-migration` option.
```shell
$ php artisan make:crud SalesTerritory SalesTerritories --no-migration
```

### Specific Resources
By default the command will create all of the resources available. If you only need a few resources you may use the `--with` option. This will prompt for you to specify which resources you need.
```shell
$ php artisan make:crud SalesTerritory SalesTerritories --with
```

### API Resources
If you wish to create the resources for an API you may use the `--api` option. This will generate a base ApiController if one does not exist along with an api specific controller on top of the normal controller for the model.
```shell
$ php artisan make:crud SalesTerritory SalesTerritories --api
```

All of these options may be used in conjunction with one another to produce the desired resources.