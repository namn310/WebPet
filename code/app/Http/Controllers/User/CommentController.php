<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Comment;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (Auth::guard('customer')->check()) {
                $idCus = Auth::guard('customer')->user()->id;
                $comment = Comment::create([
                    'title' => $request->input('commentTitle'),
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                    'idCus' => $idCus,
                    'idPro' => $id

                ]);
                DB::commit();
                return response()->json([
                    'message' => "Tạo mới comment thành công",
                    'user_name' => $this->getNameCus($idCus),
                    'user_avatar' => $this->getAvtCus($idCus),
                    'commentTitle' => $request->input('commentTitle'),
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh')
                ]);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => $e]);
        }
    }
    public function getAvtCus($id)
    {
        $user = DB::table('customer')->select('image')->where('id', $id)->first();
        return $user->image;
    }
    public function getNameCus($id)
    {
        $user = DB::table('customer')->select('name')->where('id', $id)->first();
        return $user->name;
    }
}
