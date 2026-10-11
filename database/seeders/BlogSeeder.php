<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::create([

            'title' =>
                'শিশুর পেটব্যথা: কখন অভিভাবকের সতর্ক হওয়া উচিত?',

            'slug' =>
                'shishur-pet-betha-kokhon-sotorko',

            'category' =>
                'শিশু স্বাস্থ্য',

            'category_slug' =>
                'child',

            'published_at' =>
                '2026-09-25',

            'read_time' =>
                '৫ মিনিট',

            'icon' =>
                'bi-heart-pulse',

            'excerpt' =>
                'শিশুর পেটব্যথার সাধারণ কারণ, কোন লক্ষণগুলো লক্ষ্য করবেন এবং কখন চিকিৎসকের পরামর্শ নেওয়া দরকার।',

            'tags' => [
                'শিশু স্বাস্থ্য',
                'পেটব্যথা',
                'শিশুরোগ',
            ],

            'content' => '
                <p>
                    শিশুর পেটব্যথা অভিভাবকদের জন্য
                    উদ্বেগের কারণ হতে পারে।
                </p>

                <h2>
                    শিশুর পেটব্যথার সাধারণ কারণ
                </h2>

                <p>
                    শিশুদের পেটব্যথা বিভিন্ন কারণে
                    হতে পারে।
                </p>

                <h3>
                    ১. ব্যথা কখন শুরু হয়েছে
                </h3>

                <p>
                    ব্যথা হঠাৎ শুরু হয়েছে নাকি
                    ধীরে ধীরে হয়েছে তা লক্ষ্য করা গুরুত্বপূর্ণ।
                </p>
            ',

            'is_published' => true,

        ]);
    }
}
