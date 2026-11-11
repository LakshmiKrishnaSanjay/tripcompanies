<?php
declare(strict_types=1);

$wiki = static function (string $file): string {
    return 'https://commons.wikimedia.org/wiki/Special:FilePath/' . $file . '?width=1600';
};

return [
    [
        'slug' => 'a-first-week-in-georgia',
        'title' => 'How to shape a first week in Georgia from the UAE',
        'date' => '2026-10-12',
        'excerpt' => 'Tbilisi as the base, Mtskheta as a day out, and the mountains only if you have the nights.',
        'image' => $wiki('Abanotubani.jpg'),
        'alt' => 'Abanotubani, the bath district of Tbilisi, Georgia',
        'destination_slug' => 'georgia',
        'body' => [
            'A first Georgia week from the UAE works better with Tbilisi as home and Mtskheta as a day out. The town is close. It does not need its own hotel.',
            'Kazbegi and Gudauri are worth it when you can sleep nearby. A dawn drive from Tbilisi and back on the same day is how a good mountain view becomes a tired one.',
            'Batumi belongs at the end, not in the middle. Tell us the month and who is travelling, and we will say whether the coast fits.',
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'istanbul-then-cappadocia',
        'title' => 'Istanbul first, then Cappadocia',
        'date' => '2026-09-02',
        'excerpt' => 'Why the balloons need their own nights, and how to leave one day in Istanbul empty.',
        'image' => $wiki('Blue_Mosque_Istanbul.jpg'),
        'alt' => 'The Blue Mosque in Istanbul, Turkey',
        'destination_slug' => 'turkey',
        'body' => [
            'Four nights is enough for a first Istanbul trip if one of them has no plan. The historic peninsula is a single day. Galata is another. The rest is the city itself.',
            'Cappadocia is not a day trip. The point of being there is the early morning. That needs a night in Goreme, not a suitcase in an Istanbul lobby.',
            'Message us with the month. We will split the nights and send the price on WhatsApp. The hotels in the sample package are placeholders.',
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'a-first-safari-in-kenya',
        'title' => 'What a first Kenya safari looks like from the UAE',
        'date' => '2026-08-18',
        'excerpt' => 'Nairobi for a night, then the Mara. Add Nakuru and Amboseli only when the week is long enough.',
        'image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&fm=webp&q=75&w=1600',
        'alt' => 'A safari vehicle on a track in Kenya',
        'destination_slug' => 'kenya',
        'body' => [
            'A first safari from the UAE is usually Nairobi and the Maasai Mara. The city is the gateway. The reserve is the holiday.',
            'Lake Nakuru and Amboseli are the right extras when you have eight nights or more. They are different parks, not a detour on the way to the Mara.',
            'Camp names on the site are samples. Tell us the month and how many of you are travelling. The quote names the camp we can actually hold.',
        ],
        'is_sample' => true,
    ],
];
