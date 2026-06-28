<?php

namespace Database\Seeders;

use App\Models\KbCategory;
use Illuminate\Database\Seeder;

class KbCategorySeeder extends Seeder
{
    public function run(): void
    {
        KbCategory::create([
            'id'          => 1,
            'name'        => 'Security & Account',
            'slug'        => 'security-account',
            'description' => 'Help with logging in, MFA, and account security.',
            'sort_order'  => 10,
        ]);

        KbCategory::create([
            'id'          => 2,
            'name'        => 'Troubleshooting',
            'slug'        => 'troubleshooting',
            'description' => 'Fix common issues with email, parsing, and tickets.',
            'sort_order'  => 20,
        ]);

        KbCategory::create([
            'id'          => 3,
            'name'        => 'Billing & Subscriptions',
            'slug'        => 'billing-subscriptions',
            'description' => 'Invoices, duplicate charges, and billing cycles.',
            'sort_order'  => 30,
        ]);

        KbCategory::create([
            'id'          => 4,
            'name'        => 'Drafts',
            'slug'        => 'drafts',
            'description' => 'Internal drafts and hidden content.',
            'sort_order'  => 99,
        ]);
    }
}
