<?php
declare(strict_types=1);

/**
 * Seasonal campaigns. ends_at is optional. A countdown renders only when it is set.
 * Sample campaigns are hidden when SHOW_SAMPLE_CONTENT is false.
 */
return [
    [
        'slug' => 'winter-escapes',
        'title' => 'Winter Escapes',
        'season' => 'winter',
        'active' => true,
        'window' => 'December 2026 to February 2027',
        'ends_at' => '2027-02-28T23:59:59+04:00',
        'summary' => 'Baku and Shahdag, Georgia in the mountains, Yerevan, and Almaty with Shymbulak. Winter holidays from the UAE.',
        'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Charyn_Canyon.jpg?width=2000',
        'alt' => 'Charyn Canyon in Kazakhstan',
        'is_sample' => true,
    ],
    [
        'slug' => 'spring-departures',
        'title' => 'Spring Departures',
        'season' => 'spring',
        'active' => true,
        'window' => 'March to May 2027',
        'ends_at' => null,
        'summary' => 'Baku, Singapore, Kuala Lumpur and Istanbul with Cappadocia. Spring departures for people living in the UAE.',
        'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&fm=webp&q=75&w=2000',
        'alt' => 'The Galata Tower and rooftops of Istanbul, Turkey',
        'is_sample' => true,
    ],
    [
        'slug' => 'summer-cities',
        'title' => 'Summer Cities',
        'season' => 'summer',
        'active' => true,
        'window' => 'June to August 2027',
        'ends_at' => null,
        'summary' => 'Sevan and Dilijan, the Almaty lake and canyon, Singapore, Langkawi, and the Maasai Mara.',
        'image' => 'https://commons.wikimedia.org/wiki/Special:FilePath/Marina_Bay_Sands.jpg?width=2000',
        'alt' => 'Marina Bay Sands in Singapore',
        'is_sample' => true,
    ],
    [
        'slug' => 'autumn-trails',
        'title' => 'Autumn Trails',
        'season' => 'autumn',
        'active' => true,
        'window' => 'September to November 2027',
        'ends_at' => null,
        'summary' => 'Tbilisi, Istanbul, and a longer Kenya route through the Mara, Nakuru and Amboseli.',
        'image' => 'https://images.unsplash.com/photo-1504432842672-1a79f78e4084?auto=format&fit=crop&fm=webp&q=75&w=2000',
        'alt' => 'A giraffe in Kenya',
        'is_sample' => true,
    ],
];
