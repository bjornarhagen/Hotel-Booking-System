<?php

return [
    'type' => [
        'invoice' => 'Faktura',
        'invoices' => 'Fakturaer',
        'payment_reminder' => 'Betalingspåminnelse',
        'debt_collection_warning' => 'Inkassovarsel',
        'credit_note' => 'Kreditnota',
        'debt_collection' => 'Inkasso',
        'payment_claim' => 'Betalingsoppfordring',
    ],
    'status' => [
        'sold' => 'Solgt',
        'not_sent' => 'Ikke sendt',
        'credited' => 'Kreditert',
        'unpaid' => 'Ubetalt',
        'paid' => 'Betalt',
        'paid_partly' => 'Delvis betalt',
        'paid_over' => 'Overbetalt',
        'past_due' => 'Forfalt',
        'debitor_missing' => 'Mangler debitor',
        'reminder' => [
            'sent' => 'Purring sendt'
        ],
        'case' => [
            'active' => 'Inkasso',
            'closed' => 'Sak er lukket'
        ],
        'request' => [
            'denied' => 'Forespørsel avslått',
            'active' => 'Forespørsel aktiv',
            'sell' => [
                'denied' => 'Salgsforespørsel avslått',
                'active' => 'Salgsforespørsel aktiv',
                'accepted' => 'Salgsforespørsel godtatt'
            ],
            'debt_collection' => [
                'denied' => 'Inkasso forespørsel avslått',
                'active' => 'Inkasso forespørsel aktiv',
                'accepted' => 'Inkasso forespørsel godtatt'
            ]
        ]
    ],
];
