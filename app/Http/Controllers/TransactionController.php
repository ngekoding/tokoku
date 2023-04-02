<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transaction.
     */
    public function index(Request $request): Response
    {
        $transactions = Order::with('customer')
                    ->when($request->input('search'), function (Builder $query, $q) {
                        $query->where('code', 'like', '%' . $q . '%')
                            ->orWhereHas('customer', function (Builder $query) use ($q) {
                                $query->where('name', 'like', '%' . $q . '%');
                            });
                    })
                    ->paginate(10)
                    ->appends($request->all());

        return Inertia::render('Transactions/TransactionList', [
            'transactions' => $transactions,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Transactions/TransactionCreate', [
            'items' => Item::all(),
            'customers' => Customer::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'customer' => 'required|exists:App\Models\Customer,id',
            'date' => 'required|date',
            'address' => 'required',
            'items' => 'required'
        ]);

        $simpleItems = [];
        foreach ($request->items as $item) {
            $simpleItems[$item['id']] = (object) $item;
        }

        $order = Order::create([
            'code' => Str::upper(Str::random(10)),
            'date' => $request->date,
            'address' => $request->address,
            'customer_id' => $request->customer,
        ]);

        $subtotal = 0;
        $discount = 0;
        $orderItems = [];

        $items = Item::findMany(array_column($request->items, 'id'));

        foreach ($items as $item) {
            $itemExtra = $simpleItems[$item->id];

            $subtotal += $itemExtra->qty * $item->price;
            $discount += $itemExtra->discount;

            $orderItems[] = new OrderItem([
                'item_id' => $item->id,
                'qty' => $itemExtra->qty,
                'discount' => $itemExtra->discount,
                'note' => $itemExtra->note,
                'price' => $item->price,
                'total' => $itemExtra->qty * $item->price - $itemExtra->discount
            ]);
        }

        // Completing order data
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->total = $subtotal - $discount;
        $order->orderItems()->saveMany($orderItems);
        $order->save();

        return Redirect::route('transactions.create');
    }

    /**
     * Remove the specific order.
     *
     * @param Order $order
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return Redirect::route('transactions')->with('success', 'Transaction successfully deleted.');
    }
}
