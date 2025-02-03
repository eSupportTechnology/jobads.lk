<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankAccountController extends Controller
{
    public function index()
    {
        $banks = BankAccount::all();
        return view('User.postvacancy.paymentmethod.onlinefundtransfer', compact('banks'));
    }

    public function indexadmin()
    {
        $bankAccounts = BankAccount::all();
        return view('Admin.Bank.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('Admin.Bank.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'bank_code' => 'required',
            'branch_code' => 'required',
            'branch_name' => 'required',
            'swift_code' => 'nullable',
            'currency' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'localorforeign' => 'required',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('bank-logos');
            $validated['logo'] = str_replace('public/', '', $path);
        }

        BankAccount::create($validated);
        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account created successfully');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('Admin.Bank.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_no' => 'required',
            'bank_code' => 'required',
            'branch_code' => 'required',
            'branch_name' => 'required',
            'swift_code' => 'nullable',
            'currency' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'localorforeign' => 'required',
        ]);

        // Handle logo update
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($bankAccount->logo) {
                Storage::delete('public/' . $bankAccount->logo);
            }

            $path = $request->file('logo')->store('bank-logos');
            $validated['logo'] = str_replace('public/', '', $path);
        } else {
            // Keep existing logo if not updated
            unset($validated['logo']);
        }

        $bankAccount->update($validated);
        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account updated successfully');
    }

    public function destroy(BankAccount $bankAccount)
    {
        // Delete logo file if exists
        if ($bankAccount->logo) {
            Storage::delete('public/' . $bankAccount->logo);
        }

        $bankAccount->delete();
        return redirect()->route('admin.bank-accounts.index')->with('success', 'Bank account deleted successfully');
    }
}