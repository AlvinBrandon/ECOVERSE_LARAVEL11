<?php

namespace App\Services\MachineLearning;

use Illuminate\Support\Facades\Storage;

class SalesPredictionService
{
    private $forecastData;

    public function __construct()
    {
        $this->loadForecastData();
    }

    private function loadForecastData()
    {
        try {
            $jsonPath = 'ml/sales_forecast.json';
            if (Storage::exists($jsonPath)) {
                $this->forecastData = json_decode(Storage::get($jsonPath), true);
            } else {
                $this->forecastData = [
                    'next_month_sales' => 18500.00,
                    'confidence' => 85.5
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Error loading forecast data: ' . $e->getMessage());
            $this->forecastData = [
                'next_month_sales' => 18500.00,
                'confidence' => 85.5
            ];
        }
    }

    public function predictNextMonthSales(): float
    {
        return $this->forecastData['next_month_sales'] ?? 18500.00;
    }

    public function getConfidenceScore(): float
    {
        return $this->forecastData['confidence'] ?? 85.5;
    }

    public function getChartData(): array
    {
        $historical = $this->forecastData['historical_data'] ?? null;
        $forecast = $this->forecastData['forecast_data'] ?? null;

        if (!$historical || !$forecast) {
            return [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'actual' => [10000, 12000, 15000, 13000, 16000, 14000],
                'predicted' => [11000, 13000, 14500, 13500, 15500, 14500]
            ];
        }

        return [
            'labels' => array_merge($historical['dates'], $forecast['dates']),
            'actual' => array_merge($historical['values'], array_fill(0, count($forecast['dates']), null)),
            'predicted' => array_merge(
                array_fill(0, count($historical['dates']), null),
                $forecast['predictions']
            ),
            'bounds' => [
                'lower' => array_merge(
                    array_fill(0, count($historical['dates']), null),
                    $forecast['lower_bounds']
                ),
                'upper' => array_merge(
                    array_fill(0, count($historical['dates']), null),
                    $forecast['upper_bounds']
                )
            ]
        ];
    }
}
