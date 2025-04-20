<!DOCTYPE html>
<html lang="bn">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ $farm->unique_id }} ID Card</title>
    <style>
        @page {
            margin: 0;
        }

        /* Apply SolaimanLipi to all elements */
        body,
        h1,
        h2,
        h3,
        th,
        td,
        span,
        div {
            font-weight: normal;
        }

        body {
            text-align: center;
            padding: 10mm 0;
        }

        .card-container {
            background-color: #f0f4fa;
            height: 85.6mm;
            width: 54mm;
            border: 1px solid #4f4f4f;
            padding: 15px 10px;
            box-sizing: border-box;
            margin: 0 auto 2mm;
            display: block;
            page-break-inside: avoid;
        }

        .logo {
            width: 50px;
            height: auto;
            margin-bottom: 5px;
        }

        .header {
            font-size: 18px;
            line-height: 1.2;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .qr {
            width: 100px;
            height: 100px;
            margin: 20px auto 20px auto;
            display: block;
        }

        .info {
            font-size: 13px;
            margin-top: 6px;
        }

        .info-front {
            text-align: center;
        }

        .info-back {
            text-align: left;
        }

        .row {
            margin-bottom: 4px;
        }

        .label {
            font-weight: bold;
        }

        .note {
            font-size: 10px;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    {{-- SPACER to push FRONT SIDE down --}}
    <div style="height: 5mm;"></div>

    {{-- FRONT SIDE --}}
    <div class="card-container">
        <img src="{{ public_path('assets/img/icon.png') }}" class="logo" alt="logo">
        <div class="header">উপজেলা প্রাণিসম্পদ দপ্তর ও ভেটেরিনারি হাসপাতাল, হরিণাকুণ্ডু, ঝিনাইদহ</div>

        <img class="qr" src="{{ public_path($farm->qr_code) }}" alt="QR Code">

        <div class="info info-front">
            <div class="row"><span class="label">খামারের নাম:</span> {{ $farm->farm_name }}</div>
            <div class="row"><span class="label">মালিকের নাম:</span> {{ $farm->owner_name }}</div>
            <div class="row"><span class="label">খামার আইডি:</span> {{ $farm->unique_id }}</div>
        </div>
    </div>

    {{-- BACK SIDE --}}
    <div class="card-container">
        {{-- Government Logo --}}
        <div style="text-align: center; margin-bottom: 4px;">
            <img src="{{ public_path('assets/img/bd-govt-logo.png') }}" alt="gov-logo"
                style="height: 150px; opacity: .2">
        </div>

        {{-- Main Info --}}
        <div class="info info-back">
            <div class="row"><span class="label">ঠিকানা:</span> {{ $farm->address }}, {{ $farm->union->name }}, হরিণাকুন্ডু, ঝিনাইদহ</div>
            <div class="row"><span class="label">মোবাইল:</span> {{ en2bn($farm->phone_number) }}</div>
            <div class="row"><span class="label">অনুমোদনের তারিখ:</span>
                {{ en2bn($farm->approved_at->format('d-m-Y')) }}</div>
            <div class="row"><span class="label">অনুমোদনকারী:</span> {{ $farm->approvedBy->name ?? 'N/A' }}</div>
        </div>

        {{-- Spacer to push note down --}}
        <div style="flex-grow: 1;"></div>

        {{-- Bottom Note --}}
        <div class="note">
            এই কার্ডটি সরকারি সেবা গ্রহণের সময় অবশ্যই সাথে আনতে হবে।
        </div>
    </div>


</body>

</html>
