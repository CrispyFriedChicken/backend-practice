<?php

use Illuminate\Database\Seeder;
use App\Enum\UserRoleEnum;
use App\User;
use App\Enum\GameTypeEnum;
use App\Models\SerialSetting;


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
        //序號設定
        if (1) {
            $settings = [
                GameTypeEnum::slot => [
                    'prefix' => 'S',
                    'length' => 3,
                ],
                GameTypeEnum::fish => [
                    'prefix' => 'F',
                    'length' => 3,
                ],
                GameTypeEnum::poker => [
                    'prefix' => 'P',
                    'length' => 3,
                ],
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
