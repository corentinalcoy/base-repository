# Laravel Base Repository

Base function for all my laravel project

# Installation 
Add this to your `composer.json` before the **require** section 
```json

"repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:corentinalcoy/base-repository.git"
        }
    ],
```
Modify the `require` section and add this
```json
"require": {
        "alcoy/repositorify": "*"
    },
```
Now you can run `composer install`

# Usage
Create your UserRepository.php and add this

```php
<?php


namespace App;


use Alcoy\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
    * @type Model
    */
    protected $model = "App\User"  ;
}

```