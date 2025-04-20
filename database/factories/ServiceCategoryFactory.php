<?php
namespace Database\Factories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceCategory>
 */

class ServiceCategoryFactory extends Factory
{
    protected $model = ServiceCategory::class;

    // Govt livestock office service names in Bengali
    protected static array $serviceNames = [
        'গবাদি পশুর টিকা প্রদান',
        'বিভিন্ন রোগ নির্ণয় ও চিকিৎসা',
        'কৃমিনাশক ওষুধ প্রদান',
        'গবাদি পশুর কৃত্রিম প্রজনন (AI) সেবা',
        'গবাদি পশুর গর্ভধারণ পরীক্ষা',
        'পশুখাদ্য পরামর্শ ও সরবরাহ',
        'খামার ব্যবস্থাপনা প্রশিক্ষণ',
        'গবাদি পশুর রোগ প্রতিরোধ প্রশিক্ষণ',
        'পশুর রক্ত বা নমুনা সংগ্রহ',
        'খামার পরিদর্শন ও পরামর্শ',
        'ভেটেরিনারি সার্টিফিকেট প্রদান',
        'পোলট্রি রোগ নির্ণয় ও চিকিৎসা',
        'গবাদি পশুর চিকিৎসা ক্যাম্প',
        'প্রাণিসম্পদ সংক্রান্ত সচেতনতামূলক কার্যক্রম',
        'ভেটেরিনারি ফার্মেসি সেবা',
        'পশু পালনে প্রযুক্তি হস্তান্তর',
        'খামার নিবন্ধন ও আইডি প্রদান',
        'পশুর স্বাস্থ্য বিষয়ক পরামর্শ',
        'উন্নত জাতের পশু নির্বাচনে সহায়তা',
        'গাভী ও ছাগলের দুধ উৎপাদন উন্নয়ন পরামর্শ',
    ];

    public function definition(): array
    {
        $name               = Arr::random(self::$serviceNames);
        self::$serviceNames = array_diff(self::$serviceNames, [$name]);

        return [
            'name'        => $name,
        ];
    }
}
