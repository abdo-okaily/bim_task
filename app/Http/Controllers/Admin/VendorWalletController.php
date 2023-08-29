<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Admin\VendorWalletService;
use App\Http\Requests\Admin\IncreaseAndDecreaseVendorWalletBalanceRequest;

class VendorWalletController extends Controller
{
    /**
     * Wallets Controller Constructor.
     *
     * @param VendorWalletService $service
     */
    public function __construct(public VendorWalletService $service) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request) : View
    {
        $vendorWallets = $this->service->getAllVendorWalletsWithPagination(
            request: $request,
            perPage: 10,
            orderBy: "desc"
        );

        return view("admin.vendorWallets.index", compact('vendorWallets'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id, Request $request) : View
    {
        $vendorWallet = $this->service->getVendorWalletUsingID($id);

        $transactions = $this->service->getVendorWalletTransactionsWithPagination($id, 5, "DESC", $request);

        $breadcrumbParent = 'admin.vendorWallets.index';
        $breadcrumbParentUrl = route('admin.vendorWallets.index');

        return view("admin.vendorWallets.show", compact('vendorWallet', 'transactions', "breadcrumbParent", "breadcrumbParentUrl"));
    }

    /**
     * Increase And Decrease Amount in wallet transaction history.
     *
     * @param  int  $id
     * @param Request $request
     * @return Redirect
     */
    public function update(int $id, IncreaseAndDecreaseVendorWalletBalanceRequest $request)
    {
        $result = $this->service->increaseAndDecreaseAmount($id, $request);

        if($result["success"] == true) {
            Alert::success($result["title"], $result["body"]);
        } else {
            Alert::error($result["title"], $result["body"]);
        }

        return redirect()->back();
    }
}
