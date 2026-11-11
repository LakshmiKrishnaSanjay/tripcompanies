<?php
declare(strict_types=1);

$img = static function (string $photo): string {
    return 'https://images.unsplash.com/' . $photo . '?auto=format&fit=crop&fm=webp&q=75&w=1600';
};

return [
    [
        'slug' => 'first-week-in-switzerland',
        'title' => 'How to shape a first week in Switzerland from Dubai',
        'date' => '2026-10-12',
        'excerpt' => 'Two bases, one scenic rail day, and a Schengen file that matches the hotels. A calmer way to plan the Alps.',
        'image' => $img('photo-1530122037265-a5f1f91d3b99'),
        'alt' => 'A mountain lake under a pale sky',
        'destination_slug' => 'switzerland',
        'body' => [
            'A first Switzerland week from Dubai works better with two bases than with a new hotel every night. Geneva or Zurich for the landing, then one alpine town where you actually unpack.',
            'The scenic train is the day people came for. Book the timed seats before the flights, and leave the afternoon after it empty. A second mountain railway on the next morning is how a good trip becomes a tired one.',
            'If you need a Schengen visa, the hotel names and the train cities should already be in the file. We build that route with you on WhatsApp. The embassy still makes the decision.',
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'dubai-in-three-days',
        'title' => 'Three days in Dubai for a first visit from Europe',
        'date' => '2026-09-02',
        'excerpt' => 'Creek, desert light and one skyline evening. A short stay that does not pretend to cover the whole city.',
        'image' => $img('photo-1518684079-3c830dcef090'),
        'alt' => 'Downtown Dubai lights reflected at night',
        'destination_slug' => 'dubai',
        'body' => [
            'Three days is enough for a first look if the order respects the heat. A creek and souk morning, a desert late afternoon, and one evening for the skyline.',
            'The grand mosque in Abu Dhabi is a full day of its own. It does not belong in the same afternoon as a theme park.',
            'Tell us the hotel area and who is travelling. We will suggest the experiences that fit, and you can book only the ones you want.',
        ],
        'is_sample' => true,
    ],
    [
        'slug' => 'when-to-start-a-schengen-file',
        'title' => 'When to start a Schengen file from the UAE',
        'date' => '2026-08-18',
        'excerpt' => 'Earlier than feels necessary. A calm calendar is the difference between a complete file and a rushed one.',
        'image' => $img('photo-1436491865332-7a61a109cc05'),
        'alt' => 'An aircraft wing above cloud',
        'destination_slug' => '',
        'body' => [
            'Schengen applications from the UAE reward a calendar with space in it. Passports, residence proof, bank statements and a realistic itinerary take longer to gather than the form itself.',
            'Start when the month is known, even if the exact hotel is not. A flight reservation and a stay that match the story matter more than a decorative cover letter.',
            'No one honest can promise an approval. What the desk can do is keep the file consistent and tell you if the timing is too tight for the trip you want.',
        ],
        'is_sample' => true,
    ],
];
