<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Topup;
use App\Credit;
use Illuminate\Support\Facades\Hash;
use DB;

class TopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Topup::where('checked',null)->orderBy('created_at' , 'asc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'image' => 'required|base64image',
            'amount' => 'required|integer',
            'transfer_method' => 'required',
        ]);

        $user_id = auth('api')->user()->id;
        $topupCount = Topup::where([
            ['user_id', $user_id],
            ['checked', null]
        ])->count();
        
        if($topupCount < 1)
        {
            $image = $request->image;
            $amount = $request->amount;
            $transfer_method = $request->transfer_method;
                    
            $name = rand().'.'.explode('/',explode(':', substr($image,0,strpos($image, ';')))[1])[1];
            \Image::make($image)->save(public_path('images/cheques/').$name);

            $user = User::findOrFail($user_id);
            $user->topups()->create([
                'user_id' => $user_id,
                'image' => $name,
                'amount' => $amount,
                'transfer_method' => $transfer_method,
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
            ], 403);
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topup = Topup::where('id' ,$id)->get();
        return $topup[0]->image;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCredit()
    {
        $user_id = auth('api')->user()->id;
        $credit = Credit::where('user_id', $user_id)->get();
        return $credit[0]->amount;
    }

    public function getUserCredit()
    {
        $user_id = \Request::get('q');
        $credit = Credit::where('user_id', $user_id)->get();
        return $credit[0]->amount;
    }

    public function valid(Request $request)
    {
        $this->validate($request,[
            'reference_id' => 'required',
        ]);

        $check = DB::table('topups')->where([
            ['transfer_method', $request->transfer_method],
            ['reference_id', $request->reference_id],
        ])->count();

        if($check > 0 ){
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
            ], 403);
        }else{
            $topupID = $request->id;
            $userID = $request->user_id;
            $amount = $request->amount;
            $reference_id = $request->reference_id;
            $status = "valid";
            $user = User::findOrFail($userID);
            DB::table('topups')->where('id', $topupID)->update(['checked' => true]);
            DB::table('topups')->where('id', $topupID)->update(['valid' => true]);
            DB::table('topups')->where('id', $topupID)->update(['reference_id' => $reference_id]);
            DB::table('topups')->where('id', $topupID)->update(['status' => $status]);
            $user->credit()->increment('amount', $amount);  
        }

    }

    public function unvalid(Request $request)
    {
        $topupID = $request->id;
        $status = "unvalid";
        DB::table('topups')->where('id', $topupID)->update(['checked' => true]);
        DB::table('topups')->where('id', $topupID)->update(['valid' => false]);
        DB::table('topups')->where('id', $topupID)->update(['status' => $status]);
    }

    public function success()
    {
        return Topup::where('valid', true)->orderBy('created_at' , 'desc')->paginate(10);
    }

    public function rejected()
    {
        return Topup::where('valid', false)->orderBy('created_at' , 'desc')->paginate(10);
    }

    public function searchSuccessTopup()
    {
        if($search = \Request::get('q')){
            $success = Topup::where([
                ['user_id', $search],
                ['valid', true]
            ])->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $success = Topup::Where('valid', true)->orderBy('created_at', 'desc')->paginate(10);
        }
        return $success;
    }
    public function searchRejectedTopup()
    {
        if($search = \Request::get('q')){
            $rejects = Topup::where([
                ['user_id', $search],
                ['valid', false]
            ])->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $rejects = Topup::Where('valid', false)->orderBy('created_at', 'desc')->paginate(10);
        }
        return $rejects;
    }

    public function getProfile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        $user_id = auth('api')->user()->id;
        $user = User::findOrFail($user_id);

        $this->validate($request,[
            'name' => 'required|unique:users,phone,'.$user->id,
            'user_password' => 'sometimes|string|min:8',
            'phone' => 'required|string|max:11|unique:users,phone,'.$user->id,
            'user_city' => 'required',
        ]);

        if(!empty($request->user_password)){
            $user->password = Hash::make($request['user_password']);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->user_city = $request->user_city;
        $user->save();
    }

    public function userTopup()
    {
        $user_id = auth('api')->user()->id;
        $topups = Topup::where('user_id', $user_id)->orderBy('created_at' , 'desc')->paginate(10);
        return $topups;
    }

    public function getUser()
    {
        $users[0] = DB::table('users')->orderBy('created_at', 'desc')->paginate(10);
        $users[1] = User::all()->count();
        return $users;
    }

    public function searchUser()
    {
        if($search = \Request::get('q')){
            $user = User::where('id', $search)->paginate(1);
        }else{
            $user = DB::table('users')->orderBy('created_at', 'desc')->paginate(10);
        }
        return $user;
    }
}
