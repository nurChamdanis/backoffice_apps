<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class TransController extends Controller
{
    //

    public function salesChart()
{
  $salesData = DB::select('SELECT MONTHNAME(created_at) AS month, SUM(harga) AS total_sales
                                FROM transactions
                                GROUP BY MONTHNAME(created_at)
                                ORDER BY created_at ASC;');

  $monthlySales = [];
  foreach ($salesData as $row) {
    $monthlySales[] = [
      'month' => $row->month,
      'total_sales' => $row->total_sales,
    ];
  }

        // Optional: Format data for Highcharts (assuming 'month' and 'total_sales' properties)
        $highchartsData = [
             'title' => [
                [
                    'title' => 'Penjualan Bulanan',
                ]
            ],
            'series' => [
                [
                    'name' => 'Total Sales',
                    'data' => array_column($monthlySales, 'total_sales') // Extract data using array_column
                ]
            ],
            'xAxis' => [
                'title' => 'Month',
                'categories' => array_column($monthlySales, 'month') 
            ],
            'yAxis' => [
                'title' => 'Total Sales'
            ]
        ];

        return response()->json($highchartsData); // Return formatted data

}
public function showData(Request $request)
{

        $data = Transactions::select('produk_id', 'tujuan', 'harga') // Select specific columns (optional)
                    ->orderBy('harga', 'desc')
                    ->limit(10)
                    ->get();
        //return view('pages.user.home', compact('transaction'));
        //return response()->json($transaction);
        return response()->json($data);
}

public function produkData(Request $request)
{

        $nata = DB::select('SELECT harga, tujuan, produk_id, name, count(*) AS total
                                 FROM transactions AS t
                                 INNER JOIN product AS p ON t.produk_id = p.code
                                 GROUP BY t.produk_id, t.harga, t.tujuan, p.name
                                 ORDER BY total DESC LIMIT 10;');
        //return view('pages.user.home', compact('transaction'));
        //return response()->json($transaction);
        return response()->json($nata);
}

public function userData(Request $request)
{

        $unata = DB::select('SELECT user_id, name, email, count(*) AS total
                                 FROM transactions AS t
                                 INNER JOIN users AS p ON t.user_id = p.id
                                 GROUP BY t.user_id, p.name, p.email
                                 ORDER BY total DESC LIMIT 10;');
        //return view('pages.user.home', compact('transaction'));
        //return response()->json($transaction);
        return response()->json($unata);
}


    public function pieChart()
{

           // Replace 'Transaction' with your actual model name and adjust query logic as needed
        $productSales =  DB::select('SELECT produk_id, count(*) AS prod, SUM(margin) AS totalmargin 
                                    FROM transactions 
                                    GROUP BY produk_id;');

        // Format data for Google Pie Chart
        $pieData = [];
        foreach ($productSales as $item) {
            $pieData[] = [
                'produk' => 'Product ' . $item->produk_id, // More descriptive label
                'margin' => $item->totalmargin
            ];
        }

        return response()->json($pieData); // Return formatted data

}

 public function regUser()
{
    $jumlahuser = DB::select('SELECT count(*) AS jumlah
                                FROM users;');

     return response()->json($jumlahuser);

     

}

    public function regChart()
{

      $campaignData = DB::select('SELECT MONTHNAME(created_at) AS month, count(*) AS jumlah
                                FROM users
                                GROUP BY month
                                ORDER BY created_at ASC;');
       

        $labels = [];
        $data = [];

        foreach ($campaignData as $dataPoint) {
            $labels[] = $dataPoint->month;
            $data[] = $dataPoint->jumlah;
        }

        // Returning the JSON response
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);

        //return response()->json($campaignData); // Return formatted data

}

 public function transUser()
{
    $jumlahtrans = DB::select('SELECT count(*) AS jumlah
                                FROM transactions
                                WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) AND DAY(created_at) = DAY(CURDATE());');

     return response()->json($jumlahtrans);

     

}

    public function harianChart()
{

      $harianData = DB::select('SELECT DATE(created_at) AS date,
                                COUNT(*) AS totalorder
                                FROM transactions
                                WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())
                                GROUP BY DATE(created_at);
');
       

        $harianlabels = [];
        $hariandata = [];

        foreach ($harianData as $harianPoint) {
            $harianlabels[] = $harianPoint->date;
            $hariandata[] = $harianPoint->totalorder;
        }

        // Returning the JSON response
        return response()->json([
            'harianlabels' => $harianlabels,
            'hariandata' => $hariandata
        ]);

        //return response()->json($campaignData); // Return formatted data

}


//------deposit-----//
public function depositUser()
{
    $jumlahdeposit = DB::select('SELECT count(*) AS jumlah
                                FROM deposits
                                WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE()) AND DAY(created_at) = DAY(CURDATE());');

     return response()->json($jumlahdeposit);

     

}

    public function depositChart()
{

      $depositData = DB::select('SELECT DATE(created_at) AS date,
                                COUNT(*) AS totaldeposit
                                FROM deposits
                                WHERE YEAR(created_at) = YEAR(CURDATE()) AND MONTH(created_at) = MONTH(CURDATE())
                                GROUP BY DATE(created_at);
');
       

        $depolabels = [];
        $depodata = [];

        foreach ($depositData as $harianDeposit) {
            $depolabels[] = $harianDeposit->date;
            $depodata[] = $harianDeposit->totaldeposit;
        }

        // Returning the JSON response
        return response()->json([
            'depositlabels' => $depolabels,
            'depositdata' => $depodata
        ]);

        //return response()->json($campaignData); // Return formatted data

}
//ProdukChart
public function produkUser()
{
    $jumlahproduk = DB::select('SELECT count(*) AS jumlah
                                FROM product;');

     return response()->json($jumlahproduk);

     

}

    public function produkChart()
{

      $produkData = DB::select('SELECT MONTHNAME(created_at) AS month, count(*) AS jumlah
                                FROM product
                                GROUP BY month
                                ORDER BY created_at ASC;;
');
       

        $produklabels = [];
        $produkdata = [];

        foreach ($produkData as $harianproduk) {
            $produklabels[] = $harianproduk->month;
            $produkdata[] = $harianproduk->jumlah;
        }

        // Returning the JSON response
        return response()->json([
            'produklabels' => $produklabels,
            'produkdata' => $produkdata
        ]);

        //return response()->json($campaignData); // Return formatted data

}



}
