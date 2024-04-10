# Propriétés & méthodes statiques

- **les propriétés & méthodes statiques sont liées à la classe plutôt qu'un objet spécifique**
- pour définir une méthode statique :

```php

class MaClasse
{

    public static function maMethodeStatique()
    {
        // ...
    }

}

```

- pour appeler une méthode statique :

```php

MaClasse::maMethodeStatique();

```

- pour définir une propriété statique :

```php

class MaClasse
{
    public static $maProprieteStatique = "toto";

}

```

- pour accéder à une propriété statique :

```php

echo MaClasse::maProprieteStatique;

```
