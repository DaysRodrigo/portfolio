<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'job_title',
        'tagline',
        'about',
        'github_url',
        'github_username',
        'linkedin_url',
        'linkedin_username',
        'email',
        'whatsapp',
        'whatsapp_label',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'name'               => 'Rodrigo Dias Sales',
                'job_title'          => 'Backend Engineer',
                'tagline'            => 'Building reliable systems with PHP, Laravel & Docker.',
                'about'              => null,
                'github_url'         => 'https://github.com/DaysRodrigo',
                'github_username'    => 'DaysRodrigo',
                'linkedin_url'       => 'https://www.linkedin.com/in/days-rodrigo',
                'linkedin_username'  => 'days-rodrigo',
                'email'              => 'rodrigodcontato@gmail.com',
                'whatsapp'           => '5521991623039',
                'whatsapp_label'     => '+55 21 99162-3039',
            ]
        );
    }
}
