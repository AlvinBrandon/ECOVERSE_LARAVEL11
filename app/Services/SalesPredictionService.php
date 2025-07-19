<?php

namespace App\Services;

use App\ML\Models\SalesPredictionModel;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesPredictionService
{
    protected $model;

    public function __construct()
    {
        $this->model = new SalesPredictionModel();
    }

    /**
     * Get sales prediction for a product
     *
     * @param Product $product
     * @param string|null $season
     * @return array
     */
    public function getPrediction(Product $product, ?string $season = null)
    {
        try {
            // Get historical data
            $historicalData = $this->getHistoricalData($product->id);
            
            if (empty($historicalData)) {
                return [
                    'success' => false,
                    'message' => 'Insufficient historical data for prediction',
                    'prediction' => null
                ];
            }

            // Prepare input data
            $input = $this->prepareInputData($product, $historicalData, $season);
            
            // Load or train model if needed
            if (!$this->model->isTrained() && !$this->model->loadModel('ml_models/sales_prediction_model.json')) {
                $trainingData = $this->prepareTrainingData();
                $this->model->initialize($trainingData);
                $this->model->train();
            }

            // Make prediction
            $prediction = $this->model->predict($input);

            if ($prediction === null) {
                return [
                    'success' => false,
                    'message' => 'Failed to generate prediction',
                    'prediction' => null
                ];
            }

            return [
                'success' => true,
                'message' => 'Prediction generated successfully',
                'prediction' => round($prediction),
                'confidence_metrics' => $this->model->getMetrics()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error generating prediction: ' . $e->getMessage(),
                'prediction' => null
            ];
        }
    }

    /**
     * Get historical sales data for a product
     *
     * @param int $productId
     * @return array
     */
    protected function getHistoricalData($productId)
    {
        return DB::table('sales_history')
            ->where('product_id', $productId)
            ->orderBy('sale_date', 'desc')
            ->limit(90) // Last 90 days
            ->get()
            ->toArray();
    }

    /**
     * Prepare input data for prediction
     *
     * @param Product $product
     * @param array $historicalData
     * @param string|null $season
     * @return array
     */
    protected function prepareInputData(Product $product, array $historicalData, ?string $season)
    {
        // Calculate average historical sales
        $historicalSales = collect($historicalData)->avg('quantity_sold') ?? 0;

        // Determine current season if not provided
        if (!$season) {
            $season = $this->getCurrentSeason();
        }

        return [
            'product_id' => $product->id,
            'historical_sales' => $historicalSales,
            'price' => $product->price,
            'season' => $season,
            'stock_level' => $product->stock,
            'promotion_active' => false // You can modify this based on your promotion logic
        ];
    }

    /**
     * Prepare training data from all historical sales
     *
     * @return array
     */
    protected function prepareTrainingData()
    {
        $trainingData = [];
        
        $salesHistory = DB::table('sales_history')
            ->join('products', 'sales_history.product_id', '=', 'products.id')
            ->select(
                'sales_history.*',
                'products.price',
                'products.stock'
            )
            ->orderBy('sale_date', 'desc')
            ->get();

        foreach ($salesHistory as $record) {
            $trainingData[] = [
                'product_id' => $record->product_id,
                'historical_sales' => $record->quantity_sold,
                'price' => $record->price,
                'season' => $record->season,
                'stock_level' => $record->stock_level,
                'promotion_active' => $record->promotion_active
            ];
        }

        return $trainingData;
    }

    /**
     * Get current season based on date
     *
     * @return string
     */
    protected function getCurrentSeason()
    {
        $month = Carbon::now()->month;

        return match (true) {
            in_array($month, [3, 4, 5]) => 'spring',
            in_array($month, [6, 7, 8]) => 'summer',
            in_array($month, [9, 10, 11]) => 'fall',
            default => 'winter'
        };
    }
} 