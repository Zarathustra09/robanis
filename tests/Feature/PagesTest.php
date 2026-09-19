<?php

dataset('pages', ['/', '/services', '/services/seo', '/services/agentic-ai', '/services/software-solutions', '/why-us', '/contact']);

test('each page renders with exactly one h1', function (string $path) {
    $response = $this->get($path);

    $response->assertStatus(200);
    expect(substr_count($response->getContent(), '<h1'))->toBe(1);
})->with('pages');

test('an unknown service returns 404', function () {
    $this->get('/services/not-a-service')->assertNotFound();
});

test('old page URLs redirect to their new home', function () {
    $this->get('/approach')->assertRedirect('/services#approach');
    $this->get('/about')->assertRedirect('/why-us');
});

test('the services page includes the approach section', function () {
    $response = $this->get('/services');

    $response->assertOk();
    $response->assertSee('id="approach"', false);
});

test('the services overview links to all three service pages', function () {
    $response = $this->get('/services');

    $response->assertOk();
    foreach (['seo', 'agentic-ai', 'software-solutions'] as $slug) {
        $response->assertSee(route('services.show', $slug), false);
    }
});

test('each service page shows its four shared tiers in order and no price', function (string $slug) {
    $response = $this->get("/services/{$slug}");

    $response->assertOk();
    $response->assertSeeInOrder(['Advice', 'Starter', 'Business', 'Enterprise']);
    $response->assertDontSee('₱');
})->with(['seo', 'agentic-ai', 'software-solutions']);

test('the header dropdown lists every service page', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('id="services-menu"', false);
    $response->assertSeeInOrder(['SEO', 'Agentic AI', 'Software solutions']);
});

test('a tier links to the contact page with tier pre-filled', function () {
    $response = $this->get('/services/agentic-ai');

    $response->assertOk();
    $response->assertSee('/contact?tier=agentic-ai-enterprise', false);
});

test('a whitelisted tier query param is reflected on the contact page', function () {
    $response = $this->get('/contact?tier=agentic-ai-enterprise');

    $response->assertOk();
    $response->assertSee('Enquiring about: Agentic AI — Enterprise');
});

test('an unknown tier query param is ignored', function () {
    $response = $this->get('/contact?tier=not-a-real-tier');

    $response->assertOk();
    $response->assertDontSee('Enquiring about:');
});

test('the why us page shows the founder quote', function () {
    $response = $this->get('/why-us');

    $response->assertOk();
    $response->assertSee('Heal Joshua C. Pardo');
    $response->assertSee('resilient as a mighty tree', false);
});

test('the theme defaults to light and ignores the OS colour scheme', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee("'robanis-light'", false);
    $response->assertDontSee('prefers-color-scheme', false);
});
