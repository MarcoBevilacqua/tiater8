<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 28/09/2016
 * Time: 16:05
 */

$factory->define(\App\Viewer::class, function (Faker\Generator $faker) {

    $firstName = $faker->firstName;
    $lastName  = $faker->lastName;
    $fullName  = $firstName . " " . $lastName;

    return [
        'first_name'    => $firstName,
        'last_name'     => $lastName,
        'full_name'     => $fullName,
        'email'         => $faker->safeEmail,
        'quota'         => $faker->randomElement(array('S', 'N')),
        'phone'         => $faker->phoneNumber,
        'sign_date'     => $faker->dateTimeThisDecade
    ];
});
