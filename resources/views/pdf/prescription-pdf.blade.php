<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <title>{{ $prescription->serviceRecord->farm->farm_name }} - প্রেসক্রিপশন</title>
    <style>
        body {
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 12pt;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            padding: 20px;
        }

        .info-table td {
            padding: 10px 20px;
            font-size: 12pt;
        }

        .rx-table td {
            padding: 20px;
            vertical-align: top;
            height: 500px;
        }

        .section-title {
            font-size: 18pt;
        }

        .rx-title {
            font-style: italic;
            font-size: 16pt;
        }

        .px-title {
            font-size: 14pt;
            font-style: italic;
        }

        .footer-note {
            font-size: 10pt;
            text-align: center;
            margin-top: 20px;
        }

        hr {
            margin: 0;
            border: 0;
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td width="50%">
                <div class="section-title">ডাঃ উজ্জ্বল কুমার কুন্ডু</div>
                <div>ডিভিএম, এমএস ইন প্যারাসাইটোলজী (বাকৃবি)</div>
                <div>বিসিএস (প্রাণিসম্পদ)</div>
                <div>উপজেলা প্রাণিসম্পদ অফিসার</div>
                <div>উপজেলা প্রাণিসম্পদ দপ্তর ও ভেটেরিনারি হাসপাতাল</div>
                <div>হরিণাকুন্ডু, ঝিনাইদহ</div>
                <div>বিভিএ রেজি: নং-৩৭৯৫</div>
                <div>মোবাইল: ০১৭১৬-১৫১২৩৭</div>
            </td>
            <td width="50%" style="text-align: right;">
                <div class="section-title">Dr. Uzzal Kumar Kundu</div>
                <div>DVM, MS in Parasitology (BAU)</div>
                <div>BCS (Livestock)</div>
                <div>Upazila Livestock Officer</div>
                <div>Upazila Livestock Office & Veterinary Hospital</div>
                <div>Harinakundu, Jhenaidaha</div>
                <div>BVA Reg. No-3795</div>
                <div>Mobile: 01716-151237</div>
            </td>
        </tr>
    </table>

    <hr>

    {{-- Patient Info --}}
    <table class="info-table" style="width: 100%; table-layout: fixed;">
        <tr>
            <td style="">
                মালিকের নাম: {{ $prescription->serviceRecord->farm->owner_name }},
                {{ en2bn($prescription->serviceRecord->farm->phone_number) }}
            </td>
            <td style="">
                খামার: {{ $prescription->serviceRecord->farm->farm_name }}
                ({{ en2bn($prescription->serviceRecord->farm->unique_id) }})
            </td>
            <td style="">
                গবাদি প্রাণি: {{ $prescription->livestockType->name }}
            </td>
            <td style="">
                বয়স: {{ $prescription->livestock_age }}
            </td>
            <td style="">
                ওজন: {{ $prescription->livestock_weight }}
            </td>
            <td style="">
                তারিখ: {{ en2bn($prescription->created_at->format('d/m/Y')) }}
            </td>
        </tr>
    </table>


    <hr>

    {{-- Diagnosis and Rx --}}
    <table class="rx-table">
        <tr>
            <td width="35%">
                <div class="px-title">রোগের বিবরণ:</div>
                <div>
                    {!! $prescription->disease_brief !!}
                </div>
                <br>
                <div>Tem: {{ $prescription->livestock_temp }}</div>
                <div>Pulse: {{ $prescription->livestock_pulse }}</div>
                <div>Rumen Motility: {{ $prescription->livestock_rumen_motility }}</div>
                <div>Respiratory Rate: {{ $prescription->livestock_respiratory }}</div>
                <div>Other: {{ $prescription->livestock_other }}</div>
            </td>
            <td width="2%" style="border-left: 1px solid #999;"></td>
            <td width="63%">
                <div class="rx-title">Rx</div>
                {{-- Add prescription items dynamically if needed --}}
                {!! ($prescription->medication) !!}

                @if ($prescription->additional_notes)
                    <br><br>
                    <div style="background-color: yellow;">{{ $prescription->additional_notes }}</div>
                @endif
            </td>
        </tr>
    </table>

    <hr>

    <table width="100%" style="font-size: 10pt; text-align: center; margin-top: 10px">
        <tr>
            <td style="width: 50%;">বিঃদ্রঃ ঔষধ পরিবর্তন নিষেধ।</td>
            <td style="width: 50%;">পুনরায় সাক্ষাতের দিন ব্যবস্থাপত্র অবশ্যই সঙ্গে নিয়ে আসবেন।</td>
        </tr>
    </table>


</body>

</html>
