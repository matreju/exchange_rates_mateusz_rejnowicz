<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurrencyRate;

class CurrencyRateController extends Controller
{
    /**
     * Wyszukiwanie po walucie, dacie oraz walucie i dacie
     */
    public function index(Request $request)
    {
        $currency = $request->input('currency');
        $date = $request->input('date');
    
        $query = CurrencyRate::query();
    
        if ($currency) {
            $query->where('currency', $currency);
        }
    
        if ($date) {
            $query->where('date', $date);
        }
    
        $currencyRates = $query->get();
    
        $response = [];
        foreach ($currencyRates as $currencyRate) {
            $response[] = [
                'currency' => $currencyRate->currency,
                'date' => $currencyRate->date,
                'amount' => $currencyRate->amount,
            ];
        }
    
        return response()->json($response);
    }

    /**
     * Zapisanie danych do bazy wraz ze sprawdzeniem czy w bazie nie znajduje się już kurs z danego dnia
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => 'required|in:EUR,USD,GBP',
            'date' => 'required|date_format:Y-m-d',
            'amount' => 'required|numeric',
        ]);
    
        $existingCurrencyRate = CurrencyRate::where('currency', $validatedData['currency'])
            ->where('date', $validatedData['date'])
            ->first();
    
        if ($existingCurrencyRate) {
            return response()->json(['message' => 'Kurs dla tej waluty i daty już istnieje!'], 409);
        }
    
        $currencyRate = new CurrencyRate();
        $currencyRate->currency = $validatedData['currency'];
        $currencyRate->date = $validatedData['date'];
        $currencyRate->amount = $validatedData['amount'];
        $currencyRate->save();
    
        return response()->json(['message' => 'Kurs dodany poprawnie!']);
    }

    /**
     * Pobranie kursu dla wybranej waluty z danego dnia i wyświetlenie go
     */
    public function show($currency, $date)
    {
        $currencyRate = CurrencyRate::where('currency', $currency)
            ->where('date', $date)
            ->firstOrFail();
    
        $response = [
            'currency' => $currencyRate->currency,
            'date' => $currencyRate->date,
            'amount' => $currencyRate->amount,
        ];
    
        return response()->json($response);
    }


}
