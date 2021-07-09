<?php


namespace App\Enum;

use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GamesEnum
{

    public static function getCodeTitleMap()
    {
        $codeTitleMap = [];
        $rows = DB::table('games')->get();
        foreach ($rows as $row) {
            $codeTitleMap[$row->code] = "{$row->code} - {$row->chineseName} ( {$row->englishName} )";
        }
        return $codeTitleMap;
    }


    public static function getFakeTypeMaps()
    {
        return [
            GameTypeEnum::fish => self::getFakeFishMap(),
            GameTypeEnum::poker => self::getFakePokeMap(),
            GameTypeEnum::slot => self::getFakeSlotMap(),
        ];
    }

    public static function getFakeFishMap()
    {
        return [
            'Colorful fishing' => '多彩捕魚',
            'Mermaid Treasure' => '人魚寶藏',
            'Jin Duo Duo Fishing 360' => '金多多捕魚360',
            'The Mermaid Queen' => '人魚女王',
            'Fishing' => '捕魚',
            'Deep Sea Tour' => '深海遨游',
            'Loch Ness Monster' => '尼斯湖水怪',
            'Penguin Power' => '企鵝力量',
            'Fishermen\'s Fun' => '漁民樂',
            'Mr. Beaver Logging' => '海狸伐木先生',
            'Marine Creatures' => '海洋生物',
            'Fortune Aquarium' => '財富水族箱',
        ];
    }

    public static function getFakeSlotMap()
    {
        return [
            'Gem Legend' => '寶石傳奇',
            'Zodiac' => '十二生肖',
            'Baby Pet' => '寶貝寵物',
            'Chang\'e Moon Appreciation' => '嫦娥賞月',
            'Xian Xia' => '仙侠',
            'Cosmic Milky Way' => '宇宙銀河',
            'Rich hot pot' => '富貴火鍋',
            'Tricky Expert' => '整蠱專家',
            'Ancient Egypt' => '古老埃及',
            'Special Forces' => '特種部隊',
            'F1 racing' => 'F1賽車',
            'Lucky Candy Car' => '幸運糖果車',
            'Sweet Fruit Garden' => '甜甜水果園',
            'The underwater world' => '海底世界',
            'Dahua Westward Journey' => '大話西遊',
            'Greek mythology' => '希臘神話',
            'Poker King' => '撲克王',
            'Roman Warrior' => '羅馬戰士',
            'Sichuan Opera changes face' => '川劇變臉',
            'Lucky Little Fairy' => '幸運小妖精',
            'Selfie Palace' => '自拍宮殿',
            'Football fan' => '足球狂迷',
            'Traditional Slot Machine' => '傳統老虎機',
            'Dessert Factory' => '甜品工廠',
            'Mr. Zombie' => '殭屍先生',
            'King of the Road' => '公路之王',
            'Naughty Pirate' => '淘氣海盜',
            'Dragon Tiger' => '龍虎',
            'San Gong' => '三公',
            'Mr. Love' => '戀愛先生',
            'Five Blessings' => '五福臨門',
            'Jin Ping Mei' => '金瓶梅',
            'Little Pig Jinjin' => '小豬金金',
            'There are trees in the south' => '南方有喬木',
            'Travel Frog' => '旅行青蛙',
            'Football Star' => '足球之星',
            'The best of the ocean' => '海洋之最',
            'Dessert Little Mary' => '甜品小瑪莉',
            'Welcome to the God of Wealth' => '迎財神',
            'Neon keno' => '霓虹基諾',
            'Hawaiian tiki' => '夏威夷提基',
            'The Three-Star Announcement of Fu Lu Shou' => '福祿壽之三星報喜',
            'Vampire Feast' => '吸血鬼盛宴',
            'Lucky gem' => '幸運寶石',
            'Golden City' => '黃金迷城',
            'Pac-Elf' => '吃豆小精靈',
            'Halloween Carnival' => '萬聖節狂歡',
            'DJ Little Mary' => 'DJ 小瑪莉',
            'Christmas Carol' => '聖誕歡樂頌',
            'Win the world' => '贏天下',
            'Super Baccarat' => '超級百家樂',
            'Golden Rat gives blessing' => '金鼠送福',
            'Auspicious Lucky Cat' => '吉祥招財貓',
            'Military Division' => '軍師聯盟',
            'Three Kingdoms Heroes' => '三國群英',
            'Pet baby' => '寵物寶寶',
            'Ru Yi Chuan' => '如懿傳',
            'Three Lives and Three Worlds Renew the Frontier' => '三生三世再續前緣',
            'Journey to the West Little Mary' => '西遊小瑪莉',
            'Shaolin Temple' => '少林寺',
            'Wuxin Mage' => '無心法師',
            'Dong Ying and Fu Le' => '東瀛和福樂',
            'The Legend of the White Snake' => '白蛇傳',
            'golf Club' => '高爾夫俱樂部',
            'Bikini beach' => '比基尼沙灘',
            'Lucky Boy' => '招財童子',
            'Pokemon' => '神奇寶貝',
            'Korean BBQ' => '韓國 BBQ',
            'Fruit King' => '水果王',
            'Fun Monkey' => '樂趣猴',
            'Dragon Emperor World' => '龍皇天下',
            'Flowers blooming rich and honorable' => '花開富貴',
            'Caesar Empire' => '凱撒帝國',
            'Rudolph the Reindeer' => '馴鹿魯道夫',
            'Treasure Hunting Little Monkey' => '奪寶小靈猴',
            'Winnie the Witch' => '女巫溫妮',
            'Police and Bandits Chase' => '警匪追逐',
            'Ghost Ship' => '幽靈船',
            'Ice Storm' => '冰雪風暴',
            'Heavenly Officials Give Treasures' => '天官賜寶',
            'Ancient Warrior' => '古代戰士',
            'Aladdin\'s Wish' => '阿拉丁的願望',
            'Earl of Vampire' => '吸血伯爵',
            'Futanlong' => '伏藏龍',
            'Exotic Treasures' => '奇珍異寶',
            'Three Kingdoms Contending for Hegemony' => '三國爭霸',
            'All the way to the end' => '一路搶到底',
            'Dream Garden' => '夢幻花園',
            'Gold Mine Exploration' => '金礦探索',
            'The Villain Coyote' => '惡棍郊狼',
            'Cleopatra' => '埃及豔后',
            'Golden Beard' => '金鬍子',
            'Secret Symbol' => '秘密符號',
            'Ancient Beast' => '遠古神獸',
            'Neon Shanghai' => '霓虹上海',
            'Police and Bandit Chase 2' => '警匪追逐2',
            'Eternal Love' => '永恆的愛',
            'Rudolph\'s Revenge' => '魯道夫的復仇',
            'Dream Garden II' => '夢幻花園 II',
            'Ninja Star' => '忍者星',
            'Picnic outside' => '郊外野餐',
            'Three Happiness Comes to the Door' => '三喜臨門',
            'Maomao Adventure' => '毛毛大冒險',
            'Perfect Pet' => '完美寵物',
            'The God of Wealth arrives' => '財神到',
            'rainbow' => '彩虹',
            'Rich Valence' => '里奇·瓦倫斯',
            'Fire Dragon Agent' => '火龍特務',
            'Wu Zetian' => '武則天',
            'Samba Sunset' => '桑巴日落',
            'Magic Panda' => '魔幻貓熊',
            'Mexican Wrestling 2' => '墨西哥摔角2',
            'Pig full of crown' => '豬滿冠',
            'Voodoo Witchcraft' => '伏都巫術',
            'Asa\'s Domain' => '阿薩神域',
            'Rural Family' => '農村人家',
            'Model Dream' => '模特夢',
            'Pinata Carnival' => '皮納塔狂歡',
            'Stardust' => '星塵',
            'Football Frenzy' => '足球狂熱',
            'Storm of Kings' => '王者風暴',
            'Happy Ghost Party' => '開心鬼派對',
            'Gem Paradise' => '寶石天堂',
            'Aristocratic Rich' => '貴族富豪',
            'Lucky Football' => '幸運足球',
            'Blessing' => '福氣',
            'Wonderful Christmas' => '奇妙聖誕',
            'Tyrannosaurus' => '暴龍',
            'Redneck' => '鄉下佬',
            'Secret Jungle' => '秘密叢林',
            'Panda Gold' => '熊貓黃金',
            'Heaven and Earth Elements' => '天地元素',
            'tornado' => '龍捲風',
            'Fun Christmas' => '繽紛聖誕',
            'Ancient Greek Hero' => '古希臘英雄',
            'Kung Fu Rooster' => '功夫雄雞',
            'Northern School Kung Fu' => '北派功夫',
            'Mini Commando' => '迷你特攻隊',
            'Western Happy Double Meeting' => '西部喜雙逢',
            'Winnie the Witch 2' => '女巫溫妮 2',
            'Fat Cat Coffee' => '肥貓咖啡'
        ];
    }

    public static function getFakePokeMap()
    {
        return [
            'TPG777' => 'TPG777',
            'Sic Bo' => '骰寶',
            'Happy Mahjong Hall' => '歡樂麻將館',
            'Tarot card' => '塔羅牌',
            'DJ jump' => 'DJ跳',
            'Five dragons spit out beads' => '五龍吐珠',
            'Crown 7' => '皇冠7',
            'The Book of Kowloon' => '九龍之書',
            'Super Six Baccarat' => '超級六百家樂',
            'Golden Dragon God 360' => '金龍神360',
            'Lucky 6' => '幸運6',
            'Tyrannosaurus 2' => '暴龍 2',
            'Lucky 8' => '幸運 8',
            'Super 6' => '超級 6',
        ];
    }
}

