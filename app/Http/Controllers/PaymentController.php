<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Session;
use Cart;
use App\User;
use App\Order;
use App\AppUser;
use App\Delivery;
use App\Setting;
use App\Resetpassword;
use App\Item;
use Response;
use Cookie;
use App\FoodOrder;
use App\OrderResponse;
use DateTimeZone;
use DateTime;
use App\Ingredient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderAdminGetMail;
use App\Mail\OrderUserMail;

class PaymentController extends Controller
{
    public function stripe()
    {
        return view("stripe");
    }
    function get_lat_long($address)
    {

        $address = str_replace(" ", "+", $address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=AIzaSyBiVfFZRtrGy8AmV5UH7WZEou_3Hpbc_xg";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);

        $json = json_decode($result);
        // return $json;
        $lat = "";
        $long = "";
        if (isset($json->{'results'}[0])) {
            $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        }

        return $lat . ',' . $long;
    }
    static public function generate_timezone_list()
    {
        static $regions = array(
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        );
        $timezones = array();
        foreach ($regions as $region) {
            $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
        }

        $timezone_offsets = array();
        foreach ($timezones as $timezone) {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }
        asort($timezone_offsets);
        $timezone_list = array();

        foreach ($timezone_offsets as $timezone => $offset) {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate('H:i', abs($offset));
            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
            $timezone_list[] = "$timezone";
        }

        return $timezone_list;
        ob_end_flush();
    }

    public function gettimezonename($timezone_id)
    {
        $getall = $this->generate_timezone_list();
        foreach ($getall as $k => $val) {
            if ($k == $timezone_id) {
                return $val;
            }
        }
    }
    public function pay(Request $request)
    {
        $data = array();
        $finalresult = array();
        $result = array();
        $input = $request->input();
        $cartCollection = Cart::getContent();
        $setting = Setting::find(1);
        $gettimezone = $this->gettimezonename($setting->timezone);
        date_default_timezone_set($gettimezone);
        $date = date('d-m-Y H:i');
        $getuser = AppUser::find(Session::get('login_user'));
        $store = new Order();
        $store->user_id = $getuser->id;
        $store->total_price = number_format($request->get("total_price_or"), 2, '.', '');
        $store->order_placed_date = $date;
        $store->order_status = 0;

        $store->latlong = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("lat_long_or")));
        $store->name = $getuser->name;

