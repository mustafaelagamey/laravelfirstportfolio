<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        Model::unguard();

        function unzip($file , $destination=null){

            $zip=zip_open(realpath(".")."/".$file);
            if(!$zip) {return("Unable to proccess file '{$file}'");}

            $e='';

            while($zip_entry=zip_read($zip)) {
                $zdir=dirname(zip_entry_name($zip_entry));
                $zname=zip_entry_name($zip_entry);

                if(!zip_entry_open($zip,$zip_entry,"r")) {$e.="Unable to proccess file '{$zname}'";continue;}

                if (is_null($destination))
                    $zdir = dirname($file).ltrim($zdir,'.');
                else
                    $zdir=$destination.ltrim($zdir,'.');
                var_dump($zdir);
                if(!is_dir($zdir)) mkdirr($zdir,0777);

                print "{$zdir} | {$zname} \n";

                $zip_fs=zip_entry_filesize($zip_entry);
                if(empty($zip_fs)) continue;

                $zz=zip_entry_read($zip_entry,$zip_fs);

                $z=fopen($zdir.DIRECTORY_SEPARATOR.$zname,"w");
                fwrite($z,$zz);
                fclose($z);
                zip_entry_close($zip_entry);

            }
            zip_close($zip);

            return($e);
        }

        function mkdirr($pn,$mode=null) {

            if(is_dir($pn)||empty($pn)) return true;
            $pn=str_replace(array('/', ''),DIRECTORY_SEPARATOR,$pn);

            if(is_file($pn)) {trigger_error('mkdirr() File exists', E_USER_WARNING);return false;}

            $next_pathname=substr($pn,0,strrpos($pn,DIRECTORY_SEPARATOR));
            if(mkdirr($next_pathname,$mode)) {if(!file_exists($pn)) {return mkdir($pn,$mode);} }
            return false;

        }

        unzip("images.zip" ,'siteImages');

















        // $this->call(UserTableSeeder::class);


        $privileges = [
            'Read Post' => 'post.read',  // subscriber
            'Create Post' => 'post.create',  // creator
            'Edit Post' => 'post.edit',   //editor
            'Delete Post' => 'post.delete', // admin

            'Restore Post' => 'post.restore', // main admin
            'Delete Post Permanent' => 'post.deletePermanent', // main admin

            'Read user' => 'user.read',
            'Deactivate user' => 'user.deactivate',  //admin
            'Edit User' => 'user.edit',
            'activate user' => 'user.activate',
            'disable user' => 'user.disable', // main admin
            'enable user' => 'user.enable', // main admin
            'Create user' => 'user.create',

            'Read Image' => 'image.read',  // subscriber
            'Create Image' => 'image.create',  // creator
            'Edit Image' => 'image.edit',   //editor
            'Delete Image' => 'image.delete', // admin

            'Restore Image' => 'image.restore', // main admin
            'Delete Image Permanent' => 'image.deletePermanent', // main admin

            'Edit Privilege' => 'privilege.edit', // main admin

            'Read comment' => 'comment.read',  // subscriber
            'Create comment' => 'comment.create',  // creator
            'Edit comment' => 'comment.edit',   //editor
            'Delete comment' => 'comment.delete', // admin

            'Restore Comment' => 'comment.restore', // main admin
            'Delete Comment Permanent' => 'comment.deletePermanent', // main admin

            'Read tag' => 'tag.read',  // subscriber
            'Create tag' => 'tag.create',  // creator
            'Edit tag' => 'tag.edit',   //editor
            'Delete tag' => 'tag.delete', // admin

            'Restore tag' => 'tag.restore', // main admin
            'Delete tag Permanent' => 'tag.deletePermanent', // main admin


            'Read log' => 'log.read',  // subscriber

            'Delete log' => 'log.delete', // admin

            'Restore Log' => 'log.restore', // main admin

            'Delete Log Permanent' => 'log.deletePermanent', // main admin


        ];





        foreach ($privileges as $key => $privilege) {
            $this->privileges[] = \App\Privilege::create(['name' => $key, 'access' => $privilege]);
        }

        $createdUsers = [];
        $createdPosts = [];
        $createdPostsImages = [];
        $createdImages = [];

        //seeding roles
        $roles = ['subscriber', 'creator', 'editor', 'admin', 'mainAdmin'];
        $imageNumber = 10;
        foreach ($roles as $key => $role) {
            $roleInstance = \App\Role::create(['name' => $role]);

            $shortName = substr($role, 0, 3);
            $user = [
                'email' => "$shortName@$shortName.$shortName",
                'name' => "$shortName$shortName",
                'password' => bcrypt("$shortName$shortName"),
                'role_id' => $key + 1,
                'activated' => true,
            ];


            $user = \App\User::create($user);

            $createdUsers[] = $user;

            for ($i = 1; $i <= 3; $i++) {


                $seed = str_split(' abcdefghijklmnopqrstuvwxyz '
                    . ' ABCDEFGHIJKLMNOPQRSTUVWXYZ '); // and any other characters
                shuffle($seed); // probably optional since array_is randomized; this may be redundant
                $title = $seed;
                shuffle($seed); // probably optional since array_is randomized; this may be redundant
                $subject = $seed;

                $rand = '';
                foreach (array_rand($title, 30) as $k) $rand .= $title[$k];
                $randomTitle = $rand;
                foreach (array_rand($subject, 56) as $k) $rand .= $subject[$k];
                $randomSubject = $rand;


                $post = \App\Post::create(['title' => $randomTitle, 'subject' => $randomSubject]);


                $createdPosts[] = $post;
                if ($i < 3) {
                    $image = \App\Image::create(['name' => 'test' . $imageNumber . '.jpg', 'title' => $randomTitle]);
                    $image->user()->associate($createdUsers[array_rand($createdUsers)]);

                    // saving data in hasOne relationship
                    $post->image()->save($image);
                    $imageNumber++;
                    $createdPostsImages[] = $image;
                }
                $post->writer()->associate($user);
                $post->updater()->associate($user);
                $post->save();

            }

            switch ($role) {
                case 'subscriber' :
                    $this->attachPrivilege([1, 14], $roleInstance);
                    break;
                case 'creator' :
                    $this->attachPrivilege([1, 2, 14, 15], $roleInstance);
                    break;
                case 'editor' :
                    $this->attachPrivilege([1, 2, 3, 14, 15, 16], $roleInstance);
                    break;
                case 'admin' :
                    $this->attachPrivilege([1, 2, 3, 4, 7, 8, 14, 15, 16, 17], $roleInstance);
                    break;
                case 'mainAdmin' :
                    $this->attachPrivilege(range(1, count($privileges)), $roleInstance);
                    break;
            }
        }


        // creating images album
        for ($i = 1; $i <= 9; $i++) {

            $seed = str_split(' abcdefghijklmnopqrstuvwxyz '
                . ' ABCDEFGHIJKLMNOPQRSTUVWXYZ '); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $title = $seed;

            $rand = '';
            foreach (array_rand($title, 30) as $k) $rand .= $title[$k];
            $randomTitle = $rand;
            $image = \App\Image::create(['name' => 'test0' . $i . '.jpg', 'title' => $randomTitle]);

            $image->user()->associate($createdUsers[array_rand($createdUsers)]->id)->save();

            $createdImages[] = $image;

        }


        //creating comments for posts
        for ($j = 1; $j <= 50; $j++) {
            $seed = str_split(' abcdefghijk lmnopqrstuvwxyz '
                . ' ABCDEFGHIJKL MNOPQRSTUVWXYZ '); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $subject = $seed;

            $rand = '';
            foreach (array_rand($subject, 30) as $k) $rand .= $subject[$k];
            $randomSubject = $rand;

            $comment = \App\Comment::create(['subject' => $randomSubject]);

            $comment->user()->associate($createdUsers[array_rand($createdUsers)]);

            $createdPosts[array_rand($createdPosts)]->comments()->save($comment);

        }


        //creating comments for images
        for ($j = 1; $j <= 50; $j++) {
            $seed = str_split(' abcdefghijk lmnopqrstuvwxyz '
                . ' ABCDEFGHIJKL MNOPQRSTUVWXYZ '); // and any other characters

            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $subject = $seed;

            $rand = '';
            foreach (array_rand($subject, 30) as $k) $rand .= $subject[$k];
            $randomSubject = $rand;

            $comment = \App\Comment::create(['subject' => $randomSubject]);

            $comment->user()->associate($createdUsers[array_rand($createdUsers)]);
            $createdPostsImages[array_rand($createdPostsImages)]->comments()->save($comment);

        }


        //creating comments for images

        for ($j = 1; $j <= 50; $j++) {
            $seed = str_split(' abcdefghijk lmnopqrstuvwxyz '
                . ' ABCDEFGHIJKL MNOPQRSTUVWXYZ '); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $subject = $seed;

            $rand = '';
            foreach (array_rand($subject, 30) as $k) $rand .= $subject[$k];
            $randomSubject = $rand;

            $comment = \App\Comment::create(['subject' => $randomSubject]);

            $comment->user()->associate($createdUsers[array_rand($createdUsers)]);
            $createdImages[array_rand($createdImages)]->comments()->save($comment);

        }

        //creating tags for testing
        for ($j = 1; $j <= 50; $j++) {
            $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
            shuffle($seed); // probably optional since array_is randomized; this may be redundant
            $subject = $seed;

            $rand = '';
            foreach (array_rand($subject, 10) as $k) $rand .= $subject[$k];
            $randomTag = $rand;

            $tag = \App\Tag::create(['title' => $randomTag]);

            $tag->user()->associate($createdUsers[array_rand($createdUsers)]);


            $tagTaggedImages = [];

            for ($k = 1; $k <= rand(5, 10); $k++) {
                $selectedImageForTag = $createdImages[array_rand($createdImages)];
                if (!in_array($selectedImageForTag, $tagTaggedImages)) {
                    $tagTaggedImages[] = $selectedImageForTag;
                    $selectedImageForTag->tags()->save($tag);
                }
            }

            $tagTaggedPosts = [];
            for ($k = 1; $k <= rand(5, 10); $k++) {
                $selectedPostForTag = $createdPosts[array_rand($createdPosts)];
                if (!in_array($selectedPostForTag, $tagTaggedPosts)) {
                    $tagTaggedPosts[] = $selectedPostForTag;
                    $selectedPostForTag->tags()->save($tag);
                }
            }
            $tagTaggedPostImages = [];
            for ($k = 1; $k <= rand(5, 10); $k++) {
                $selectedPostImageForTag = $createdPostsImages[array_rand($createdPostsImages)];
                if (!in_array($selectedPostImageForTag, $tagTaggedPostImages)) {
                    $tagTaggedPostImages[] = $selectedPostImageForTag;
                    $selectedPostImageForTag->tags()->save($tag);
                }
            }
        }


        Model::reguard();
    }


    protected function attachPrivilege(array $privileges, \App\Role $role)
    {
        foreach ($privileges as $p) {
            $role->privileges()->attach($this->privileges[$p - 1]);
        }
    }

    protected function attachPost(\App\Post $post, \App\User $user)
    {

    }

    protected $privileges = [];
    protected $roles = [];
}
