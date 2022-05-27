<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('tags')->truncate();

        $tags = [
            '婚活',
            '恋活',
            'バスツアー',
            '街コン',
            'オンライン婚活',
            '初心者おすすめ',
            '個室',
            '趣味が合う',
            '価値観が合う',
            '人柄重視',
            '高身長男子',
            'ハイステータス',
            'キレイ系',
            'かわいい系',
            '癒し系',
            'スレンダーな女性',
            'ぽっちゃり女子',
            '大人の女性',
            '大人の男性',
            'オシャレ',
            'スタイル抜群',
            '同年代',
            '20代向け',
            '30代向け',
            '40代向け',
            '50代向け',
            'バツイチ',
            '再婚',
            '年の差',
            '年上女性と年下男性',
            '大人の魅力',
            '頼りになる男性',
            '甘えたい女性',
            'インドア派',
            'アウトドア派',
            '旅行好き',
            '食べ歩き',
            'スイーツ好き',
            'お酒好き',
            '料理好き',
            '動物好き',
            'スポーツ観戦',
            '一緒に体験',
            '人気の職業',
            '連絡先交換OK',
            '女性無料',
        ];

        foreach ($tags as $tag) {
            \DB::table('tags')->insert([
                [
                    'title' => $tag,
                    'created_at'     => Carbon::now()->subWeek(1),
                    'updated_at'     => Carbon::now()->subWeek(1),
                ]
            ]);
        }
        

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
