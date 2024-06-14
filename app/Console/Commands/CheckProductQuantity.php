<?php

namespace App\Console\Commands;

use App\Models\Goods;
use Illuminate\Console\Command;

class CheckProductQuantity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'goods:qty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check product quantity and send WhatsApp message if less than 20';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $goods = Goods::with(['in' => function ($query) {
            $query->where('verified', 1);
        }, 'out' => function ($query) {
            $query->where('verified', 1);
        }])
            ->where('verified', 1)
            ->get();

        foreach ($goods as $value) {
            $in = $value->in->sum('qty');
            $out = $value->out->sum('qty');

            $stock = $in - $out;

            // Periksa apakah stok kurang dari 20
            if ($stock < 20) {
                $this->sendWa($value->name, $stock); // Panggil fungsi sendWa dengan nama barang dan stok
            }
        }
    }

    // public function sendWa($goods_name, $stock)
    // {
    //     $curl = curl_init();
    //     $phone = '6285161380351';
    //     $token = 'kcWqz1dpbNoL73zD5wxv';

    //     $message = "Stok $goods_name saat ini adalah $stock. Segera lakukan pengadaan tambahan.";

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.fonnte.com/send',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => array(
    //             'target' => $phone,
    //             'message' => $message,
    //         ),
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: $token"
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);
    //     echo $response;
    // }

    public function sendWa($goods_name, $stock)
    {
        $message = "Stok $goods_name saat ini adalah $stock. Segera lakukan pengadaan tambahan.";

        $body = array(
            "api_key" => "f6a4f54170873b0bd3e0872f410fe740401fff6f",
            "receiver" => "6287889116984",
            "data" => array(
                "message" => $message,

            )
        );

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "http://wabot.appnis.net:5570/api/send-message",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_HTTPHEADER => [
                "Accept: /",
                "Content-Type: application/json",
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
