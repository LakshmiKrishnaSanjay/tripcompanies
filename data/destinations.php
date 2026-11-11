<?php
declare(strict_types=1);

/**
 * Launch destinations. Sample copy until the client replaces it.
 * flying_time stays empty until the client confirms it.
 */
$wiki = static function (string $file, int $w = 1600): string {
    return 'https://commons.wikimedia.org/wiki/Special:FilePath/' . $file . '?width=' . $w;
};
$unsplash = static function (string $photo, int $w = 1600): string {
    return 'https://images.unsplash.com/' . $photo . '?auto=format&fit=crop&fm=webp&q=75&w=' . $w;
};
$visa = "Visa requirements depend on your nationality and UAE residency. Message us on WhatsApp and we'll check for you.";

return [
    [
        'slug' => 'armenia',
        'name' => 'Armenia',
        'region' => 'south-caucasus',
        'tagline' => 'Yerevan, the monasteries, and the lake if you stay longer.',
        'summary' => 'Armenia is a short holiday from the UAE: a few nights in Yerevan, a day at Garni and Geghard, and Lake Sevan or Dilijan when you want quieter air. The routes below are samples. Hotels and dates are confirmed on WhatsApp.',
        'why' => [
            'Yerevan is compact enough for a long weekend.',
            'Garni and Geghard sit together as a day out of the city.',
            'Lake Sevan and Dilijan are the slower second half.',
        ],
        'best_time' => 'Late spring and early autumn are comfortable for walking. Winter is cold once you leave Yerevan.',
        'currency' => 'AMD',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $wiki('Khor_Virap.jpg'),
        'image_alt' => 'Khor Virap monastery with Mount Ararat behind it, Armenia',
        'highlights' => [
            ['src' => $wiki('Geghard_Monastery.jpg'), 'alt' => 'Geghard monastery carved into the rock in Armenia', 'label' => 'Geghard'],
            ['src' => $wiki('Lake_Sevan.jpg'), 'alt' => 'Lake Sevan in Armenia', 'label' => 'Lake Sevan'],
        ],
        'faqs' => [
            ['q' => 'Is Yerevan enough on its own?', 'a' => 'For a short break, yes. Add Sevan and Dilijan when you have about a week.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'azerbaijan',
        'name' => 'Azerbaijan',
        'region' => 'south-caucasus',
        'tagline' => 'Baku first, then the mountains if you want them.',
        'summary' => 'Start on the boulevard and in the old city of Baku. Stay for a city break, or continue to Gabala and Shahdag when you want forest and a mountain resort. Written for people living in the UAE. Prices and hotel names are placeholders.',
        'why' => [
            'Baku works as a long weekend from the UAE.',
            'The old city and the Flame Towers are an easy first look.',
            'Gabala and Shahdag add a mountain half to the same trip.',
        ],
        'best_time' => 'Spring and autumn are the easiest months for walking Baku. Winter suits Shahdag if you want snow. Summer is hot in the city.',
        'currency' => 'AZN',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $wiki('Flame_Towers.jpg'),
        'image_alt' => 'The Flame Towers on the Baku skyline, Azerbaijan',
        'highlights' => [
            ['src' => $wiki('Icheri_Sheher.jpg'), 'alt' => 'Streets of Icheri Sheher, the old city of Baku', 'label' => 'Old city'],
            ['src' => $wiki('Baku_boulevard.jpg'), 'alt' => 'The seaside boulevard in Baku, Azerbaijan', 'label' => 'The boulevard'],
        ],
        'faqs' => [
            ['q' => 'Can we stay in Baku only?', 'a' => 'Yes. Gabala and Shahdag are for travellers who want a second base in the mountains.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'georgia',
        'name' => 'Georgia',
        'region' => 'south-caucasus',
        'tagline' => 'Tbilisi, Mtskheta, and the high road north.',
        'summary' => 'Georgia suits a capital with a slower pace, Mtskheta close by, and the mountains of Gudauri and Kazbegi when the route is longer. Batumi can close the week on the coast. Planned from Dubai for residents of the UAE.',
        'why' => [
            'Tbilisi and Mtskheta fit a short break.',
            'Kazbegi and Gergeti are the mountain day people ask for.',
            'A longer route can add Gudauri and Batumi.',
        ],
        'best_time' => 'May, June, September and October are comfortable in Tbilisi. Winter is the time for Gudauri. Summer is warm in Batumi.',
        'currency' => 'GEL',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $wiki('Gergeti_Trinity_Church.jpg'),
        'image_alt' => 'Gergeti Trinity Church in the mountains of Kazbegi, Georgia',
        'highlights' => [
            ['src' => $wiki('Abanotubani.jpg'), 'alt' => 'Abanotubani, the bath district of Tbilisi, Georgia', 'label' => 'Tbilisi'],
            ['src' => $wiki('Svetitskhoveli_Cathedral.jpg'), 'alt' => 'Svetitskhoveli Cathedral in Mtskheta, Georgia', 'label' => 'Mtskheta'],
        ],
        'faqs' => [
            ['q' => 'Do we need a separate night in Mtskheta?', 'a' => 'Usually no. It sits close to Tbilisi and works as a day out.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'kazakhstan',
        'name' => 'Kazakhstan',
        'region' => 'central-asia',
        'tagline' => 'Almaty, the lake, and the canyon.',
        'summary' => 'Almaty is the base. Shymbulak is the mountain above the city. Big Almaty Lake and Charyn Canyon are the two days that turn a city stay into a week. For travellers living in the UAE. Lodge and hotel names on the packages are samples.',
        'why' => [
            'Almaty is a straightforward city break.',
            'Shymbulak sits above the city for a mountain day.',
            'The lake and Charyn Canyon each need a full day.',
        ],
        'best_time' => 'Summer is the open season for the lake and the canyon. Winter is for Shymbulak and the city.',
        'currency' => 'KZT',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $wiki('Big_Almaty_Lake.jpg'),
        'image_alt' => 'Big Almaty Lake in the mountains above Almaty, Kazakhstan',
        'highlights' => [
            ['src' => $wiki('Charyn_Canyon.jpg'), 'alt' => 'Charyn Canyon in Kazakhstan', 'label' => 'Charyn Canyon'],
            ['src' => $wiki('Ascension_Cathedral,_Almaty.jpg'), 'alt' => 'Ascension Cathedral in Almaty, Kazakhstan', 'label' => 'Almaty'],
        ],
        'faqs' => [
            ['q' => 'Can the lake and the canyon share a day?', 'a' => 'They are in different directions. We keep them as two days so neither is rushed.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'singapore',
        'name' => 'Singapore',
        'region' => 'southeast-asia',
        'tagline' => 'The bay, the gardens, and Sentosa if you want the beach.',
        'summary' => 'Singapore is a simple city holiday from the UAE. Marina Bay and the gardens fill the first days. Sentosa is the beach day without another flight. The family version keeps one hotel and a slower pace. Sample prices until the desk quotes you.',
        'why' => [
            'The city is easy to cross without changing hotel.',
            'Sentosa is a beach day inside the same trip.',
            'Families can keep the pace gentle and the base fixed.',
        ],
        'best_time' => 'The city works in any month. Outdoor days are kinder when the showers are shorter. Tell us your dates and we will plan around them.',
        'currency' => 'SGD',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $wiki('Marina_Bay_Sands.jpg'),
        'image_alt' => 'Marina Bay and Marina Bay Sands in Singapore',
        'highlights' => [
            ['src' => $wiki('Gardens_by_the_Bay.jpg'), 'alt' => 'Gardens by the Bay in Singapore', 'label' => 'The gardens'],
            ['src' => $wiki('Merlion.jpg'), 'alt' => 'The Merlion at Marina Bay, Singapore', 'label' => 'Marina Bay'],
        ],
        'faqs' => [
            ['q' => 'Is Sentosa a must?', 'a' => 'No. It is the right extra day for families who want a beach. A city stay can skip it.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'malaysia',
        'name' => 'Malaysia',
        'region' => 'southeast-asia',
        'tagline' => 'Kuala Lumpur, then the hills or the island.',
        'summary' => 'Kuala Lumpur is the arrival. Genting is the cooler day in the hills above the city. Langkawi is the beach half when you want the sea. Both sample routes start in the capital, for people flying from the UAE.',
        'why' => [
            'The towers and the old centre fill a short stay.',
            'Genting is a simple extra from Kuala Lumpur.',
            'Langkawi is the beach version of the same holiday.',
        ],
        'best_time' => 'Kuala Lumpur works in any month. Ask us about rain in Langkawi for the dates you want before we hold the island nights.',
        'currency' => 'MYR',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $wiki('Petronas_Towers.jpg'),
        'image_alt' => 'The Petronas Towers in Kuala Lumpur, Malaysia',
        'highlights' => [
            ['src' => $wiki('Genting_Highlands.jpg'), 'alt' => 'The theme park at Genting Highlands, Malaysia', 'label' => 'Genting'],
            ['src' => $wiki('Batu_Caves.jpg'), 'alt' => 'The limestone cliff at Batu Caves near Kuala Lumpur, Malaysia', 'label' => 'Batu Caves'],
        ],
        'faqs' => [
            ['q' => 'Should we choose Genting or Langkawi?', 'a' => 'Genting if you want to stay based in Kuala Lumpur. Langkawi if the beach is the point of the trip.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'turkey',
        'name' => 'Turkey',
        'region' => 'western-asia',
        'tagline' => 'Istanbul, and Cappadocia when you want the balloons.',
        'summary' => 'Istanbul can be the whole holiday: the historic peninsula, the water, and time left empty. Add Cappadocia when you want the valleys and a morning with the balloons. Planned for residents of the UAE. Hotel names are placeholders.',
        'why' => [
            'Four nights in Istanbul is a complete city break.',
            'Cappadocia needs its own nights, not a rushed day trip.',
            'The two together are the week most people ask us for.',
        ],
        'best_time' => 'Spring and autumn are comfortable for walking Istanbul and for Cappadocia. Summer is hot. Winter is quieter and colder.',
        'currency' => 'TRY',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $unsplash('photo-1527838832700-5059252407fa'),
        'image_alt' => 'Hot air balloons over the valleys of Cappadocia, Turkey',
        'highlights' => [
            ['src' => $unsplash('photo-1524231757912-21f4fe3a7200'), 'alt' => 'The Galata Tower and rooftops of Istanbul, Turkey', 'label' => 'Istanbul'],
            ['src' => $unsplash('photo-1541432901042-2d8bd64b4a9b'), 'alt' => 'Hagia Sophia in Istanbul, Turkey', 'label' => 'Hagia Sophia'],
        ],
        'faqs' => [
            ['q' => 'Can Cappadocia be a day trip from Istanbul?', 'a' => 'No. It needs its own nights. We split the week between the two.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'kenya',
        'name' => 'Kenya',
        'region' => 'east-africa',
        'tagline' => 'Nairobi, then the Mara and the other parks.',
        'summary' => 'A Kenya holiday from the UAE is a safari. Nairobi is the gateway. Maasai Mara is the stay most first trips are built around. A longer route adds Lake Nakuru and Amboseli. Camp names on the packages are samples until the desk confirms them.',
        'why' => [
            'The Mara is the park most first safaris use as the base.',
            'Lake Nakuru adds the lake and the rhinos on a longer route.',
            'Amboseli is the second camp, on the plains after the Mara and Nakuru.',
        ],
        'best_time' => 'Drier weeks are usually easier for game drives. The exact pattern shifts, so tell us your dates and we will suggest the parks that fit.',
        'currency' => 'KES',
        'visa' => $visa,
        'flying_time' => '',
        'image' => $unsplash('photo-1516426122078-c23e76319801'),
        'image_alt' => 'Elephants on the grassland of the Maasai Mara, Kenya',
        'highlights' => [
            ['src' => $unsplash('photo-1489392191049-fc10c97e64b6'), 'alt' => 'Wildebeest on the open grassland of Kenya', 'label' => 'The grassland'],
            ['src' => $unsplash('photo-1504432842672-1a79f78e4084'), 'alt' => 'A giraffe in Kenya', 'label' => 'On a game drive'],
        ],
        'faqs' => [
            ['q' => 'Is Nairobi a sightseeing stay?', 'a' => 'It is the gateway. We keep the city nights short and put the time in the parks.'],
            ['q' => 'Can you check what our passports need?', 'a' => $visa],
        ],
        'is_sample' => true,
    ],
];
