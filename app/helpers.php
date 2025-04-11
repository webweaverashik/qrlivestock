<?php

// English number to Bangla number conversion
function en2bn($number)
{
    $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'minutes', 'minute', 'hours', 'hour', 'days', 'day', 'weeks', 'week', 'months', 'month', 'years', 'year', 'ago', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', 'মিনিট', 'মিনিট', 'ঘণ্টা', 'ঘণ্টা', 'দিন', 'দিন', 'সপ্তাহ', 'সপ্তাহ', 'মাস', 'মাস', 'বছর', 'বছর', 'আগে', 'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'];
    
    return str_replace($en, $bn, $number);
}
