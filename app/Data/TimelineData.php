<?php

declare(strict_types=1);

namespace App\Data;

class TimelineData
{
    /** @return array<int, array<string, string>> */
    public static function all(): array
    {
        return [
            [
                'type'        => 'work',
                'title'       => 'Backend Developer',
                'company'     => 'Tempos Brilhantes',
                'location'    => 'Brazil · Remote',
                'start'       => '2024-04',
                'end'         => '2026-04',
                'description' => 'Developed and maintained Laravel-based web applications. Built RESTful APIs, integrated third-party services, and improved system performance. Worked with MySQL, Redis, and Docker in a CI/CD environment.',
                'skills'      => ['PHP', 'Laravel', 'MySQL', 'Redis', 'Docker', 'REST API'],
            ],
            [
                'type'        => 'work',
                'title'       => 'PHP Developer',
                'company'     => 'Freelance',
                'location'    => 'Brazil · Remote',
                'start'       => '2022-01',
                'end'         => '2024-03',
                'description' => 'Delivered custom web solutions using PHP and Laravel for clients across education and business sectors. Implemented WordPress and Moodle customisations and RESTful API integrations.',
                'skills'      => ['PHP', 'Laravel', 'WordPress', 'Moodle', 'MySQL', 'JavaScript'],
            ],
            [
                'type'        => 'education',
                'title'       => 'Systems Analysis and Development',
                'company'     => 'UNIP — Universidade Paulista',
                'location'    => 'Brazil',
                'start'       => '2021-01',
                'end'         => '2023-12',
                'description' => 'Focused on software engineering, databases, algorithms, and web development fundamentals.',
                'skills'      => [],
            ],
        ];
    }
}
