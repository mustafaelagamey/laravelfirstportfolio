<?php

namespace App\Http\Controllers;

use App\Events\ExecutedAction;
use App\Image;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ImageController extends Controller
{


    public function __construct()
    {

        $this->middleware('auth');
        $this->middleware('activation', ['except' => ['index']]);


        $privileges = [
            'image.read' => ['index'],
            'image.create' => ['create', 'store'],
            'image.edit' => ['edit', 'update'],
            'image.delete' => ['destroy'],
            'image.deletePermanent' => ['permanentDelete'],
            'image.restore' => ['restore'],

        ];

        foreach ($privileges as $key => $privilege) {
            $this->middleware('privilege:' . $key, ['only' => $privilege]);

        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        return Redirect::route('image.indexAdmin');
        if (Auth::user()->hasAccess('image.deletePermanent') || Auth::user()->hasAccess('image.restore'))
            return $this->indexAdmin();

        $images = Image::all();


        return view('image.index', compact('images'));
    }

    public function indexAdmin()
    {
        //

        $images = Image::withTrashed()->get();


        return view('image.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('image.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, ['title' => 'required|min:25', 'image' => 'image|required|max:100']);
        $newImage = new Image();
        $newImage->title = $request->title;

        if ($request->hasFile('image')) {
            if (!is_null($request->image)) {
                $destination = 'siteImages';
                $image = $request->image;
                $extension = $image->guessClientExtension();
                $extensionLength = strlen($extension);
                $fullImageName = $image->getClientOriginalName();
                $originalName = substr($fullImageName, 0, strlen($fullImageName) - $extensionLength - 1);
                if ($extensionLength < 6) {
                    $newImageName = substr($originalName, 0, 30) . time() . rand(1111, 9999) . '.' . $extension;
//                    $newImageName = substr_replace($imageName, $replacement, 0)
                    $image->move($destination, $newImageName);
                    $newImage->name = $newImageName;

                } else {
                    $newImage->name = null;
                }
            }

        }

        $newImage->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $newImage));

        return Redirect::route('image.index');

    }

    public static function storePostImage($post, $postImage)
    {
        //
        $newImage = new Image();
        $newImage->title = $post->title;
        $destination = 'siteImages';
        $image = $postImage;
        $extension = $image->guessClientExtension();
        $extensionLength = strlen($extension);
        $fullImageName = $image->getClientOriginalName();
        $originalName = substr($fullImageName, 0, strlen($fullImageName) - $extensionLength - 1);
        if ($extensionLength < 6) {
            $newImageName = substr($originalName, 0, 30) . time() . rand(1111, 9999) . '.' . $extension;
//                    $newImageName = substr_replace($imageName, $replacement, 0)
            $image->move($destination, $newImageName);
            $imageInstance = new Image();
            $imageInstance->name = $newImageName;
            $imageInstance->title = $post->title;
            $post->image()->save($imageInstance);
        } else {
            $post->image = null;
        }
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post->image));
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $image = Image::findOrFail($id);
        return view('image.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $image = Image::findOrFail($id);
        return view('image.edit', compact('image'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //


        $this->validate($request, ['title' => 'required|min:25', 'image' => 'image|max:100']);
        $editedImage = Image::findOrFail($id);
        $editedImage->title = $request->title;

        $oldImageName = $editedImage->name;
        if ($request->hasFile('image')) {
            if (!is_null($request->image)) {
                $destination = 'siteImages';
                $image = $request->image;
                $extension = $image->guessClientExtension();
                $extensionLength = strlen($extension);
                $fullImageName = $image->getClientOriginalName();
                $originalName = substr($fullImageName, 0, strlen($fullImageName) - $extensionLength - 1);
                if ($extensionLength < 6) {
                    $newImageName = substr($originalName, 0, 30) . time() . rand(1111, 9999) . '.' . $extension;
//                    $newImageName = substr_replace($imageName, $replacement, 0)
                    $image->move($destination, $newImageName);
                    $editedImage->name = $newImageName;
                    File::delete($destination . DIRECTORY_SEPARATOR . $oldImageName);
                }
            }
        }
        $editedImage->save();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $editedImage));

        return Redirect::route('image.index');
    }

    public static function updatePostImage($post, $postImage)
    {
        //

        {
            $destination = 'siteImages';
            $image = $postImage;
            $extension = $image->guessClientExtension();
            $extensionLength = strlen($extension);
            $fullImageName = $image->getClientOriginalName();
            $originalName = substr($fullImageName, 0, strlen($fullImageName) - $extensionLength - 1);
            if ($extensionLength < 6) {
                $newImageName = substr($originalName, 0, 30) . time() . rand(1111, 9999) . '.' . $extension;
//                    $newImageName = substr_replace($imageName, $replacement, 0)
                $image->move($destination, $newImageName);

                $imageInstance = new Image();
                $imageInstance->name = $newImageName;
                $imageInstance->title = $post->title;

                if (!is_null($post->image))
                    $post->image->post()->dissociate()->save();
                $post->image()->save($imageInstance);
            }
        }


        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $post->image));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $destroyedImage = Image::findOrFail($id);
        $destroyedImage->delete();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $destroyedImage));

        return Redirect::route('image.index');

    }

    public function permanentDelete($id)
    {

        //
        $deletedImage = Image::withTrashed()->findOrFail($id);
        $deletedImage->forceDelete();

        $deletedImage->comments()->delete();
        $deletedImage->tags()->detach();
        $deletedImage->post()->dissociate();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $deletedImage));


        return Redirect::route('image.index');

    }

    public function restore($id)
    {
        //
        $restoredImage = Image::withTrashed()->findOrFail($id);
        $restoredImage->restore();
        event(new ExecutedAction(Auth::user(), debug_backtrace(1, 1)[0]['function'], $restoredImage));

        return Redirect::route('image.index');

    }
}