        $store->address = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("address_or")));
        $store->email = $getuser->email;

        $store->payment_type = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("payment_type_or")));

        $store->notes = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("note_or")));

        $store->city = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("city_or")));

        $store->shipping_type = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("shipping_type_or")));

        $store->subtotal = number_format($request->get("subtotal_or"), 2, '.', '');

        $store->delivery_charges = number_format($request->get("charage_or"), 2, '.', '');

        $store->phone_no =  strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("phone_or")));
        $store->delivery_mode = $store->shipping_type;
        $store->notify = 1;
        $store->save();
        foreach ($cartCollection as $ke) {
            $getmenu = Item::where("menu_name", $ke->name)->first();
            $result['ItemId'] = (string)isset($getmenu->id) ? $getmenu->id : 0;
            $result['ItemName'] = (string)$ke->name;
            $result['ItemQty'] = (string)$ke->quantity;
            $result['ItemAmt'] = number_format($ke->price, 2, '.', '');
            $totalamount = (float)$ke->quantity * (float)$ke->price;
            $result['ItemTotalPrice'] = number_format($totalamount, 2, '.', '');
            $ingredient = array();
            $inter_ids = array();
            foreach ($ke->attributes[0] as $val) {
                $ls = array();
                $inter = Ingredient::find($val);
                $ls['id'] = (string)$inter->id;
                $inter_ids[] = $inter->id;
                $ls['category'] = (string)$inter->category;
                $ls['item_name'] = (string)$inter->item_name;
                $ls['type'] = (string)$inter->type;
                $ls['price'] = (string)$inter->price;
                $ls['menu_id'] = (string)$inter->menu_id;
                $ingredient[] = $ls;
            }

            $result['Ingredients'] = $ingredient;
            $finalresult[] = $result;
            $adddesc = new OrderResponse();
            $adddesc->set_order_id = $store->id;
            $adddesc->item_id = $result["ItemId"];
            $adddesc->item_qty = $result["ItemQty"];
            $adddesc->ItemTotalPrice = number_format($result["ItemTotalPrice"], 2, '.', '');
            $adddesc->item_amt = $result["ItemAmt"];
            $adddesc->ingredients_id = implode(",", $inter_ids);
            $adddesc->save();
        }
        $data = array("Order" => $finalresult);
        $addresponse = new FoodOrder();
        $addresponse->order_id = $store->id;
        $addresponse->desc = json_encode($data);
        $addresponse->save();
        \Stripe\Stripe::setApiKey(Session::get("stripe_secret"));

        $unique_id = uniqid();
        $charge = \Stripe\Charge::create(array(
            'description' => "Amount: " . $input['total_price_or'] . ' - ' . $unique_id,
            'source' => $request->stripeToken,
            'amount' => (int)($input['total_price_or'] * 100),
            'currency' => 'USD'
        ));

        $data = Order::find($store->id);
        $data->charges_id = $charge->id;
        $data->save();

        // mail to user for order
        $user = AppUser::find(Session::get('login_user'));

        $details = [
            'subject' => 'Message from Indhosnacks.com',
            'greeting' => 'Hi ' . $user->name . ', ',
            'body' => 'You just order a food from Indhosnacks.com. We are happy to let you know that we have received your order. Your payment done by Stripe',
            'email' => 'Your email is : ' . $user->email,
            'phone' => 'Your phone number is : ' . $user->mob_number,
            'thanks' => 'Thank you for using Indhosnacks',
            'site_url' => route('website.home'),
            'site_name' => 'Indhosnacks.com',
            'copyright' => 'Copyright © ' . Carbon::now()->format('Y') . ' ' . 'IndhoSnacks. All rights reserved.',
        ];

        Mail::to($user->email)->send(new OrderUserMail($details));

        // mail to admin for users order
        $adminuser = User::latest()->first();

        $admindetails = [
            'subject' => 'Message from Indhosnacks.com',
            'greeting' => 'Hi ' . $adminuser->name . ', ',
            'body' => $user->name . ' ' . 'just ordred a food form Indosnacks.com. His/Her payment done by Stripe. Please see what he/she order from Indhosnacks.com.',
            'email' => 'His email is : ' . $user->email,
            'phone' => 'His phone number is : ' . $user->mob_number,
            'thanks' => 'Thank you for using Indhosnacks',
            'site_url' => route('website.home'),
            'site_name' => 'Indhosnacks.com',
            'copyright' => 'Copyright © ' . Carbon::now()->format('Y') . ' ' . 'IndhoSnacks. All rights reserved.',
        ];

        Mail::to($adminuser->email)->send(new OrderAdminGetMail($admindetails));

        Cart::clear();
        Session::flash('message', __('messages.order_success'));
        Session::flash('alert-class', 'alert-success');
        return redirect("viewdetails/" . $store->id);
    }

    public function edahabPay(Request $request)
    {
//             dd($request->all());
//        return back();
        $request->validate([
            'edahab_phone' => 'required|integer|digits:9'
        ]);
        $apikey = '7vAb1YbtaU9XDE8CFF1uxf6Zjm19GalcD63F7ZZqW';
        $edahabNumber = $request->edahab_phone ?? '657166178';
        $amount = $request->edahab_total;
        $agentCode = '721759';
        $returnUrl = url('/');
        $request_param = [
            "apiKey" => $apikey,
            "edahabNumber" => $edahabNumber,
            "amount" => $amount,
            "agentCode" => $agentCode,
            "returnUrl" => $returnUrl
        ];
        /* Encode it into a JSON string. */
        $json = json_encode($request_param, JSON_UNESCAPED_SLASHES);
        $hashed = hash('SHA256', $json . "cd5GBclmmx7A4uj8ozZ481qChLk1CQiHIPeaNI");
        $url = "https://edahab.net/api/api/IssueInvoice?hash=" . $hashed;
        $curl = curl_init($url);
        // Tell cURL to send a POST request.
        curl_setopt($curl, CURLOPT_POST, TRUE);
        // Set the JSON object as the POST content.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        // Set the JSON content-type: application/json.
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        // dd($json);
        // Set the return transfer option to true
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Send the request.
        $result = curl_exec($curl);
        // curl_close($curl);
        // Get the InvoiceId from the API response and store it in your database.
        $response = json_decode($result);
        // dd($response);
        // Get the InvoiceId from the API response and store it in your database.
        if($response->ValidationErrors && count($response->ValidationErrors) > 0){
            dd($response->ValidationErrors[0]);
            Session::flash('message', __('Something is wrong!'));
            Session::flash('alert-class', 'alert-danger');
            return back();
        }
        $invoice = $response->InvoiceId;
        $requestId = $response->RequestId;

        $data = array();
        $finalresult = array();
        $result = array();
        $cartCollection = Cart::getContent();
        $setting = Setting::find(1);
        $gettimezone = $this->gettimezonename($setting->timezone);
        date_default_timezone_set($gettimezone);
        $date = date('d-m-Y H:i');
        $getuser = AppUser::find(Session::get('login_user'));
        $store = new Order();
        $store->user_id = $getuser->id;
        $store->edahab_request_id = $requestId;
        $store->edahab_phone = $edahabNumber;
        $store->edahab_invoice = $invoice;
        $store->total_price = number_format($request->get("edahab_total"), 2, '.', '');
        $store->order_placed_date = $date;
        $store->order_status = 0;
        $store->latlong = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("edahab_lat_long")));
        $store->name = $getuser->name;
        $store->address = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("edahab_address")));
        $store->email = $getuser->email;
        $store->payment_type = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("payment_type")));
        $store->notes = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("edahab_note")));
        $store->city = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("edahab_city")));
        $store->shipping_type = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("edahab_shipping_type")));
        $store->subtotal = number_format($request->get("edahab_subtotal"), 2, '.', '');
        $store->delivery_charges = number_format($request->get("eadhab_charage"), 2, '.', '');
        $store->phone_no = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("user_phone")));
        $store->delivery_mode = strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $request->get("edahab_shipping_type")));
        $store->notify = 1;
        $store->save();

        foreach ($cartCollection as $ke) {
            $getmenu = Item::where("menu_name", $ke->name)->first();
            $result['ItemId'] = (string)isset($getmenu->id) ? $getmenu->id : 0;
            $result['ItemName'] = (string)$ke->name;
            $result['ItemQty'] = (string)$ke->quantity;
            $result['ItemAmt'] = (string)$ke->price;
            $totalamount = (float)$ke->quantity * (float)$ke->price;
            $result['ItemTotalPrice'] = number_format($totalamount, 2, '.', '');
            $ingredient = array();
            $inter_ids = array();
            foreach ($ke->attributes[0] as $val) {
                $ls = array();
                $inter = Ingredient::find($val);
                $ls['id'] = (string)$inter->id;
                $inter_ids[] = $inter->id;
                $ls['category'] = (string)$inter->category;
                $ls['item_name'] = (string)$inter->item_name;
                $ls['type'] = (string)$inter->type;
                $ls['price'] = (string)$inter->price;
                $ls['menu_id'] = (string)$inter->menu_id;
                $ingredient[] = $ls;
            }

            $result['Ingredients'] = $ingredient;
            $finalresult[] = $result;
            $adddesc = new OrderResponse();
            $adddesc->set_order_id = $store->id;
            $adddesc->item_id = $result["ItemId"];
            $adddesc->item_qty = $result["ItemQty"];
            $adddesc->ItemTotalPrice = number_format($result["ItemTotalPrice"], 2, '.', '');
            $adddesc->item_amt = $result["ItemAmt"];
            $adddesc->ingredients_id = implode(",", $inter_ids);
            $adddesc->save();
        }
        $data = array("Order" => $finalresult);
        $addresponse = new FoodOrder();
        $addresponse->order_id = $store->id;
        $addresponse->desc = json_encode($data);
        $addresponse->save();

        if ($store) {
            $s_store = session()->put('store', $store);
            return  redirect()->route('payment.confirm')->with('store', $s_store);
        } else {
            return back();
        }
    }

    public function confirm()
    {
        $store = session()->get('store') ?? '';
        if ($store) {
            $category = Category::where("is_deleted", '0')->get();
            $allmenu = Item::all();
            $inter = Ingredient::all();
            $setting = Setting::find(1);
            $city = City::where("is_deleted", '0')->get();
            return view('user.confirmation', compact('allmenu', 'category', 'setting', 'store'));
        } else {
            return redirect()->route('website.home');
        }
    }

    public function confirmSubmit(Request $request)
    {
        $request->validate([
            'confirm_code' => 'required'
        ]);
        try {
            //code...
            $invoice = $request->confirm_code;
            $apikey = '7vAb1YbtaU9XDE8CFF1uxf6Zjm19GalcD63F7ZZqW';
            $request_param = array("apiKey" => $apikey, "invoiceId" => $invoice);

            /* Encode it into a JSON string. */
            $json = json_encode($request_param, JSON_UNESCAPED_SLASHES);

            $hashed = hash('SHA256', $json . "cd5GBclmmx7A4uj8ozZ481qChLk1CQiHIPeaNI");

            $url = "https://edahab.net/api/api/CheckInvoiceStatus?hash=" . $hashed;
            $curl = curl_init($url);
            // Tell cURL to send a POST request.
            curl_setopt($curl, CURLOPT_POST, TRUE);
            // Set the JSON object as the POST content.
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
            // Set the JSON content-type: application/json.
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // Send the request.
            $result = curl_exec($curl);
            $response = json_decode($result);
            if ($request->store_id) {
                $store = Order::find($request->store_id);
                $store->invoice_status = $response->InvoiceStatus;
                $store->save();
                $user = AppUser::find(Session::get('login_user'));

                $details = [
                    'subject' => 'Message from Indhosnacks.com',
                    'greeting' => 'Hi ' . $user->name . ', ',
                    'body' => 'You just order a food from Indhosnacks.com. We are happy to let you know that we have received your order.Your payment is cash on delivery',
                    'email' => 'Your email is : ' . $user->email,
                    'phone' => 'Your phone number is : ' . $user->mob_number,
                    'thanks' => 'Thank you for using Indhosnacks',
                    'site_url' => route('website.home'),
                    'site_name' => 'Indhosnacks.com',
                    'copyright' => 'Copyright © ' . Carbon::now()->format('Y') . ' ' . 'IndhoSnacks. All rights reserved.',
                ];

                //        Mail::to($user->email)->send(new OrderUserMail($details));

                // mail to admin for users order
                $adminuser = User::latest()->first();

                $admindetails = [
                    'subject' => 'Message from Indhosnacks.com',
                    'greeting' => 'Hi ' . $adminuser->name . ', ',
                    'body' => $user->name . ' ' . 'just ordred a food form Indosnacks.com. His/Her payment is cash on delivery. Please see what he/she order from Indhosnacks.com.',
                    'email' => 'His email is : ' . $user->email,
                    'phone' => 'His phone number is : ' . $user->mob_number,
                    'thanks' => 'Thank you for using Indhosnacks',
                    'site_url' => route('website.home'),
                    'site_name' => 'Indhosnacks.com',
                    'copyright' => 'Copyright © ' . Carbon::now()->format('Y') . ' ' . 'IndhoSnacks. All rights reserved.',
                ];

                //        Mail::to($adminuser->email)->send(new OrderAdminGetMail($admindetails));

                Cart::clear();
                session()->forget('store');
                Session::flash('message', __('messages.order_success'));
                Session::flash('alert-class', 'alert-success');
                return redirect("viewdetails/" . $store->id);
            } else {
                session()->forget('store');
                Session::flash('message', __('messages.order_failed'));
                Session::flash('alert-class', 'alert-danger');
                return  redirect('/checkout');
            }
        } catch (\Throwable $th) {
            session()->forget('store');
            Session::flash('message', __('messages.order_failed'));
            Session::flash('alert-class', 'alert-danger');
            return  redirect('/checkout');
        }
    }
}
