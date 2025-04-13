<?php

namespace Database\Factories;

use App\Models\Disease;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disease>
 */

class DiseaseFactory extends Factory
{
    protected $model = Disease::class;

    // Livestock diseases in Bengali
    protected static array $diseaseNames = [
        'মুখ ও খুর রোগ',
        'এন্থ্রাক্স (তড়কা রোগ)',
        'ব্রুসেলোসিস',
        'ম্যাস্টাইটিস (স্তনদূষ রোগ)',
        'রেবিস (হাইড্রোফোবিয়া)',
        'কালা পঁচা (ব্ল্যাকলেগ)',
        'গরুর যক্ষা',
        'লামপি স্কিন ডিজিজ',
        'ছোট ruminant এর প্লেগ (PPR)',
        'নিউক্যাসল রোগ',
        'বার্ড ফ্লু (এভিয়ান ইনফ্লুয়েঞ্জা)',
        'ভেড়ার গুটি রোগ',
        'ছাগলের গুটি রোগ',
        'সোয়াইন ফিভার',
        'কক্সিডিওসিস',
        'হেমোরেজিক সেপটিসেমিয়া',
        'জোনস রোগ',
        'এন্টারোটক্সিমিয়া',
        'ই-কোলাই সংক্রমণ',
        'অ্যাকটিনোমাইকোসিস'
    ];

    public function definition(): array
    {
        $name = Arr::random(self::$diseaseNames);
        self::$diseaseNames = array_diff(self::$diseaseNames, [$name]);

        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
        ];
    }
}

