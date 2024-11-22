<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Booking::all()->sortByDesc('id');
        return view('Admin.Quanlybook', ['book' => $book]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function confirmBook($id)
    {

        try {
            $book = Booking::find($id);
            $book->status = 1;
            $book->update();
        } catch (Throwable) {
            return redirect(route('admin.book'))->with('error', 'Xác nhận lịch không thành công');
        }
        return redirect(route('admin.book'))->with('notice', 'Xác nhận lịch hẹn thành công');
    }
    public function UnConfirmBook($id)
    {

        try {
            $book = Booking::find($id);
            $book->status = 0;
            $book->update();
        } catch (Throwable) {
            return redirect(route('admin.book'))->with('error', 'Hủy lịch không thành công');
        }
        return redirect(route('admin.book'))->with('notice', 'Hủy lịch hẹn thành công');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name'=>[
        //         'regex:'
        //     ]
        // ]);
        $idCus = Auth::guard('customer')->user()->id;
        try {
            $book = Booking::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'name_service' => $request->input('dichvu'),
                'goi' => $request->input('goi'),
                'weight' => $request->input('weight'),
                'date' => $request->input('date'),
                'note' => $request->input('note'),
                'idCus' => $idCus
            ]);
            //
        } catch (Throwable) {
            return redirect(route('user.book'))->with('error', 'Đặt lịch thất bại !')->withInput();
        }
        return redirect(route('user.book'))->with('notice', 'Đặt lịch thành công ! Bạn có thể kiểm tra lại thông tin lịch hẹn trong phần đơn hàng');
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $book = Booking::find($id)->get();
        return view('Admin.BookDetail', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $idCus = Auth::guard('customer')->user()->id;
        try {
            $book = Booking::find($id);
            $book->name = $request->input('name');
            $book->type = $request->input('type');
            $book->name_service = $request->input('dichvu');
            $book->goi = $request->input('goi');
            $book->weight = $request->input('weight');
            $book->date = $request->input('date');
            $book->note = $request->input('note');
            $book->idCus = $idCus;
            $book->save();
        } catch (Throwable) {
            return redirect(route('user.orderView'))->with('error', 'Cập nhật lịch thất bại !')->withInput();
        }
        return redirect(route('user.orderView'))->with('notice', 'Cập nhật lịch thành công !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Booking::find($id);
        try {
            $book->delete();
        } catch (Throwable) {
            return redirect(route('user.orderView'))->with('error', 'Hủy lịch thất bại !');
        }
        return redirect(route('user.orderView'))->with('notice', 'Hủy lịch thành công !');
    }
}
