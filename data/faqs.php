<?php
declare(strict_types=1);

return [
    [
        'topic' => 'Booking',
        'items' => [
            ['q' => 'How do I book a holiday?', 'a' => 'Message us on WhatsApp with the destination, the month and who is travelling. We reply with a route and a price. Nothing is confirmed until you accept it.'],
            ['q' => 'Can I pay online on this website?', 'a' => 'No. There is no checkout on the site. Payment is arranged with the desk after you accept a quote.'],
            ['q' => 'Can you change a package?', 'a' => 'Yes. The packages are starting points. Nights, hotels and the days you want left empty can all move.'],
        ],
    ],
    [
        'topic' => 'Visas',
        'feature' => 'visa',
        'items' => [
            ['q' => 'Do you guarantee a visa?', 'a' => 'No. The embassy or immigration authority decides. We prepare a complete file and stay with you until there is an answer.'],
            ['q' => 'Can the holiday and the visa be one conversation?', 'a' => 'Yes. Most travellers want both, so the hotels and the application tell the same story.'],
            ['q' => 'I live in the UAE. Can you still apply?', 'a' => 'That is the usual case. Tell us your nationality and residency, and we will say whether an application from Dubai is accepted before you spend money on bookings.'],
        ],
    ],
    [
        'topic' => 'UAE trips',
        'feature' => 'inbound',
        'items' => [
            ['q' => 'Who are the UAE experiences for?', 'a' => 'Travellers arriving in the UAE. The days are paced around the heat and a fresh landing.'],
            ['q' => 'Do you sell desert safaris and city tours separately?', 'a' => 'Yes. You can ask for one experience or a few days joined together.'],
        ],
    ],
    [
        'topic' => 'Prices',
        'items' => [
            ['q' => 'Are the prices final?', 'a' => 'Prices marked on the site are starting points per person on a twin share, and the sample trips are samples. The quote on WhatsApp is the one that counts.'],
            ['q' => 'Can you show the price in euro or pounds?', 'a' => 'The site can show an approximate conversion. The WhatsApp quote is always in AED.'],
        ],
    ],
    [
        'topic' => 'Places',
        'id' => 'places',
        'items' => [
            ['q' => 'Which places can you plan from Dubai?', 'a' => 'Armenia, Azerbaijan, Georgia, Kazakhstan, Singapore, Malaysia, Turkey and Kenya. Each country page lists the sample holidays.'],
            ['q' => 'Who are these holidays for?', 'a' => 'People living in the UAE who are travelling abroad. The routes are planned from Dubai.'],
        ],
    ],
    [
        'topic' => 'Inclusions',
        'id' => 'inclusions',
        'items' => [
            ['q' => 'What does a sample holiday usually include?', 'a' => 'Return flights from Dubai, hotels on a twin share, breakfast, airport transfers and the sightseeing named in the route. The quote is the final list.'],
            ['q' => 'What is left out?', 'a' => 'Most lunches and dinners, travel insurance, personal spending, and anything the quote does not name.'],
            ['q' => 'Why does a trip say Sample?', 'a' => 'The price, the dates and the hotel line on that card are samples. The WhatsApp quote is the one you can accept.'],
        ],
    ],
    [
        'topic' => 'Changes',
        'id' => 'changes',
        'items' => [
            ['q' => 'Can one route cover more than one place?', 'a' => 'Yes. Name the places, the month and who is travelling. The desk will say what fits the nights.'],
            ['q' => 'Can I keep a day empty?', 'a' => 'Yes. Say which days you want free and the quote will leave them that way.'],
            ['q' => 'What should the first message include?', 'a' => 'The destination, the month and who is travelling. A voice note is welcome.'],
            ['q' => 'Where do the papers go after I accept?', 'a' => 'Into the same WhatsApp chat, with the route and the quote.'],
        ],
    ],
];
