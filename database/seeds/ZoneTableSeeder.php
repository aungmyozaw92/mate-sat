<?php

use App\Models\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ZoneTableSeeder extends Seeder
{
    protected $data = [
        ['name' => 'Ahlone', 'mm_name' => 'အလုံ'],
        ['name' => 'Bahan', 'mm_name' => 'ဗဟန်း'],
        ['name' => 'Botahtaung', 'mm_name' => 'ဗိုလ်တထောင်'],
        ['name' => 'Cocokyun Town', 'mm_name' => 'ကိုးကိုးကျွန်း'],
        ['name' => 'Dagon', 'mm_name' => 'ဒဂုံ'],
        ['name' => 'Dagon Myothit (East)', 'mm_name' => 'ဒဂုံမြို့သစ်အရှေ့ပိုင်း'],
        ['name' => 'Dagon Myothit (North) Town', 'mm_name' => 'ဒဂုံမြို့သစ်(မြောက်ပိုင်း)'],
        ['name' => 'Dagon Myothit (Seikkan)', 'mm_name' => 'ဒဂုံမြို့သစ်ဆိပ်ကမ်း'],
        ['name' => 'Dagon Myothit (South) Town', 'mm_name' => 'ဒဂုံမြို့သစ်(တောင်ပိုင်း)'],
        ['name' => 'Dala', 'mm_name' => 'ဒလ'],
        ['name' => 'Dawbon', 'mm_name' => 'ဒေါပုံ'],
        ['name' => 'Hlaing', 'mm_name' => 'လှိုင်'],
        ['name' => 'Hlaingtharya Town', 'mm_name' => 'လှိုင်သာယာ'],
        ['name' => 'Hlegu Town', 'mm_name' => 'လှည်းကူး'],
        ['name' => 'Hmawbi Town', 'mm_name' => 'မှော်ဘီ'],
        ['name' => 'Htantabin Town', 'mm_name' => 'ထန်းတပင်'],
        ['name' => 'Insein', 'mm_name' => 'အင်းစိန်'],
        ['name' => 'Kamaryut', 'mm_name' => 'ကမာရွတ်'],
        ['name' => 'Kawhmu Town', 'mm_name' => 'ကော့မှူး'],
        ['name' => 'Kayan Town', 'mm_name' => 'ခရမ်း'],
        ['name' => 'Kungyangon Town', 'mm_name' => 'ကွမ်းခြံကုန်း'],
        ['name' => 'Kyauktada', 'mm_name' => 'ကျောက်တံတား'],
        ['name' => 'Yangon Town', 'mm_name' => 'ရန်ကုန်'],
        ['name' => 'Kyauktan Town', 'mm_name' => 'ကျောက်တန်း'],
        ['name' => 'Tadar Town', 'mm_name' => 'တံတား'],
        ['name' => 'Kyeemyindaing', 'mm_name' => 'ကြည့်မြင်တိုင်'],
        ['name' => 'Lanmadaw', 'mm_name' => 'လမ်းမတော်'],
        ['name' => 'Latha', 'mm_name' => 'လသာ'],
        ['name' => 'Mayangone', 'mm_name' => 'မရမ်းကုန်း'],
        ['name' => 'Htaukkyant Town', 'mm_name' => 'ထောက်ကြန့်'],
        ['name' => 'Mingaladon', 'mm_name' => 'မင်္ဂလာဒုံ'],
        ['name' => 'Mingalartaungnyunt', 'mm_name' => 'မင်္ဂလာတောင်ညွန့်'],
        ['name' => 'North Okkalapa', 'mm_name' => 'မြောက်ဥက္ကလာပ'],
        ['name' => 'Pabedan', 'mm_name' => 'ပန်းပဲတန်း'],
        ['name' => 'Pazundaung', 'mm_name' => 'ပုဇွန်တောင်'],
        ['name' => 'Sanchaung', 'mm_name' => 'စမ်းချောင်း'],
        ['name' => 'Seikgyikanaungto', 'mm_name' => 'ဆိပ်ကြီးခနောင်တို'],
        ['name' => 'Seikkan', 'mm_name' => 'ဆိပ်ကမ်း'],
        ['name' => 'Shwepyithar Town', 'mm_name' => 'ရွှေပြည်သာ'],
        ['name' => 'South Okkalapa', 'mm_name' => 'တောင်ဥက္ကလာပ'],
        ['name' => 'Ahpyauk Town', 'mm_name' => 'အဖျောက်'],
        ['name' => 'Okekan Town', 'mm_name' => 'ဥက္ကံ'],
        ['name' => 'Taikkyi Town', 'mm_name' => 'တိုက်ကြီး'],
        ['name' => 'Tamwe', 'mm_name' => 'တာမွေ'],
        ['name' => 'Thaketa', 'mm_name' => 'သာကေတ'],
        ['name' => 'Thanlyin Town', 'mm_name' => 'သန်လျင်'],
        ['name' => 'Thingangyun', 'mm_name' => 'သင်္ဃန်းကျွန်း'],
        ['name' => 'Thongwa Town', 'mm_name' => 'သုံးခွ'],
        ['name' => 'Twantay Town', 'mm_name' => 'တွံတေး'],
        ['name' => 'Yankin', 'mm_name' => 'ရန်ကင်း'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        foreach ($this->data as $row) {
            factory(Zone::class)->create([
                'name' => $row["name"],
                'mm_name' => $row["mm_name"],
            ]);
        }
        Schema::enableForeignKeyConstraints();
        // Schema::disableForeignKeyConstraints();
        // factory(Zone::class, 20)->create();
        // Schema::enableForeignKeyConstraints();
    }
}
