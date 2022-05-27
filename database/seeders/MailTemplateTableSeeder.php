<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MailTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('mail_templates')->truncate();

        \DB::table('mail_templates')->insert([
            [
                'title' => '仮申込完了',
                'subject' => '仮申込完了',
                'slug' => 'user.verify',
                'content' => '<p>{user_name}様</p>
<p>次の URL から必ずプロフィール登録をしてください。</p>
<p><a href="{url_verify}">{url_verify}</a></p>
<p>よろしくお願いいたします。</p>',
                'memo' => 'このメールは仮申込完了の時に送信されます。'
            ]
        ]);
    }
}
