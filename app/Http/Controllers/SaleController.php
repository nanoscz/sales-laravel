<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Sale;
use App\Person;
use App\User;
use App\SaleDetail;


class SaleController extends Controller
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
            $sales = Sale::join('person','sales.id_client','=','person.id')
            ->join('users','sales.id_user','=','users.id')
            ->select('sales.id', 'sales.type_voucher', 'sales.series_voucher', 'sales.num_voucher', 
            'sales.date','sales.tax', 'sales.total', 'sales.state', 'person.name as client', 'users.username')
            ->orderBy('sales.id','desc')->paginate(5);
        } else {
            $sales = Sale::join('person','sales.id_client','=','person.id')
            ->join('users','sales.id_user','=','users.id')
            ->select('sales.id', 'sales.type_voucher', 'sales.series_voucher', 'sales.num_voucher', 
            'sales.date','sales.tax', 'sales.total', 'sales.state', 'person.name', 'users.username')
            ->where('sales.'.$option,'like','%'. $search .'%') ->orderBy('sales.id','desc')->paginate(5);
        }
        return [
            'pagination' => [
                'total' => $sales->total(),
                'current_page' => $sales->currentPage(),
                'per_page' => $sales->perPage(),
                'last_page' => $sales->lastPage(),
                'from' => $sales->firstItem(),
                'to' => $sales->lastItem()
            ],
            'sales' => $sales
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function getHeader(Request $request)
    {   
        // if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $sales = Income::join('person','sales.id_client','=','person.id')
        ->join('users','sales.id_user','=','users.id')
        ->select('sales.id', 'sales.type_voucher', 'sales.series_voucher', 'sales.num_voucher', 
        'sales.date','sales.tax', 'sales.total', 'sales.state', 'person.name', 'users.username')
        ->where('sales.id','=',$id)
        ->orderBy('sales.id','desc')->take(1)->get();

        return ['sales' => $sales];
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
        $details = SaleDetail::join('article','sales_detail.id_article','=','article.id')
        ->select('sales_detail.quantity', 'sales_detail.price', 'sales_detail.discount', 'article.name as article')
        ->where('sales_detail.id_sale','=',$id)
        ->orderBy('sales_detail.id','desc')->get();

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

            $sale = new Sale();
            $sale->id_client = $request->id_client;
            $sale->id_user = \Auth::user()->id;

            $sale->type_voucher = $request->type_voucher;
            $sale->series_voucher = $request->series_voucher;            
            $sale->num_voucher = $request->num_voucher;
            $sale->date = $mytime->toDateString();
            $sale->tax = $request->tax;
            $sale->total = $request->total;
            $sale->state = 'register';
            $sale->save();

            $details = $request->data;

            foreach ($details as $key => $value) {
                $sale_detail = new SaleDetail();
                $sale_detail->id_sale = $sale->id;
                $sale_detail->id_article = $value['id_article'];
                $sale_detail->quantity = $value['quantity'];
                $sale_detail->price = $value['price'];
                $sale_detail->discount = $value['discount'];
                $sale_detail->save();
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
        $sale = Sale::findOrFail($request->id);
        if ($sale->state === 'register') {
            $sale->state = 'canceled';
        }
        $sale->save();
    }
}
