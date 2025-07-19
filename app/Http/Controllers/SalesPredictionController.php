<?php

namespace App\Http\Controllers;

use App\Services\SalesPredictionService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SalesPredictionController extends Controller
{
    protected $predictionService;

    public function __construct(SalesPredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    /**
     * Get sales prediction for a product
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function getPrediction(Request $request, Product $product): JsonResponse
    {
        $season = $request->input('season');
        $result = $this->predictionService->getPrediction($product, $season);

        return response()->json($result);
    }

    /**
     * Get sales predictions for all products
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllPredictions(Request $request): JsonResponse
    {
        $products = Product::all();
        $predictions = [];
        $season = $request->input('season');

        foreach ($products as $product) {
            $result = $this->predictionService->getPrediction($product, $season);
            $predictions[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'prediction' => $result['prediction'],
                'success' => $result['success'],
                'message' => $result['message']
            ];
        }

        return response()->json([
            'success' => true,
            'predictions' => $predictions
        ]);
    }
} 