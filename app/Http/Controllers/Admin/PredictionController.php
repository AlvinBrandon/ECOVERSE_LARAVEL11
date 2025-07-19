<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MachineLearningService;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    protected $mlService;

    public function __construct(MachineLearningService $mlService)
    {
        $this->mlService = $mlService;
    }

    /**
     * Show the predictions dashboard
     */
    public function index(Request $request)
    {
        // Get the view type (days or months)
        $viewType = $request->get('view_type', 'days');
        $period = $request->get('period', $viewType === 'months' ? 12 : 30);

        // Get predictions for materials
        $predictions = $this->mlService->getMaterialPredictions(10);
        
        // Get feature importance
        $featureImportance = $this->mlService->getFeatureImportance();

        // Get material insights
        $insights = $this->mlService->getMaterialInsights();

        // Format data for charts
        $materials = array_column($predictions, 'material');
        $predictedSales = array_column($predictions, 'predicted_sales');
        $confidenceLower = array_column(array_column($predictions, 'confidence'), 'lower');
        $confidenceUpper = array_column(array_column($predictions, 'confidence'), 'upper');

        // Generate dates and timeline data based on view type (starting from current date)
        if ($viewType === 'months') {
            // Generate future dates for months starting from current month
            $dates = [];
            $timelinePredictedSales = [];
            
            for ($i = 0; $i < $period; $i++) {
                $dates[] = now()->addMonths($i)->format('M Y');
                // Generate higher values for monthly aggregated data with slight growth trend
                $baseValue = 3000;
                $growthFactor = 1 + ($i * 0.05); // 5% growth per month
                $randomVariation = rand(-500, 500);
                $timelinePredictedSales[] = intval($baseValue * $growthFactor + $randomVariation);
            }
        } else {
            // Generate future dates for days starting from current date
            $dates = [];
            $timelinePredictedSales = [];
            
            for ($i = 0; $i < $period; $i++) {
                $dates[] = now()->addDays($i)->format('M d');
                // Generate predictions with seasonal patterns and slight growth
                $baseValue = 120;
                $seasonalFactor = 1 + 0.3 * sin(($i / 7) * 2 * pi()); // Weekly seasonality
                $growthFactor = 1 + ($i * 0.002); // Small daily growth
                $randomVariation = rand(-20, 20);
                $timelinePredictedSales[] = intval($baseValue * $seasonalFactor * $growthFactor + $randomVariation);
            }
        }

        return view('admin.predictions.dashboard', compact(
            'predictions',
            'featureImportance',
            'insights',
            'materials',
            'predictedSales',
            'confidenceLower',
            'confidenceUpper',
            'dates',
            'timelinePredictedSales',
            'viewType',
            'period'
        ));
    }

    /**
     * Train the model with dataset
     */
    public function train(Request $request)
    {
        try {
            $result = $this->mlService->trainModel();
            
            if ($result && isset($result['status']) && $result['status'] === 'success') {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'Model trained successfully',
                    'accuracy' => isset($result['accuracy']) ? round($result['accuracy'] * 100, 2) . '%' : 'N/A',
                    'samples_processed' => $result['samples_processed'] ?? 0,
                    'features_used' => $result['features_used'] ?? [],
                    'statistics' => $result['statistics'] ?? null
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to train model'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error training model: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get predictions for materials
     */
    public function getPredictions(Request $request)
    {
        $request->validate([
            'limit' => 'sometimes|integer|min:1|max:50',
            'view_type' => 'sometimes|string|in:days,months',
            'period' => 'sometimes|integer|min:1|max:24'
        ]);

        try {
            $viewType = $request->input('view_type', 'days');
            $period = $request->input('period', $viewType === 'months' ? 12 : 30);
            
            // Generate timeline data based on view type (starting from current date)
            $predictions = [];
            
            if ($viewType === 'months') {
                for ($i = 0; $i < $period; $i++) {
                    $currentMonth = now()->addMonths($i);
                    $baseValue = 3000;
                    $growthFactor = 1 + ($i * 0.05); // 5% growth per month
                    $randomVariation = rand(-500, 500);
                    $predictedSales = intval($baseValue * $growthFactor + $randomVariation);
                    
                    $predictions[] = [
                        'date' => $currentMonth->format('M Y'),
                        'predicted_sales' => $predictedSales,
                        'confidence_lower' => intval($predictedSales * 0.8),
                        'confidence_upper' => intval($predictedSales * 1.2)
                    ];
                }
            } else {
                for ($i = 0; $i < $period; $i++) {
                    $currentDay = now()->addDays($i);
                    $baseValue = 120;
                    $seasonalFactor = 1 + 0.3 * sin(($i / 7) * 2 * pi()); // Weekly seasonality
                    $growthFactor = 1 + ($i * 0.002); // Small daily growth
                    $randomVariation = rand(-20, 20);
                    $predictedSales = intval($baseValue * $seasonalFactor * $growthFactor + $randomVariation);
                    
                    $predictions[] = [
                        'date' => $currentDay->format('M d'),
                        'predicted_sales' => $predictedSales,
                        'confidence_lower' => intval($predictedSales * 0.85),
                        'confidence_upper' => intval($predictedSales * 1.15)
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'predictions' => $predictions,
                'view_type' => $viewType,
                'period' => $period
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting predictions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get model insights and material analysis
     */
    public function getInsights()
    {
        try {
            $insights = $this->mlService->getMaterialInsights();
            $featureImportance = $this->mlService->getFeatureImportance();
            
            return response()->json([
                'success' => true,
                'insights' => $insights,
                'feature_importance' => $featureImportance
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting insights: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get custom predictions with filters
     */
    public function getCustomPredictions(Request $request)
    {
        $request->validate([
            'material_name' => 'sometimes|string',
            'category' => 'sometimes|string',
            'eco_friendly' => 'sometimes|string|in:Yes,No',
            'max_cost' => 'sometimes|numeric|min:0',
            'min_rating' => 'sometimes|numeric|min:1|max:5',
            'limit' => 'sometimes|integer|min:1|max:50'
        ]);

        try {
            $filters = $request->only(['material_name', 'category', 'eco_friendly', 'max_cost', 'min_rating', 'limit']);
            
            // Remove empty filters
            $filters = array_filter($filters, function($value) {
                return $value !== null && $value !== '';
            });

            $result = $this->mlService->getCustomPredictions($filters);
            
            if ($result && isset($result['status']) && $result['status'] === 'success') {
                return response()->json([
                    'success' => true,
                    'predictions' => $result['predictions'],
                    'total_found' => $result['total_found'],
                    'showing' => $result['showing'],
                    'filters_applied' => $result['filters_applied']
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'No predictions found'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting custom predictions: ' . $e->getMessage()
            ], 500);
        }
    }
} 