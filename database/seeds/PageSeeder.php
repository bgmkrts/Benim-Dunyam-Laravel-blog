<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages=['Hakkımızda','Kariyer','Vizyonumuz','Misyonumuz'];
        $count=0;
        foreach($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title'=>$page,
                'slug'=>str_slug($page),
                'image'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQSZa5pMbGEH1lHesBOZyhZaLl2aZjzpTotBY-SA8n5fj7C5PAf',
                'contents'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam id dui velit. Nullam sed nunc ac sem ullamcorper dictum et at elit. Aliquam hendrerit interdum sagittis. Donec hendrerit nulla vitae neque malesuada facilisis. Nullam varius, tellus nec luctus varius, ante urna suscipit leo, quis mollis erat magna id quam. Duis id lectus quis metus rutrum convallis in et purus. Nullam condimentum ornare blandit. Donec pharetra sem arcu, eu viverra eros pulvinar accumsan. Sed non justo elit.

            Quisque volutpat pretium iaculis. Duis a nulla lobortis, ultricies sapien sit amet, fermentum massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam mollis fermentum nulla eget vulputate. Aenean ut lobortis justo. Praesent ac pellentesque mauris. Aenean non diam eleifend, ultricies ligula ac, ultricies risus. Nunc ornare ipsum dolor, non placerat odio tincidunt nec. Aliquam consequat purus nec neque blandit ultricies. Proin quis ultricies nibh, ac consequat lacus. In porttitor eget dolor pulvinar pretium.

            Curabitur laoreet tincidunt hendrerit. Quisque in neque massa. Maecenas luctus ante id nisi viverra aliquam. Aenean tincidunt felis eu molestie maximus. Etiam non felis id augue rutrum posuere. Phasellus ut consectetur urna. Integer sed mollis odio. Cras non tristique nulla, sit amet porttitor urna. Pellentesque luctus ornare magna efficitur condimentum. In iaculis neque egestas luctus euismod. Nulla  Nulla pharetra justo sed viverra consequat. Sed laoreet justo sit amet rhoncus luctus. Praesent consectetur iaculis augue sit amet porttitor. Donec ultrices dictum neque, vitae tempor mi pulvinar nec. Curabitur scelerisque justo ipsum, a fermentum tellus mollis sit amet. Etiam eu mauris luctus, egestas elit at, ullamcorper tellus. Phasellus ultrices',
                'order'=>$count,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
