<?php

use Illuminate\Database\Seeder;
use App\Enum\GamesEnum;
use App\Helper\SerialHelper;
use App\Models\Game;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typeMaps = GamesEnum::getFakeTypeMaps();
        foreach ($typeMaps as $type => $keyMap) {
            foreach ($keyMap as $englishName => $chineseName) {
                $game = new Game();
                $game->uuid = (string)Uuid::generate(4);
                $game->englishName = $englishName;
                $game->chineseName = $chineseName;
                $game->type = $type;
                $game->code = SerialHelper::produce($type);
                $game->save();
            }
        }
    }
}
