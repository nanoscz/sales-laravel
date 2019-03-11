<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Income;
use App\Person;
use App\User;
use App\IncomeDetail;

use Carbon\Carbon;

class IncomeController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $search = $request->search;
        $option = $request->option; 

        if ($search == '') {
            $incomes = Income::join('person','income.id_provider','=','person.id')
            ->join('users','income.id_user','=','users.id')
            ->select('income.id', 'income.type_voucher', 'income.series_voucher', 'income.num_voucher', 
            'income.date','income.tax', 'income.total', 'income.state', 'person.name', 'users.username')
            ->orderBy('income.id','desc')->paginate(5);
        } else {
            $incomes = Income::join('person','income.id_provider','=','person.id')
            ->join('users','income.id_user','=','users.id')
            ->select('income.id', 'income.type_voucher', 'income.series_voucher', 'income.num_voucher', 
            'income.date','income.tax', 'income.total', 'income.state', 'person.name', 'users.username')
            ->where('income.'.$option,'like','%'. $search .'%') ->orderBy('income.id','desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total' => $incomes->total(),
                'current_page' => $incomes->currentPage(),
                'per_page' => $incomes->perPage(),
                'last_page' => $incomes->lastPage(),
                'from' => $incomes->firstItem(),
                'to' => $incomes->lastItem()
            ],
            'incomes' => $incomes
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getHeader(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $incomes = Income::join('person','income.id_provider','=','person.id')
        ->join('users','income.id_user','=','users.id')
        ->select('income.id', 'income.type_voucher', 'income.series_voucher', 'income.num_voucher', 
        'income.date','income.tax', 'income.total', 'income.state', 'person.name', 'users.username')
        ->where('income.id','=',$id)
        ->orderBy('income.id','desc')->take(1)->get();

        return ['income' => $income];
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getDetail(Request $request)
    {   
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $details = IncomeDetail::join('article','income_detail.id_article','=','article.id')
        ->select('income_detail.quantity', 'income_detail.price', 'article.name as article')
        ->where('income_detail.id_income','=',$id)
        ->orderBy('income_detail.id','desc')->get();

        return ['details' => $details];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            DB::beginTransaction();
            $mytime = Carbon::now('America/Lima');

            $income = new Income();
            $income->id_provider = $request->id_provider;
            $income->id_user = \Auth::user()->id;

            $income->type_voucher = $request->type_voucher;
            $income->series_voucher = $request->series_voucher;            
            $income->num_voucher = $request->num_voucher;
            $income->date = $mytime->toDateString();
            $income->tax = $request->tax;
            $income->total = $request->total;
            $income->state = 'register';
            $income->save();

            $details = $request->data;

            foreach ($details as $key => $value) {
                $income_detail = new IncomeDetail();
                $income_detail->id_income = $income->id;
                $income_detail->id_article = $value['id_article'];
                $income_detail->quantity = $value['quantity'];
                $income_detail->price = $value['price'];
                $income_detail->save();
            }

            DB::commit();

        } catch (Exteption $e) {
            DB::rollBack();
        }       
    }

    /**
     * changeState the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeState(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $income = Income::findOrFail($request->id);
        if ($income->state === 'register') {
            $income->state = 'canceled';
        }
        $income->save();
    }
}
