<?php

declare(strict_types=1);

namespace App\Data;

class TimelineData
{
    /** @return array<int, array<string, mixed>> */
    public static function all(): array
    {
        return [
            [
                'type'        => 'work',
                'title'       => __('timeline.job.tempos_brilhantes.title'),
                'company'     => 'Associação Tempos Brilhantes',
                'location'    => 'Aveiro, Portugal · Remote',
                'start'       => '2022-07',
                'end'         => '2026-04',
                'description' => __('timeline.job.tempos_brilhantes.description'),
                'skills'      => ['PHP', 'Laravel', 'Node.js', 'MySQL', 'MongoDB', 'WordPress', 'Moodle', 'Docker', 'GitLab CI'],
            ],
            [
                'type'        => 'work',
                'title'       => __('timeline.job.icatu.title'),
                'company'     => 'Icatu Seguros',
                'location'    => 'Rio de Janeiro, Brazil',
                'start'       => '2021-08',
                'end'         => '2022-07',
                'description' => __('timeline.job.icatu.description'),
                'skills'      => ['Angular', 'WordPress', 'JavaScript', 'HTML', 'CSS', 'GraphQL'],
            ],
            [
                'type'        => 'education',
                'title'       => __('timeline.edu.estacio.title'),
                'company'     => 'Estácio de Sá (UNESA)',
                'location'    => 'Rio de Janeiro, Brazil',
                'start'       => '2021-03',
                'end'         => '2024-03',
                'description' => __('timeline.edu.estacio.description'),
                'skills'      => [],
            ],
        ];
    }
}
