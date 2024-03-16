<?php

namespace App\Http\Livewire;

use App\Models\Invoice;
use Livewire\Component;
use App\Models\Contract;
use App\Models\Customer;

class Dashboardwr extends Component
{
    public function render()
    {
        $now = now()->month;
        $year = now()->year;
        $next_month = now()->addMonth()->month;
        $next_year = now()->addMonth()->year;
        $last_month = now()->subMonth()->month;
        $last_year = now()->subMonth()->year;
        // dd($next_year);
        $expiring = Contract::whereMonth('contract_end', $next_month)->whereYear('contract_end', $next_year)->get();
        $active = Customer::where('is_active', true)->count();
        $data_invoice_mtd = Invoice::whereYear('invoice_date', $last_year)->whereMonth('invoice_date', $last_month)->get();

        $mtd = 0;
        if ($data_invoice_mtd) {
            foreach ($data_invoice_mtd as $d) {
                $mtd = $mtd + getTotal($d->number);
            }
        }
        $data_invoice_ytd = Invoice::whereYear('invoice_date', $year)->get();
        $ytd = 0;
        if ($data_invoice_ytd) {
            foreach ($data_invoice_ytd as $d) {
                $ytd = $ytd + getTotal($d->number);
            }
        }

        return view('livewire.dashboardwr', [
            'expiring' => $expiring,
            'active' => $active,
            'mtd' => $mtd,
            'ytd' => $ytd
        ]);
    }
}
