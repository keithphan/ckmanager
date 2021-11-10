<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\DeliverAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('trash')){
            $orders = Order::where('user_id', Auth::user()->id)->onlyTrashed()->orderBy('created_at', 'DESC')->get();
            return view('pages.orders.trash', compact('orders'));
        }

        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        // Return create order page.
        if($request->company){
            $company = Company::where([['user_id', Auth::user()->id], ['slug', $request->company]])->get('id')->first();

            if(!$company){
                abort(404);
            }

            $products = Product::where([['user_id', Auth::user()->id], ['company_id', $company->id]])->get();
            $customers = Customer::where([['user_id', Auth::user()->id], ['company_id', $company->id]])->get();

            if(!$products->first()){
                Session::flash('message', "You do not have any products! <a href='" . route('products.create') . "'>Create one</a>");
                Session::flash('class', 'bg-warning');
                return redirect()->back();
            }

            return view('pages.orders.create', compact('products', 'customers', 'company'));
        }

        // Return all company for user to choose.
        $companies = Company::where('user_id', Auth::user()->id)->get();

        if(!$companies->first()){
            Session::flash('message', "You do not have any companies! <a href='" . route('companies.create') . "'>Create one</a>");
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }
        return view('pages.orders.companies', compact('companies'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = null;

        if($request->customer){
            $customer = Customer::where([['user_id', Auth::user()->id], ['company_id', $request->company_id]])->find($request->customer);
        }else{
            $request->validate(
                [
                    'customerName' => 'required',
                    'customerPhoneNumber' => 'required',
                    'customerDeliverAddress' => 'required',
                    'selectedItems' => 'required',
                ],
                [
    
                ],
                [
                    'selectedItems' => "order details"
                ],
            );

            $customer = Customer::create([
                'name' => $request->customerName,
                'phone_number' => $request->customerPhoneNumber,
                'email' => $request->customerEmailAddress,
                'addresses' => json_encode([
                    'addresses' => [$request->customerDeliverAddress],
                    'default' => 0,
                ]),
                'company_id' => $request->company_id,
                'user_id' => Auth::user()->id,
            ]);
        }

        $request->validate(
            [
                'selectedItems' => 'required',
            ],
            [],
            [
                'selectedItems' => "order details"
            ],
        );

        $productList = $request->selectedItems;
        $itemsQty = $request->itemsQty;

        if($productList){
            $total = 0;

            foreach($productList as $productKey => $product){
                foreach($itemsQty as $qtyKey =>  $qty){
                    if($productKey == $qtyKey){
                        $productFormDb = Product::find($product);
                        $total += $productFormDb->price * $qty;
                        // $productFormDb->update([
                        //     'quantity' => $productFormDb->quantity - $qty,
                        // ]);
                    }
                }
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'customer_name' => $request->customerName,
                'customer_phoneNumber' => $request->customerPhoneNumber,
                'customer_email' => $request->customerEmailAddress,
                'customer_address' => $request->customerDeliverAddress,
                'shipping_fee' => $request->shipping_fee,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'status' => 'waitting',
            ]);

            foreach($productList as $productKey => $product){
                foreach($itemsQty as $qtyKey =>  $qty){
                    if($productKey == $qtyKey){
                       OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product,
                        'quantity' => $qty,
                       ]);
                    }
                }
            }

            Session::flash('message', 'Create order successfully.');
            Session::flash('class', 'bg-success');
            return redirect()->back();
        }

        Session::flash('message', 'No selected products.');
        Session::flash('class', 'bg-danger');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::user()->id)->withTrashed()->find($id);

        if(!$order){
            $this->isNotExisted();
            return redirect()->back();
        }

        if($order->status == 'waitting'){
            return redirect()->route('orders.edit', $order->id);
        }
        
        return view('pages.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::where('user_id', Auth::user()->id)->find($id);

        if(!$order){
            $this->isNotExisted();
            return redirect()->back();
        }

        if($order->status != 'waitting'){
            Session::flash('message', 'You cannot edit this order!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }

        $customers = Customer::where([
            ['user_id', Auth::user()->id],
            ['company_id', $order->customer->company_id]
        ])->get();

        $products = Product::where([['user_id', Auth::user()->id], ['company_id', $order->customer->company_id]])->get();
        $orderDetails = $order->orderDetails;
        return view('pages.orders.edit', compact('order', 'customers', 'products', 'orderDetails'));
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
        // dd($request);

        $customer = null;

        if($request->customer){
            $customer = Customer::where([['user_id', Auth::user()->id], ['company_id', $request->company_id]])->find($request->customer);
        }else{
            $request->validate(
                [
                    'customerName' => 'required',
                    'customerPhoneNumber' => 'required',
                    'customerDeliverAddress' => 'required',
                    'selectedItems' => 'required',
                ],
                [
    
                ],
                [
                    'selectedItems' => "order details"
                ],
            );

            $customer = Customer::create([
                'name' => $request->customerName,
                'phone_number' => $request->customerPhoneNumber,
                'email' => $request->customerEmailAddress,
                'addresses' => json_encode([
                    'addresses' => [$request->customerDeliverAddress],
                    'default' => 0,
                ]),
                'company_id' => $request->company_id,
                'user_id' => Auth::user()->id,
            ]);
        }

        $request->validate(
            [
                'selectedItems' => 'required',
            ],
            [],
            [
                'selectedItems' => "order details"
            ],
        );

        $productList = $request->selectedItems;
        $itemsQty = $request->itemsQty;

        if($productList){
            $total = 0;

            foreach($productList as $productKey => $product){
                foreach($itemsQty as $qtyKey =>  $qty){
                    if($productKey == $qtyKey){
                        $productFormDb = Product::find($product);
                        $total += $productFormDb->price * $qty;
                        // $productFormDb->update([
                        //     'quantity' => $productFormDb->quantity - $qty,
                        // ]);
                    }
                }
            }

            $order = Order::where([
                ['user_id', Auth::user()->id],
            ])->find($id);

            $order->update([
                'customer_id' => $customer->id,
                'customer_name' => $request->customerName,
                'customer_phoneNumber' => $request->customerPhoneNumber,
                'customer_email' => $request->customerEmailAddress,
                'customer_address' => $request->customerDeliverAddress,
                'shipping_fee' => $request->shipping_fee,
                'payment_method' => $request->payment_method,
                'total' => $total,
                'description' => $request->description,
            ]);

            $orderDetails = $order->orderDetails;
            if(count($orderDetails) <= count($productList)){
                foreach($productList as $productKey => $product){
                    if(in_array($product, $orderDetails->pluck('product_id')->toArray())){
                        foreach($itemsQty as $qtyKey =>  $qty){
                            if($productKey == $qtyKey){
                                $orderDetails->where('product_id', $product)->first()->update([
                                    'quantity' => $qty,
                                ]);
                            }
                        }
                    }else{
                        foreach($itemsQty as $qtyKey =>  $qty){
                            if($productKey == $qtyKey){
                                OrderDetail::create([
                                    'order_id' => $order->id,
                                    'product_id' => $product,
                                    'quantity' => $qty,
                                ]);
                            }
                        }
                    }
                }
            }else{
                foreach($orderDetails as $orderDetail){
                    if(in_array($orderDetail->product_id, $productList)){
                        foreach($productList as $productKey => $product){
                            if($product == $orderDetail->product_id){
                                foreach($itemsQty as $qtyKey =>  $qty){
                                    if($productKey == $qtyKey){
                                        $orderDetail->update([
                                        'quantity' => $qty,
                                        ]);
                                    }
                                }
                            }
                        }
                    }else{
                        $orderDetail->delete();
                    }
                }
            }

            Session::flash('message', 'Update order successfully.');
            Session::flash('class', 'bg-success');
            return redirect()->back();
        }

        Session::flash('message', 'No selected products.');
        Session::flash('class', 'bg-danger');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $order = Order::where('user_id', Auth::user()->id)->withTrashed()->find($request->id);

        if($order){
            if($order->deleted_at){
                $order->forceDelete();
            }else{
                $order->delete();
            }
            Session::flash('message', 'Deleted order successfully.');
            Session::flash('class', 'bg-success');
        }else{
            $this->isNotExisted();
        }

        return redirect()->route('orders.index');
    }

    public function destroySelected(Request $request)
    {
        if(!isset($request->itemIds)){
            Session::flash('message', 'No orders selected. Please select!');
            Session::flash('class', 'bg-warning');
            return redirect()->back();
        }

        $orderIds = explode(',', $request->itemIds);

        foreach($orderIds as $id){
            $order = Order::where('user_id', Auth::user()->id)->withTrashed()->find($id);
            if($order){
                if($order->deleted_at){
                    $order->forceDelete();
                }else{
                    $order->delete();
                }
            }
        }

        Session::flash('message', 'Deleted orders successfully.');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function getTotalPriceByIds(Request $request){
        $total = 0;
        if($request->data){
            foreach($request->data as $item){
                $total += Product::find($item[0])->price * $item[1];
            }
        }
        return json_encode(["total" => $total]);
    }

    public function isNotExisted(){
        Session::flash('message', 'Order does not exist!');
        Session::flash('class', 'bg-warning');
    }

    public function deliverOrder(Request $request){
        $order = Order::where('user_id', Auth::user()->id)->find($request->orderId);

        if(!$order){
            $this->isNotExisted();
            return redirect()->back();
        }

        $order->update([
            'status' => 'delivering',
        ]);

        foreach($order->orderDetails as $orderDetail){
            $orderDetail->product->update([
                'quantity' => $orderDetail->product->quantity - $orderDetail->quantity,
            ]);
        }

        Session::flash('message', 'Order is being delivered');
        Session::flash('class', 'bg-info');
        return redirect()->route('orders.show', $order->id);
    }


    public function finishOrder(Request $request){
        $order = Order::where([
            ['status', 'delivering'],
            ['user_id', Auth::user()->id]
        ])->find($request->orderId);

        if(!$order){
            $this->isNotExisted();
            return redirect()->back();
        }

        $order->update([
            'status' => 'successful',
        ]);

        Session::flash('message', 'Finish order successfully!');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }

    public function restoreOder(Request $request){
        $order = Order::where('user_id', Auth::user()->id)->onlyTrashed()->find($request->orderId);

        if(!$order){
            $this->isNotExisted();
            return redirect()->back();
        }

        $order->restore();

        Session::flash('message', 'Restore order successfully!');
        Session::flash('class', 'bg-success');
        return redirect()->back();
    }
}
