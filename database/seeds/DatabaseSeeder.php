<?php

use Illuminate\Database\Seeder;
use App\Enum\UserRoleEnum;
use App\User;
use App\Models\SerialSetting;
use App\Models\GameType;
use App\Models\Currency;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $admin = User::where(['email' => 'test@gmail.com'])->first();
        if (!$admin) {
            $this->initDataBase();
        }
        $this->call(GamesTableSeeder::class);
        $this->call(PlayersTableSeeder::class);
        $this->call(ThreeMonthOrderSeeder::class);
    }


    /**
     * 資料庫初始化
     * @throws Exception
     */
    protected function initDataBase()
    {
        //新增管理員資料
        DB::table('users')->insert([
            'uuid' => (string)Uuid::generate(4),
            'name' => 'Alan',
            'email' => 'test@gmail.com',
            'password' => Hash::make('test1234'),
            'role' => UserRoleEnum::ADMIN,
        ]);


        //遊戲類型設定
        if (1) {
            $sources = [
                'slot' => 'Slot',
                'fish' => 'Fish',
                'poker' => 'Poker',
            ];
            $serial = 1;
            foreach ($sources as $name => $title) {
                $gameType = new GameType();
                $gameType->code = $serial;
                $gameType->name = $name;
                $gameType->title = $title;
                $gameType->save();
                $serial++;
            }
        }

        //幣別設定
        if (1) {
            $sources = [
                'TWD' => '台幣',
                'USD' => '美金',
                'GBD' => '英鎊',
                'CNY' => '人民幣',
            ];
            $serial = 1;
            foreach ($sources as $name => $title) {
                $currency = new Currency();
                $currency->code = $serial;
                $currency->name = $name;
                $currency->title = $title;
                $currency->save();
                $serial++;
            }
        }

        //序號設定
        if (1) {
            $settings = [
                'round' => [
                    'prefix' => 'R',
                    'dateRule' => 'ymd',
                    'length' => 4,
                ],
                'order' => [
                    'prefix' => 'O',
                    'dateRule' => 'ymd',
                    'length' => 4,
                ],
            ];

            $gameTypes = GameType::get();
            foreach ($gameTypes as $gameType) {
                $settings[$gameType->name] = [
                    'prefix' => strtoupper(substr($gameType->name, 0, 1)),
                    'length' => 3,
                ];
            }

            foreach ($settings as $identifier => $setting) {
                $serialSetting = new SerialSetting();
                $serialSetting->identifier = $identifier;
                foreach ($setting as $key => $value) {
                    $serialSetting->$key = $value;
                }
                $serialSetting->save();
            }
        }
    }
}
