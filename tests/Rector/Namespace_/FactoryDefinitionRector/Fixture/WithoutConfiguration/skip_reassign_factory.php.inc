<?php

namespace RectorLaravel\Tests\Rector\Namespace_\FactoryDefinitionRector\Fixture\WithoutConfiguration;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory = 1;
$factory->define(\App\User::class, function (\Faker\Generator $faker) {
    return [];
});

?>
-----
<?php

namespace RectorLaravel\Tests\Rector\Namespace_\FactoryDefinitionRector\Fixture\WithoutConfiguration;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory = 1;
$factory->define(\App\User::class, function (\Faker\Generator $faker) {
    return [];
});

?>
