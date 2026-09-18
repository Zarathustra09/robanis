<?php

use App\Models\Lead;

function validLeadPayload(array $overrides = []): array
{
    return array_merge([
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.com',
        'company' => 'Analytical Engines Inc.',
        'tier_interest' => 'agentic-ai-enterprise',
        'message' => 'We need help connecting our CRM to our ticketing system.',
        'source_page' => '/contact',
        'website' => '',
    ], $overrides);
}

test('a valid submission stores a lead and redirects with a status message', function () {
    $response = $this->from('/contact')->post('/leads', validLeadPayload());

    $response->assertRedirect(route('contact'));
    $response->assertSessionHas('status');

    $this->assertDatabaseHas('leads', [
        'name' => 'Ada Lovelace',
        'email' => 'ada@example.com',
        'tier_interest' => 'agentic-ai-enterprise',
    ]);

    expect(Lead::first()->ip_address)->not->toBeEmpty();
});

test('an invalid email is rejected and nothing is stored', function () {
    $response = $this->from('/contact')->post('/leads', validLeadPayload(['email' => 'not-an-email']));

    $response->assertSessionHasErrors('email');
    $this->assertDatabaseCount('leads', 0);
});

test('a message over 2000 characters is rejected', function () {
    $response = $this->from('/contact')->post('/leads', validLeadPayload([
        'message' => str_repeat('a', 2001),
    ]));

    $response->assertSessionHasErrors('message');
    $this->assertDatabaseCount('leads', 0);
});

test('a filled honeypot silently drops the submission', function () {
    $response = $this->from('/contact')->post('/leads', validLeadPayload([
        'website' => 'https://spam.example',
    ]));

    $response->assertSessionHas('status');
    $this->assertDatabaseCount('leads', 0);
});

test('an unknown tier_interest is rejected', function () {
    $response = $this->from('/contact')->post('/leads', validLeadPayload([
        'tier_interest' => 'not-a-real-tier',
    ]));

    $response->assertSessionHasErrors('tier_interest');
    $this->assertDatabaseCount('leads', 0);
});

test('the form is throttled after five submissions in a minute', function () {
    foreach (range(1, 5) as $_) {
        $this->post('/leads', validLeadPayload());
    }

    $response = $this->post('/leads', validLeadPayload());

    $response->assertStatus(429);
});
