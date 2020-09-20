<?php

use App\Course;
use App\Category;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slugify = new Slugify();

        $course = new Course();
        $course->title = 'Les bases de Symfony 4';
        $course->subtitle = 'Apprendre les bases de Symfony 4';
        $course->slug = $slugify->slugify($course->title);
        $course->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in velit at eros varius elementum ac nec lorem. Maecenas placerat massa quis turpis congue accumsan. Suspendisse imperdiet lectus quam. Quisque vitae accumsan justo. Vestibulum scelerisque lacinia eros vitae finibus. Ut vel orci iaculis, imperdiet elit sed, eleifend neque. Proin magna augue, tincidunt in nisl eget, accumsan pulvinar nunc. Ut a rhoncus est. Sed consectetur non enim in vehicula. Donec pharetra ac lorem non lacinia.';
        $course->price = 19.99;
        $course->category_id = Category::all()->random(1)->first()->id;
        $course->save();

        $course = new Course();
        $course->title = 'Créer un site ecommerce avec Wordpress';
        $course->subtitle = 'Construire un site ecommerce complet avec Wordpress';
        $course->slug = $slugify->slugify($course->title);
        $course->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in velit at eros varius elementum ac nec lorem. Maecenas placerat massa quis turpis congue accumsan. Suspendisse imperdiet lectus quam. Quisque vitae accumsan justo. Vestibulum scelerisque lacinia eros vitae finibus. Ut vel orci iaculis, imperdiet elit sed, eleifend neque. Proin magna augue, tincidunt in nisl eget, accumsan pulvinar nunc. Ut a rhoncus est. Sed consectetur non enim in vehicula. Donec pharetra ac lorem non lacinia.';
        $course->price = 14.99;
        $course->category_id = Category::all()->random(1)->first()->id;
        $course->save();

        $course = new Course();
        $course->title = 'Les bases de Laravel 7';
        $course->subtitle = 'Créer une plateforme d\'enseignement avec Laravel 7';
        $course->slug = $slugify->slugify($course->title);
        $course->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam in velit at eros varius elementum ac nec lorem. Maecenas placerat massa quis turpis congue accumsan. Suspendisse imperdiet lectus quam. Quisque vitae accumsan justo. Vestibulum scelerisque lacinia eros vitae finibus. Ut vel orci iaculis, imperdiet elit sed, eleifend neque. Proin magna augue, tincidunt in nisl eget, accumsan pulvinar nunc. Ut a rhoncus est. Sed consectetur non enim in vehicula. Donec pharetra ac lorem non lacinia.';
        $course->price = 39.99;
        $course->category_id = Category::all()->random(1)->first()->id;
        $course->save();
    }
}
