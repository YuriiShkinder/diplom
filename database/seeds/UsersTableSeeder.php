<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\User::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 10;
        DB::table('users')->insert([
            'name' => 'Yurii',
            'last' => 'Shkinder',
            'login' => 'yurii',
            'phone' => '+380686873719',
            'address' => 'Odesa' ,
            'img' => asset('assets/images/user.png'),
            'email' => 'yurkaaa96@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ]);
        Storage::disk('s3')->exists('users') ?  Storage::disk('s3')->deleteDirectory('users') : false;
        for ($i = 0; $i < $limit; $i++) {
                $filepath = 'test.jpg';
                $url = $faker->imageUrl(340,280,'people');
                $fp = fopen($filepath, 'w+');
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                $success = curl_exec($ch) && curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200;
                fclose($fp);
                curl_close($ch);
                if (!$success) {
                    unlink($filepath);
                    return false;
                }
                $s3 = \Storage::disk('s3');
                $name= "users/".str_random(6).".jpg";
                if($s3->put($name, file_get_contents($filepath), 'public')){
                    DB::table('users')->insert([
                        'name' => $faker->firstName,
                        'last' => $faker->lastName,
                        'login' => $faker->unique()->word,
                        'phone' => $faker->phoneNumber,
                        'address' => $faker->address ,
                        'img' => $name,
                        'email' => $faker->email,
                        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
                    ]);
                }
        }
    }
}
