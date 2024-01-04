<?php

namespace App\Http\Controllers;

use App\DataTables\TransactionsDataTable;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    public function home() {
        return view('home');
    }

    public function transaction_list() {
        $data = Transaction::where('user_id', auth()->id())->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('amount', fn ($transaction) => "Rp " . number_format($transaction->amount, 2, ',', '.'))
            ->addColumn('action', function($row){
                $actionBtn = '';

                if($row->type == "topup") $actionBtn = '<a href="javascript:void(0)" onclick="showReceipt(`'.asset("receipt/{$row->transfer_receipt}").'`, `'.$row->transaction_code.'`)" class="show-receipt justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Show Receipt</a>';

                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function add_transaction() {
        return view('add');
    }

    public function save_transaction() {
        $user = auth()->user();
        request()->validate([
            'type' => 'required|string|in:topup,transaction',
            'amount' => 'required',
            'description' => 'required|string|max:200',
            'receipt' => 'required_if:type,==,topup|image|max:2048|mimes:jpeg,png,jpg',
        ]);
        $amount = str_replace(',', '', request()->amount);
        
        try {
            DB::beginTransaction();
            $transaction = Transaction::lockForUpdate();
            
            if(request()->type == "transaction") {
                if($amount > $user->balance) {
                    session()->flash('fail', 'Current Balance not enough');
                    DB::rollBack();
                    return redirect()->back()->withInput(request()->all());
                }

                $transaction->create([
                    'user_id' => $user->user_id,
                    'transaction_code' => 'TRX' . Carbon::now()->unix(),
                    'type' => 'transaction',
                    'amount' => $amount,
                    'description' => request()->description
                ]);
                $user->decrement('balance', $amount);
                session()->flash('success', 'Transaction successfully added');
                DB::commit();
                return redirect()->route('home');
            }

            if(request()->type == "topup") {
                $filename = Str::uuid() . "." . request()->file('receipt')->getClientOriginalExtension();
                request()->file('receipt')->move(public_path("receipt"), $filename);
                $transaction->create([
                    'user_id' => $user->user_id,
                    'transaction_code' => 'TRX' . Carbon::now()->unix(),
                    'type' => 'topup',
                    'amount' => $amount,
                    'description' => request()->description,
                    'transfer_receipt' => $filename
                ]);
                $user->increment('balance', $amount);
                session()->flash('success', 'Transaction successfully added');
                DB::commit();
                return redirect()->route('home');
            }
        }catch(\Exception $e) {
            session()->flash('fail', $e->getMessage());
            DB::rollBack();
            return redirect()->back()->withInput(request()->all());
        }
    }
}
