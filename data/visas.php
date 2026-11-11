<?php
declare(strict_types=1);

/**
 * Visa destinations. Processing times are typical guidance, not a promise.
 * Embassies change requirements — confirm the live list before an application.
 */
$visaData = [
    'countries' => [
        [
            'slug' => 'schengen',
            'country' => 'Schengen',
            'fee' => null,
            'types' => ['Short stay', 'Tourism'],
            'is_sample' => true,
            'flag' => '🇪🇺',
            'processing' => '15 to 30 working days',
            'summary' => 'Short stay visas for the Schengen area, prepared for UAE residents with a clean file and a realistic itinerary.',
            'documents' => [
                'Passport valid for at least six months, with blank pages',
                'UAE residence visa and Emirates ID, where applicable',
                'Recent photographs to the embassy specification',
                'Travel medical insurance that covers the Schengen area',
                'Flight reservation and proof of stay',
                'Recent bank statements and proof of employment or business',
                'A short cover letter and day by day plan',
            ],
        ],
        [
            'slug' => 'united-kingdom',
            'country' => 'United Kingdom',
            'fee' => null,
            'types' => ['Standard visitor'],
            'is_sample' => true,
            'flag' => '🇬🇧',
            'processing' => '15 to 25 working days',
            'summary' => 'Standard visitor visas for holidays, family visits and short business trips, with the supporting story lined up.',
            'documents' => [
                'Passport and previous passports if you have them',
                'UAE residence proof',
                'Bank statements covering recent months',
                'Employment letter or trade licence',
                'Travel plan, invitation or hotel booking',
                'Photographs as specified by UK Visas and Immigration',
            ],
        ],
        [
            'slug' => 'united-states',
            'country' => 'United States',
            'fee' => null,
            'types' => ['B1/B2 visitor'],
            'is_sample' => true,
            'flag' => '🇺🇸',
            'processing' => 'Interview led, often a few weeks',
            'summary' => 'B1/B2 visitor applications, from the DS 160 through to the interview slot and the folder you carry on the day.',
            'documents' => [
                'Valid passport',
                'DS 160 confirmation and appointment letter',
                'Photograph to US specification',
                'Proof of ties to the UAE: residence, work and family',
                'Travel dates and a simple outline of the trip',
                'Financial documents that match the form',
            ],
        ],
        [
            'slug' => 'canada',
            'country' => 'Canada',
            'fee' => null,
            'types' => ['Visitor visa'],
            'is_sample' => true,
            'flag' => '🇨🇦',
            'processing' => 'Several weeks, biometrics required',
            'summary' => 'Visitor visas and the biometric step, explained so the online form and the VAC appointment agree with each other.',
            'documents' => [
                'Passport',
                'Digital photographs to IRCC guidance',
                'Proof of funds and employment or business',
                'Travel history and a purpose of travel letter',
                'UAE status documents',
                'Family information for the online form',
            ],
        ],
        [
            'slug' => 'turkey',
            'country' => 'Turkey',
            'fee' => null,
            'types' => ['Sticker visa', 'e visa guidance'],
            'is_sample' => true,
            'flag' => '🇹🇷',
            'processing' => 'Often a few working days',
            'summary' => 'Sticker visas and e visa guidance for travellers who do not qualify for visa free entry, checked against your passport.',
            'documents' => [
                'Passport valid for the length of stay',
                'Photograph',
                'Hotel booking and flight reservation',
                'UAE residence visa',
                'Proof of funds where the consulate asks for it',
            ],
        ],
        [
            'slug' => 'australia',
            'country' => 'Australia',
            'fee' => null,
            'types' => ['Visitor visa'],
            'is_sample' => true,
            'flag' => '🇦🇺',
            'processing' => 'Several weeks',
            'summary' => 'Visitor visas for holidays and family, with the online application and attachments prepared in the right order.',
            'documents' => [
                'Passport bio page',
                'UAE residence proof',
                'Funds, employment and travel history',
                'A clear purpose of stay',
                'Family documents if relatives are hosting you',
            ],
        ],
        [
            'slug' => 'japan',
            'country' => 'Japan',
            'fee' => null,
            'types' => ['Short stay'],
            'is_sample' => true,
            'flag' => '🇯🇵',
            'processing' => 'About 5 to 10 working days',
            'summary' => 'Short stay visas for blossom season and city itineraries, including the schedule consulates like to see.',
            'documents' => [
                'Passport',
                'Photograph',
                'Day by day schedule',
                'Flight and hotel proof',
                'Bank statements and an employment letter',
                'UAE residence visa',
            ],
        ],
        [
            'slug' => 'china',
            'country' => 'China',
            'fee' => null,
            'types' => ['Tourist'],
            'is_sample' => true,
            'flag' => '🇨🇳',
            'processing' => 'About 4 to 10 working days',
            'summary' => 'Tourist visas with the form, photograph rules and invitation or hotel papers set out before you visit the centre.',
            'documents' => [
                'Passport with sufficient validity',
                'Completed form and photograph',
                'Flight and hotel reservations, or an invitation',
                'UAE residence proof',
                'Financial documents as requested',
            ],
        ],
        [
            'slug' => 'saudi-arabia',
            'country' => 'Saudi Arabia',
            'fee' => null,
            'types' => ['Tourist e visa'],
            'is_sample' => true,
            'flag' => '🇸🇦',
            'processing' => 'Several working days',
            'summary' => 'Tourist e visas and permit guidance for UAE residents, including the cases that need a closer look.',
            'documents' => [
                'Passport',
                'Photograph to the current specification',
                'UAE residence visa and Emirates ID',
                'Travel dates and accommodation',
                'Any extra papers the platform requests for your nationality',
            ],
        ],
    ],
    'faqs' => [
        [
            'q' => 'Can you arrange the holiday and the visa together?',
            'a' => 'Yes. Most of our travellers want both. We build the itinerary and the visa file in the same conversation, so the hotels, flights and application tell the same story.',
        ],
        [
            'q' => 'I live in the UAE. Can you still apply?',
            'a' => 'That is the usual case. Tell us your nationality and residency, and we will confirm whether the embassy will accept an application from Dubai before you spend money on bookings.',
        ],
        [
            'q' => 'When should we start?',
            'a' => 'Earlier than feels necessary. Schengen, UK, USA, Canada and Australia reward a calm calendar. Tourist e visas can be shorter. Message us with your month and we will say which pace fits.',
        ],
        [
            'q' => 'Do you guarantee an approval?',
            'a' => 'No one honest can. The decision sits with the embassy or the immigration authority. What we can do is prepare a complete, consistent file and stay with you until there is an answer.',
        ],
        [
            'q' => 'What does the service cost?',
            'a' => 'It depends on the destination and whether you need only the visa or a full trip. We quote on WhatsApp before any payment, including embassy fees where they are known.',
        ],
        [
            'q' => 'Which documents are always required?',
            'a' => 'There is no single list. The cards on this page are a guide. We send the current checklist for your nationality and residence before you collect papers.',
            'is_sample' => true,
        ],
    ],
];

foreach ($visaData['faqs'] as &$faq) {
    $faq['is_sample'] = true;
}
unset($faq);

$steps = [
    ['title' => 'Share the trip', 'text' => 'Country, month, nationality and who is travelling. We say whether an application from Dubai is the right path.'],
    ['title' => 'Collect the papers', 'text' => 'You receive a checklist for your passport. We review the file before it is submitted.'],
    ['title' => 'Submit', 'text' => 'Appointment, online form or e visa, depending on the country. We stay in the same WhatsApp thread.'],
    ['title' => 'Wait for the decision', 'text' => 'The embassy or the immigration authority decides. We do not guarantee an approval.'],
];
foreach ($visaData['countries'] as &$country) {
    $country['steps'] = $steps;
}
unset($country);

return $visaData;
