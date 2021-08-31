<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\DateHelper;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::latest()->paginate(5);
        $column = $request->get('field');
        $direction = $request->get('direction');
        
        if ($direction) {
           
            //$sortOrder = $request->session()->get('sortOrder', 'desc');
            $users = User::orderBy($column, $direction)->paginate(5);
        }elseif($column)
        {
           
            $users = User::orderBy($column, 'desc')->paginate(5);
        }
            //$sortOrder = $sortOrder == 'desc' ? 'asc': 'desc';
           // $request->session()->put('sortOrder', $sortOrder);            
        
     
        return view('users.index', ['users' => $users])
            ->with('i', (request()->input('page', 1) - 1) * 5);
           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];
        
        return view('users.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  /*
       $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'image' => 'required',
            'category'=> 'required',
            'tags'=> 'required'

        ]);*/        
       
        
        $imageName = time().'-'.$request->name . '.'.$request->image->extension();
        $request->image->move(public_path(User::PHOTO_PATH), $imageName);
        
        //$birthday = $request->year. '-' . $request->month . '-' . $request->day;
        

        $users = User::create([
            'name' => $request->input('name'),
            'surname' => $request->input('surname'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'phone_number' => $request->input('phone_number'),
            'photo' => $imageName,
            'category_id' => $request->get('category'),
            'birthday' => $request->input('birthday')
            
        ]);
        if ($request->tags != ''){

            foreach ($request->tags as $tag) {
                $users->tags()->attach($tag);
            }
        }


        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        $user->birthday = substr($user->birthday, 0, strrpos($user->birthday, ' '));

        $birthday = Carbon::parse($user->birthday);
        $currentYear = $birthday->year(date('Y'));
        $diffInDays = Carbon::now()->diffInDays($birthday, false);
        
        $remainingDays = $diffInDays;

        if ($diffInDays < 0) {
            $currentYear->addYears(1);
            $remainingDays = Carbon::now()->diffInDays($birthday, false);  
        }

        return view('users.show', compact('user'))->with('remainingDays', $remainingDays);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $categories = Category::all();
        $tags = Tag::all();
        
        //$currentCategory = $user->category_id;
        
        $currentUserTags = DB::table('tag_user')->where('user_id','=',$user->id)->pluck('tag_id')->all();
        
        
    
        $data = [
            'categories' => $categories,
            'tags' => $tags,
            'currentTags' => $currentUserTags
        ];
        
        
        return view('users.edit', compact('user'))->with($data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'category_id'=> 'required',
            //'photo' => 'required|photo|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        $data = $request->all();
        

        

        $data['tags'] = $user->tags()->sync($request->tags);
        
        

        if ($request->photo != '') {
            $path = public_path('images');

             //code for remove old file
            if(file_exists('images/'.$user->photo && $user->photo != '')) {  
             
               $fileOld = 'images/'.$user->photo;
               unlink($fileOld);
            }

            $fileName = $request->namtime().'-'.e.'.'. $request->photo->extension(); 
            $request->photo->move($path, $fileName);
            //$data = $request->all();
            $data['photo'] = $fileName;
        }
        //dd($request->delete_image);
        if (isset($request->delete_image)) {   
            $new_value = '';

            $data['photo'] = $new_value;
            if (file_exists('images/' . $user->photo) && $user->photo != '') {
               $fileOld = 'images/' . $user->photo;
               //var_dump($fileOld);
               unlink($fileOld);
           }
           
        }
        
        //dd($data);
        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        if (file_exists('images/'.$user->photo)){
            @unlink('images/'.$user->photo);
        }

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
