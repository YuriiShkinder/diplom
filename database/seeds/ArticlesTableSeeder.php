<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        \App\Article::truncate();
        DB::statement("SET foreign_key_checks=1");

        $faker = Faker\Factory::create();
        $limit = 30;
        Storage::disk('s3')->exists('slider') ?  Storage::disk('s3')->deleteDirectory('slider') : false;
        Storage::disk('s3')->exists('products') ?  Storage::disk('s3')->deleteDirectory('products') : false;

        for ($i = 0; $i < $limit; $i++) {
            $obj = new \stdClass();

            $obj->colection=$this->uploadFoto(true,680,440);
            $obj->slider = $this->uploadFoto('slider',1200,400);
            $img=json_encode($obj);

            $discount=rand(-10,20);
            $discount=$discount>=0?$discount:0;
            DB::table('articles')->insert([
                'title' => $faker->sentence(),
                'text' => $faker->text(800),
                'desc' => $faker->text(500),
                'img' => $img,
                'price' => $faker->numberBetween(50,5000) ,
                'discount' => $discount,
                'category_id' => \App\Category::where('parent_id','>',0)->get()->random()->id,
                'brand_id' => \App\Brand::all()->random()->id,
            ]);
        }
    }

    public function uploadFoto($type,$width,$height){
        $faker = Faker\Factory::create();
        $filepath = 'test.jpg';
        $arr=[];

      if ($type==='slider' || $type==='avatar'){

              $url = $faker->imageUrl($width,$height,array_random(['business','technics','food','city','fashion','transport','nightlife','cats']));
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
              $name= "$type/".str_random(6).".jpg";
              if($s3->put($name, file_get_contents($filepath), 'public')){
                  return  $name;
              }

          return false;

      }else{
          for ($j=0; $j<4;$j++){
              $url = $faker->imageUrl($width,$height,array_random(['business','technics','food','city','fashion','transport','nightlife','cats']));
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
              $name= "products/".str_random(6).".jpg";
              if($s3->put($name, file_get_contents($filepath), 'public')){
                  $arr[]=$name;
              }

          }
          return $arr;

      }


    }
}
