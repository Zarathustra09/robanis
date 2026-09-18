<?php

// The three service lines and their tiers. Single source of truth for the
// header dropdown, the services overview, each service page's tier columns,
// and the tier_interest whitelist on the lead form.
//
// Every service line uses the same four tiers — Advice, Starter, Business,
// Enterprise — so the pricing conversation stays consistent across lines.
// 'level' (1-4) drives the moss-brightness ramp on the tier card
// (resources/css/app.css --tier-1..--tier-4) and the "Tier 0N" label.
//
// Tier slugs are globally unique (prefixed by service line) because they are
// stored in leads.tier_interest (varchar(40) — see the
// widen_leads_tier_interest_column migration).

return [

    'seo' => [
        'name' => 'Agentic SEO',
        'nav_label' => 'SEO',
        'nav_blurb' => 'Search visibility for AI answers and classic results.',
        'headline' => 'Be the source AI answers cite.',
        'intro' => 'Technical SEO plus the structured data and entity clarity that decide whether AI Overviews, ChatGPT, Perplexity and Claude surface your business at all.',
        'highlights' => [
            'Structured data and entity clarity for AI retrieval',
            'Technical SEO audits and ongoing monitoring',
            'Content shaped for how AI systems retrieve and cite it',
        ],
        'tiers' => [
            [
                'slug' => 'seo-advice',
                'name' => 'Advice',
                'level' => 1,
                'featured' => false,
                'for' => 'For leadership teams that want an independent assessment before committing budget.',
                'features' => [
                    'Market and competitor search-landscape analysis',
                    'AI-search visibility assessment (AI Overviews, ChatGPT, Perplexity, Claude)',
                    'Executive advisory session on findings and priorities',
                    'Prioritised roadmap of next steps',
                    'Written report you can act on in-house or with us',
                ],
            ],
            [
                'slug' => 'seo-starter',
                'name' => 'Starter',
                'level' => 2,
                'featured' => false,
                'for' => 'For a single site that needs a sound technical and AI-search foundation.',
                'features' => [
                    'Everything in Advice',
                    '1 website',
                    'Technical SEO audit and fixes',
                    'AI-search visibility baseline (schema, entity, structured data)',
                    'Search Console and analytics setup',
                    'Monthly performance report',
                    'Email support, 2 business day response',
                ],
            ],
            [
                'slug' => 'seo-business',
                'name' => 'Business',
                'level' => 3,
                'featured' => true,
                'for' => 'For businesses competing for visibility across search and AI answers.',
                'features' => [
                    'Everything in Starter',
                    'Up to 3 websites',
                    'Continuous SEO monitoring and monthly optimization',
                    'Content pipeline shaped for AI retrieval',
                    'AI citation tracking across AI Overviews, ChatGPT, Perplexity and Claude',
                    'Priority support, 1 business day response',
                    'Monthly strategy call',
                ],
            ],
            [
                'slug' => 'seo-enterprise',
                'name' => 'Enterprise',
                'level' => 4,
                'featured' => false,
                'for' => 'For organisations where search visibility is a core channel.',
                'features' => [
                    'Everything in Business',
                    'Unlimited sites and locales',
                    'Dedicated SEO engineer',
                    'Custom entity and knowledge-graph work',
                    'Multi-language and multi-region setup',
                    'Quarterly roadmap review',
                ],
            ],
        ],
    ],

    'agentic-ai' => [
        'name' => 'Agentic AI',
        'nav_label' => 'Agentic AI',
        'nav_blurb' => 'Agents that connect and operate your existing systems.',
        'headline' => 'Agents that act across your systems.',
        'intro' => 'Autonomous agents that connect and operate the systems you already run — CRM, ERP, ticketing, internal tools. Not chatbots that answer questions: agents that take action, with a person in the loop where judgment is needed.',
        'highlights' => [
            'Agents that read, write and reconcile data across your stack',
            'Built on the systems you already own, not a replacement for them',
            'Human-in-the-loop where judgment or approval is required',
        ],
        'tiers' => [
            [
                'slug' => 'agentic-ai-advice',
                'name' => 'Advice',
                'level' => 1,
                'featured' => false,
                'for' => 'For leadership teams that want an independent assessment before committing budget.',
                'features' => [
                    'Market research on how peers in your sector apply AI agents',
                    'Operational review of workflows and systems',
                    'Automation opportunity assessment with expected business impact',
                    'Executive advisory session',
                    'Prioritised roadmap and business case',
                ],
            ],
            [
                'slug' => 'agentic-ai-starter',
                'name' => 'Starter',
                'level' => 2,
                'featured' => false,
                'for' => 'For teams proving one agent against one real workflow.',
                'features' => [
                    'Everything in Advice',
                    '1 system integration',
                    'Up to 2 automation agents',
                    'Workflow audit and agent design',
                    'Human-in-the-loop approval steps',
                    'Monthly performance report',
                    'Email support, 2 business day response',
                ],
            ],
            [
                'slug' => 'agentic-ai-business',
                'name' => 'Business',
                'level' => 3,
                'featured' => true,
                'for' => 'For growing teams running several connected systems.',
                'features' => [
                    'Everything in Starter',
                    'Up to 5 system integrations',
                    'Custom agent development',
                    'CRM / ERP / ticketing connectors',
                    'Agent monitoring and monthly tuning',
                    'Priority support, 1 business day response',
                    'Monthly strategy call',
                ],
            ],
            [
                'slug' => 'agentic-ai-enterprise',
                'name' => 'Enterprise',
                'level' => 4,
                'featured' => false,
                'for' => 'For organisations running agents across departments, with compliance needs.',
                'features' => [
                    'Everything in Business',
                    'Unlimited integrations and agents',
                    'Dedicated engineer',
                    'Custom retrieval pipeline over internal knowledge',
                    'SSO, audit logging, data residency options',
                    'Written SLA with uptime guarantee',
                    'Quarterly roadmap review',
                ],
            ],
        ],
    ],

    'software-solutions' => [
        'name' => 'Software solutions',
        'nav_label' => 'Software solutions',
        'nav_blurb' => 'Custom applications, internal tools and APIs.',
        'headline' => 'Software built to be maintained.',
        'intro' => 'Custom web applications, internal tools and APIs, built by the same team that integrates them. We plan for the second year of a system, not just the launch.',
        'highlights' => [
            'Web applications and internal tools, built to specification',
            'APIs and integrations with the systems you already run',
            'Testing, deployment and maintenance included, not extra',
        ],
        'tiers' => [
            [
                'slug' => 'software-advice',
                'name' => 'Advice',
                'level' => 1,
                'featured' => false,
                'for' => 'For leadership teams that want an independent assessment before committing budget.',
                'features' => [
                    'Market and requirements research',
                    'Technical feasibility and build-versus-buy assessment',
                    'Architecture recommendations for your existing stack',
                    'Executive advisory session',
                    'Prioritised roadmap with effort estimates',
                ],
            ],
            [
                'slug' => 'software-starter',
                'name' => 'Starter',
                'level' => 2,
                'featured' => false,
                'for' => 'For a single internal tool or customer-facing app, built and maintained.',
                'features' => [
                    'Everything in Advice',
                    '1 application (web app or internal tool)',
                    'Discovery and technical specification',
                    'Up to 40 development hours per month',
                    'Hosting setup and deployment',
                    'Bug fixes and security updates',
                    'Email support, 2 business day response',
                ],
            ],
            [
                'slug' => 'software-business',
                'name' => 'Business',
                'level' => 3,
                'featured' => true,
                'for' => 'For products that need steady development, not a one-off build.',
                'features' => [
                    'Everything in Starter',
                    'Up to 3 applications',
                    'Up to 100 development hours per month',
                    'API design and third-party integrations',
                    'Automated testing and continuous deployment',
                    'Priority support, 1 business day response',
                    'Monthly planning call',
                ],
            ],
            [
                'slug' => 'software-enterprise',
                'name' => 'Enterprise',
                'level' => 4,
                'featured' => false,
                'for' => 'For organisations that need a standing engineering team.',
                'features' => [
                    'Everything in Business',
                    'Dedicated engineering team',
                    'Architecture and code review of existing systems',
                    'SSO, audit logging, data residency options',
                    'Written SLA with uptime guarantee',
                    'Quarterly roadmap review',
                ],
            ],
        ],
    ],

];
