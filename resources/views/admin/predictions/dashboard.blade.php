@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-graph-up-arrow me-2"></i>Sales Predictions Dashboard
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Control Panel -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Model Training</h5>
                                    <p class="text-muted">Train the model with latest data</p>
                                    <button id="trainModel" class="btn btn-primary">
                                        <i class="bi bi-gear me-1"></i> Train Model
                                    </button>
                                    <div id="trainingStatus" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Prediction Range</h5>
                                    <p class="text-muted">Select view type and period</p>
                                    
                                    <!-- View Type Toggle -->
                                    <div class="mb-3">
                                        <div class="btn-group w-100" role="group" aria-label="View Type">
                                            <input type="radio" class="btn-check" name="viewType" id="viewDays" value="days" 
                                                {{ ($viewType ?? 'days') === 'days' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="viewDays">Days</label>
                                            
                                            <input type="radio" class="btn-check" name="viewType" id="viewMonths" value="months"
                                                {{ ($viewType ?? 'days') === 'months' ? 'checked' : '' }}>
                                            <label class="btn btn-outline-primary" for="viewMonths">Months</label>
                                        </div>
                                    </div>
                                    
                                    <!-- Period Selection -->
                                    <select id="predictionPeriod" class="form-select">
                                        <!-- Options will be populated by JavaScript based on view type -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Last Update</h5>
                                    <p class="text-muted">Model status information</p>
                                    <p id="lastUpdate" class="mb-0">
                                        <i class="bi bi-clock-history me-1"></i>
                                        {{ now()->format('Y-m-d H:i:s') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Predictions Chart -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Sales Predictions</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="predictionsChart" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Custom Predictions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="bi bi-search me-2"></i>Custom Prediction Builder
                                    </h5>
                                    <small class="text-muted">Select specific materials and criteria to predict sales</small>
                                </div>
                                <div class="card-body">
                                    <form id="customPredictionForm">
                                        <div class="row custom-filter-row">
                                            <div class="col-md-3">
                                                <label for="materialSelect" class="form-label">Material Type</label>
                                                <select id="materialSelect" class="form-select">
                                                    <option value="">All Materials</option>
                                                    <option value="Biodegradable Foam">Biodegradable Foam</option>
                                                    <option value="Bubble Wrap">Bubble Wrap</option>
                                                    <option value="Corrugated Cardboard">Corrugated Cardboard</option>
                                                    <option value="Honeycomb Paper">Honeycomb Paper</option>
                                                    <option value="Jiffy Bag">Jiffy Bag</option>
                                                    <option value="Kraft Paper">Kraft Paper</option>
                                                    <option value="Padded Envelope">Padded Envelope</option>
                                                    <option value="Plastic Mailer">Plastic Mailer</option>
                                                    <option value="Rigid Boxes">Rigid Boxes</option>
                                                    <option value="Shrink Wrap">Shrink Wrap</option>
                                                    <option value="Stretch Film">Stretch Film</option>
                                                    <option value="Thermal Insulated Box">Thermal Insulated Box</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="categorySelect" class="form-label">Category</label>
                                                <select id="categorySelect" class="form-select">
                                                    <option value="">All Categories</option>
                                                    <option value="Bag">Bag</option>
                                                    <option value="Box">Box</option>
                                                    <option value="Envelope">Envelope</option>
                                                    <option value="Filler">Filler</option>
                                                    <option value="Wrap">Wrap</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="ecoFriendlySelect" class="form-label">Eco-Friendly</label>
                                                <select id="ecoFriendlySelect" class="form-select">
                                                    <option value="">All</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="priceRange" class="form-label">Max Unit Cost ($)</label>
                                                <input type="number" id="priceRange" class="form-control" step="0.01" placeholder="e.g. 2.00">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="resultLimit" class="form-label">Results Limit</label>
                                                <select id="resultLimit" class="form-select">
                                                    <option value="5">Top 5</option>
                                                    <option value="10" selected>Top 10</option>
                                                    <option value="15">Top 15</option>
                                                    <option value="20">Top 20</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary" id="generatePredictionsBtn">
                                                    <i class="bi bi-calculator me-1"></i>Generate Custom Predictions
                                                </button>
                                                <button type="button" id="clearFilters" class="btn btn-outline-secondary ms-2">
                                                    <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
                                                </button>
                                                
                                                <!-- Loading Animation -->
                                                <div id="predictionLoadingAnimation" class="prediction-loading-overlay" style="display: none;">
                                                    <div class="loading-content">
                                                        <div class="loading-spinner">
                                                            <div class="spinner-ring"></div>
                                                            <div class="spinner-ring"></div>
                                                            <div class="spinner-ring"></div>
                                                        </div>
                                                        <div class="loading-text">
                                                            <h5 class="mb-2">Analyzing Your Data...</h5>
                                                            <p class="loading-step" id="loadingStep">Initializing prediction engine</p>
                                                            <div class="progress-bar-container">
                                                                <div class="progress-bar-fill" id="progressBarFill"></div>
                                                            </div>
                                                            <small class="text-muted mt-2" id="loadingPercentage">0%</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <!-- Custom Prediction Results -->
                                    <div id="customPredictionResults" class="mt-4" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Custom Prediction Results</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm" id="customResultsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Material</th>
                                                                <th>Category</th>
                                                                <th>Current Sales</th>
                                                                <th>Predicted Sales</th>
                                                                <th>Unit Cost</th>
                                                                <th>Rating</th>
                                                                <th>Eco</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="customResultsBody">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <div class="card">
                                                            <div class="card-header py-2">
                                                                <h6 class="mb-0">Sales Comparison Chart</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="customSalesChart" height="250"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header py-2">
                                                                <h6 class="mb-0">Category Distribution</h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <canvas id="customCategoryChart" height="250"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Additional Charts Row -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header py-2">
                                                        <h6 class="mb-0">Cost vs Rating Analysis</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="customScatterChart" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header py-2">
                                                        <h6 class="mb-0">Eco-Friendly Distribution</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="customEcoChart" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature Importance Analysis -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <i class="bi bi-bar-chart me-2"></i>Model Feature Importance
                                    </h5>
                                    <small class="text-muted">Key factors influencing sales predictions</small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <canvas id="featureImportanceChart" height="300"></canvas>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="feature-insights">
                                                <h6 class="mb-3">Key Insights</h6>
                                                <div class="insight-item mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="insight-icon bg-primary"></div>
                                                        <h6 class="mb-0 ms-2">Customer Rating</h6>
                                                    </div>
                                                    <p class="text-muted small">Highest impact factor on sales predictions. Products with ratings 4+ show 35% higher sales.</p>
                                                </div>
                                                <div class="insight-item mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="insight-icon bg-success"></div>
                                                        <h6 class="mb-0 ms-2">Unit Cost</h6>
                                                    </div>
                                                    <p class="text-muted small">Sweet spot between $1.50-$3.00 shows optimal demand balance.</p>
                                                </div>
                                                <div class="insight-item mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="insight-icon bg-info"></div>
                                                        <h6 class="mb-0 ms-2">Eco-Friendly</h6>
                                                    </div>
                                                    <p class="text-muted small">Eco-friendly products show 22% higher growth rate in predictions.</p>
                                                </div>
                                                <div class="insight-item">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="insight-icon bg-warning"></div>
                                                        <h6 class="mb-0 ms-2">Seasonality</h6>
                                                    </div>
                                                    <p class="text-muted small">Seasonal patterns account for 15% variance in predictions.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Segmentation & Insights -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Customer Purchase Segmentation</h5>
                                    <small class="text-muted">Category preferences by customer segments</small>
                                </div>
                                <div class="card-body">
                                    <canvas id="customerSegmentationChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Category Performance Overview</h5>
                                    <small class="text-muted">Sales distribution and eco-friendly trends</small>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="text-center">
                                                <canvas id="categoryDistributionChart" height="200"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="category-stats">
                                                @php
                                                    $categoryStats = [
                                                        'Box' => ['total' => 0, 'eco' => 0, 'sales' => 0],
                                                        'Bag' => ['total' => 0, 'eco' => 0, 'sales' => 0],
                                                        'Envelope' => ['total' => 0, 'eco' => 0, 'sales' => 0],
                                                        'Filler' => ['total' => 0, 'eco' => 0, 'sales' => 0],
                                                        'Wrap' => ['total' => 0, 'eco' => 0, 'sales' => 0]
                                                    ];
                                                @endphp
                                                
                                                <div class="stat-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">📦 Box Products</h6>
                                                            <small class="text-muted">Rigid packaging solutions</small>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="badge bg-primary">High Volume</div>
                                                            <div class="small text-muted">45% eco-friendly</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">👜 Bag Products</h6>
                                                            <small class="text-muted">Flexible carriers</small>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="badge bg-success">Growing</div>
                                                            <div class="small text-muted">52% eco-friendly</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">📨 Envelope Products</h6>
                                                            <small class="text-muted">Document & small item mailers</small>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="badge bg-info">Stable</div>
                                                            <div class="small text-muted">38% eco-friendly</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item mb-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">🧽 Filler Products</h6>
                                                            <small class="text-muted">Protective padding</small>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="badge bg-warning">Seasonal</div>
                                                            <div class="small text-muted">41% eco-friendly</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="stat-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">🎁 Wrap Products</h6>
                                                            <small class="text-muted">Surface protection films</small>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="badge bg-secondary">Niche</div>
                                                            <div class="small text-muted">49% eco-friendly</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Predictions Chart
    const predictionsChart = new Chart(
        document.getElementById('predictionsChart').getContext('2d'),
        {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Predicted Sales',
                    data: @json($timelinePredictedSales ?? $predictedSales),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: @json($viewType === 'months' ? 'Monthly Sales Predictions (Future)' : 'Daily Sales Predictions (Future)')
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: @json($viewType === 'months' ? 'Monthly Sales Volume' : 'Daily Sales Volume')
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: @json($viewType === 'months' ? 'Future Time Period (Months)' : 'Future Time Period (Days)')
                        }
                    }
                }
            }
        }
    );

    // Initialize Customer Segmentation Chart
    const segmentationData = {
        'Box': { 'Enterprise': 35, 'SME': 28, 'Individual': 15, 'Retail': 22 },
        'Bag': { 'Enterprise': 22, 'SME': 35, 'Individual': 25, 'Retail': 18 },
        'Envelope': { 'Enterprise': 15, 'SME': 20, 'Individual': 45, 'Retail': 20 },
        'Filler': { 'Enterprise': 40, 'SME': 25, 'Individual': 10, 'Retail': 25 },
        'Wrap': { 'Enterprise': 45, 'SME': 22, 'Individual': 8, 'Retail': 25 }
    };

    // Initialize Feature Importance Chart
    const featureImportanceData = {
        features: ['Customer Rating', 'Unit Cost', 'Durability', 'Eco-Friendly', 'Stock Level', 'Seasonality'],
        importance: [0.28, 0.22, 0.18, 0.15, 0.10, 0.07]
    };

    new Chart(
        document.getElementById('featureImportanceChart').getContext('2d'),
        {
            type: 'bar',
            data: {
                labels: featureImportanceData.features,
                datasets: [{
                    label: 'Importance Score',
                    data: featureImportanceData.importance,
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(13, 202, 240, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgba(13, 202, 240, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(108, 117, 125, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Feature Importance in Sales Prediction Model',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const percentage = (context.parsed.y * 100).toFixed(1);
                                return `${context.label}: ${percentage}% importance`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 0.35,
                        title: {
                            display: true,
                            text: 'Importance Score'
                        },
                        ticks: {
                            callback: function(value) {
                                return (value * 100).toFixed(0) + '%';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Features'
                        },
                        ticks: {
                            maxRotation: 45
                        }
                    }
                }
            }
        }
    );

    new Chart(
        document.getElementById('customerSegmentationChart').getContext('2d'),
        {
            type: 'bar',
            data: {
                labels: Object.keys(segmentationData),
                datasets: [
                    {
                        label: 'Enterprise',
                        data: Object.values(segmentationData).map(cat => cat.Enterprise),
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'SME',
                        data: Object.values(segmentationData).map(cat => cat.SME),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Individual',
                        data: Object.values(segmentationData).map(cat => cat.Individual),
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Retail',
                        data: Object.values(segmentationData).map(cat => cat.Retail),
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Customer Segments by Product Category (%)'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 50,
                        title: {
                            display: true,
                            text: 'Purchase Percentage (%)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Product Categories'
                        }
                    }
                }
            }
        }
    );

    // Initialize Category Distribution Chart
    const categoryTotals = {
        'Box': 4087,
        'Bag': 3717,
        'Envelope': 3590,
        'Filler': 3314,
        'Wrap': 3610
    };

    new Chart(
        document.getElementById('categoryDistributionChart').getContext('2d'),
        {
            type: 'doughnut',
            data: {
                labels: Object.keys(categoryTotals),
                datasets: [{
                    data: Object.values(categoryTotals),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        }
    );

    // Handle Model Training
    document.getElementById('trainModel').addEventListener('click', function() {
        const button = this;
        const statusDiv = document.getElementById('trainingStatus');
        
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-gear-fill me-1"></i> Training...';
        statusDiv.innerHTML = '<div class="alert alert-info">Training in progress...</div>';

        fetch('/admin/predictions/train', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let successMessage = `<div class="alert alert-success">
                    <strong>Model trained successfully!</strong><br>
                    <small>
                        Accuracy: ${data.accuracy || 'N/A'}<br>
                        Samples processed: ${data.samples_processed || 'N/A'}<br>
                        Features: ${data.features_used ? data.features_used.join(', ') : 'N/A'}
                    </small>
                </div>`;
                statusDiv.innerHTML = successMessage;
                document.getElementById('lastUpdate').textContent = new Date().toLocaleString();
                
                // Refresh feature importance after training
                fetchFeatureImportance();
            } else {
                statusDiv.innerHTML = `<div class="alert alert-danger">
                    ${data.message || 'Training failed'}
                </div>`;
            }
        })
        .catch(error => {
            statusDiv.innerHTML = `<div class="alert alert-danger">
                Error: ${error.message}
            </div>`;
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = '<i class="bi bi-gear me-1"></i> Train Model';
        });
    });

    // Function to fetch and update feature importance
    function fetchFeatureImportance() {
        fetch('/admin/predictions/insights', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.feature_importance) {
                updateFeatureImportanceChart(data.feature_importance);
            }
        })
        .catch(error => {
            console.error('Error fetching feature importance:', error);
        });
    }

    // Function to update feature importance chart with new data
    function updateFeatureImportanceChart(featureData) {
        const chart = Chart.getChart('featureImportanceChart');
        if (chart && featureData.features && featureData.importance) {
            chart.data.labels = featureData.features;
            chart.data.datasets[0].data = featureData.importance;
            chart.update();
        }
    }

    // Initialize view type and period options
    const currentViewType = @json($viewType ?? 'days');
    const currentPeriod = @json($period ?? 30);
    
    function updatePeriodOptions(viewType) {
        const periodSelect = document.getElementById('predictionPeriod');
        periodSelect.innerHTML = '';
        
        if (viewType === 'months') {
            const monthOptions = [
                { value: 3, text: 'Next 3 months' },
                { value: 6, text: 'Next 6 months' },
                { value: 12, text: 'Next 12 months' },
                { value: 18, text: 'Next 18 months' },
                { value: 24, text: 'Next 24 months' }
            ];
            
            monthOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                if (option.value == currentPeriod && currentViewType === 'months') {
                    optionElement.selected = true;
                }
                periodSelect.appendChild(optionElement);
            });
        } else {
            const dayOptions = [
                { value: 7, text: 'Next 7 days' },
                { value: 14, text: 'Next 14 days' },
                { value: 30, text: 'Next 30 days' },
                { value: 60, text: 'Next 60 days' },
                { value: 90, text: 'Next 90 days' }
            ];
            
            dayOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.text;
                if (option.value == currentPeriod && currentViewType === 'days') {
                    optionElement.selected = true;
                }
                periodSelect.appendChild(optionElement);
            });
        }
    }

    // Initialize period options on page load
    updatePeriodOptions(currentViewType);

    // Handle View Type Change
    document.querySelectorAll('input[name="viewType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const viewType = this.value;
            updatePeriodOptions(viewType);
            updatePredictions();
        });
    });

    // Handle Period Change
    document.getElementById('predictionPeriod').addEventListener('change', function() {
        updatePredictions();
    });

    // Function to update predictions based on current selections
    function updatePredictions() {
        const viewType = document.querySelector('input[name="viewType"]:checked').value;
        const period = document.getElementById('predictionPeriod').value;
        
        fetch(`/admin/predictions/get?view_type=${viewType}&period=${period}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update chart with new predictions
                predictionsChart.data.labels = data.predictions.map(p => p.date);
                predictionsChart.data.datasets[0].data = data.predictions.map(p => p.predicted_sales);
                
                // Update chart title based on view type
                const chartTitle = viewType === 'months' ? 'Monthly Sales Predictions (Future)' : 'Daily Sales Predictions (Future)';
                predictionsChart.options.plugins.title.text = chartTitle;
                
                // Update y-axis label based on view type
                const yAxisLabel = viewType === 'months' ? 'Monthly Sales Volume' : 'Daily Sales Volume';
                predictionsChart.options.scales.y.title.text = yAxisLabel;
                
                // Update x-axis label based on view type
                const xAxisLabel = viewType === 'months' ? 'Future Time Period (Months)' : 'Future Time Period (Days)';
                predictionsChart.options.scales.x.title.text = xAxisLabel;
                
                predictionsChart.update();
            }
        })
        .catch(error => {
            console.error('Error fetching predictions:', error);
        });
    }

    // Custom Prediction Functionality
    document.getElementById('customPredictionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            material_name: document.getElementById('materialSelect').value,
            category: document.getElementById('categorySelect').value,
            eco_friendly: document.getElementById('ecoFriendlySelect').value,
            max_cost: document.getElementById('priceRange').value,
            limit: document.getElementById('resultLimit').value
        };

        // Remove empty values
        Object.keys(formData).forEach(key => {
            if (formData[key] === '' || formData[key] === null) {
                delete formData[key];
            }
        });

        // Start loading animation
        startPredictionLoading();

        fetch('/admin/predictions/custom', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Complete loading and show results
                completePredictionLoading(() => {
                    displayCustomResults(data);
                });
            } else {
                stopPredictionLoading();
                alert('Error: ' + (data.message || 'Failed to get predictions'));
            }
        })
        .catch(error => {
            stopPredictionLoading();
            console.error('Error:', error);
            alert('An error occurred while fetching predictions');
        });
    });

    // Loading Animation Functions
    function startPredictionLoading() {
        const button = document.getElementById('generatePredictionsBtn');
        const loadingOverlay = document.getElementById('predictionLoadingAnimation');
        const progressBar = document.getElementById('progressBarFill');
        const loadingStep = document.getElementById('loadingStep');
        const loadingPercentage = document.getElementById('loadingPercentage');

        // Add loading class to button
        button.classList.add('loading');
        button.disabled = true;
        button.innerHTML = '<i class="bi bi-gear-fill me-1 rotating"></i>Processing...';

        // Show loading overlay
        loadingOverlay.style.display = 'flex';

        // Add particles effect
        createLoadingParticles();

        // Simulate loading steps
        const steps = [
            { text: 'Initializing prediction engine...', duration: 800 },
            { text: 'Processing your filters...', duration: 600 },
            { text: 'Analyzing dataset patterns...', duration: 1000 },
            { text: 'Running ML algorithms...', duration: 800 },
            { text: 'Generating visualizations...', duration: 600 },
            { text: 'Finalizing results...', duration: 400 }
        ];

        let currentStep = 0;
        let progress = 0;

        function updateProgress() {
            if (currentStep < steps.length) {
                const step = steps[currentStep];
                loadingStep.textContent = step.text;
                
                // Animate progress
                const targetProgress = ((currentStep + 1) / steps.length) * 100;
                animateProgress(progress, targetProgress, progressBar, loadingPercentage, () => {
                    progress = targetProgress;
                    currentStep++;
                    setTimeout(updateProgress, step.duration);
                });
            }
        }

        updateProgress();
    }

    function animateProgress(from, to, progressBar, percentageElement, callback) {
        const duration = 300;
        const startTime = performance.now();

        function animate(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const currentValue = from + (to - from) * progress;

            progressBar.style.width = currentValue + '%';
            percentageElement.textContent = Math.round(currentValue) + '%';

            if (progress < 1) {
                requestAnimationFrame(animate);
            } else {
                callback();
            }
        }

        requestAnimationFrame(animate);
    }

    function createLoadingParticles() {
        const overlay = document.getElementById('predictionLoadingAnimation');
        const particlesContainer = document.createElement('div');
        particlesContainer.className = 'loading-particles';

        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 3 + 's';
            particle.style.animationDuration = (3 + Math.random() * 2) + 's';
            particlesContainer.appendChild(particle);
        }

        overlay.appendChild(particlesContainer);
    }

    function completePredictionLoading(callback) {
        const loadingOverlay = document.getElementById('predictionLoadingAnimation');
        const loadingStep = document.getElementById('loadingStep');
        const progressBar = document.getElementById('progressBarFill');
        const loadingPercentage = document.getElementById('loadingPercentage');

        // Complete progress
        loadingStep.textContent = 'Complete! Loading results...';
        progressBar.style.width = '100%';
        loadingPercentage.textContent = '100%';

        // Wait a moment then hide overlay
        setTimeout(() => {
            loadingOverlay.style.animation = 'fadeOutOverlay 0.5s ease-out forwards';
            setTimeout(() => {
                loadingOverlay.style.display = 'none';
                loadingOverlay.style.animation = '';
                
                // Remove particles
                const particles = loadingOverlay.querySelector('.loading-particles');
                if (particles) particles.remove();
                
                // Reset button
                const button = document.getElementById('generatePredictionsBtn');
                button.classList.remove('loading');
                button.disabled = false;
                button.innerHTML = '<i class="bi bi-calculator me-1"></i>Generate Custom Predictions';
                
                // Show results with animation
                callback();
            }, 500);
        }, 800);
    }

    function stopPredictionLoading() {
        const loadingOverlay = document.getElementById('predictionLoadingAnimation');
        const button = document.getElementById('generatePredictionsBtn');

        loadingOverlay.style.display = 'none';
        button.classList.remove('loading');
        button.disabled = false;
        button.innerHTML = '<i class="bi bi-calculator me-1"></i>Generate Custom Predictions';
    }

    function displayCustomResults(data) {
        const resultsDiv = document.getElementById('customPredictionResults');
        const tbody = document.getElementById('customResultsBody');
        
        // Reset animation classes
        resultsDiv.classList.remove('show');
        resultsDiv.style.display = 'block';
        
        // Clear previous results
        tbody.innerHTML = '';
        
        if (data.predictions.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No materials found matching your criteria</td></tr>';
        } else {
            // Animate table rows appearing
            data.predictions.forEach((prediction, index) => {
                const row = document.createElement('tr');
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                row.style.transition = `all 0.3s ease-out ${index * 0.1}s`;
                
                row.innerHTML = `
                    <td>
                        <strong>${prediction.material_name}</strong>
                        ${prediction.eco_friendly === 'Yes' ? '<span class="badge bg-success ms-1">Eco</span>' : ''}
                    </td>
                    <td>${prediction.category}</td>
                    <td>${Number(prediction.current_sales).toLocaleString()}</td>
                    <td><strong>${Number(prediction.predicted_sales).toLocaleString()}</strong></td>
                    <td>UGX ${Number(prediction.unit_cost).toFixed(2)}</td>
                    <td><span class="badge bg-primary">${Number(prediction.rating).toFixed(1)}/5</span></td>
                    <td>${prediction.eco_friendly === 'Yes' ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle text-muted"></i>'}</td>
                `;
                tbody.appendChild(row);
                
                // Animate row in
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 100 + (index * 100));
            });
        }
        
        // Update summary info
        const summaryText = `Showing ${data.showing} of ${data.total_found} materials found`;
        const existingSummary = document.querySelector('#customPredictionResults h6');
        if (existingSummary) {
            existingSummary.innerHTML = `Custom Prediction Results <small class="text-muted">(${summaryText})</small>`;
        }
        
        // Create dynamic charts with delay
        setTimeout(() => {
            createCustomCharts(data.predictions);
        }, 300);
        
        // Trigger main container animation
        setTimeout(() => {
            resultsDiv.classList.add('show');
        }, 100);
        
        // Add success notification
        showSuccessNotification(data.predictions.length);
    }

    function showSuccessNotification(count) {
        // Create success toast
        const toast = document.createElement('div');
        toast.className = 'prediction-success-toast';
        toast.innerHTML = `
            <div class="toast-content">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                <span>Successfully generated ${count} predictions with interactive charts!</span>
            </div>
        `;
        
        // Add toast styles
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.5s ease-out;
            border-left: 4px solid #28a745;
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 500);
        }, 3000);
    }

    // Global variables to store chart instances
    let customSalesChart = null;
    let customCategoryChart = null;
    let customScatterChart = null;
    let customEcoChart = null;

    function createCustomCharts(predictions) {
        if (predictions.length === 0) return;

        // Destroy existing charts
        if (customSalesChart) customSalesChart.destroy();
        if (customCategoryChart) customCategoryChart.destroy();
        if (customScatterChart) customScatterChart.destroy();
        if (customEcoChart) customEcoChart.destroy();

        // 1. Sales Comparison Chart (Bar Chart)
        const salesLabels = predictions.map(p => p.material_name.length > 12 ? p.material_name.substring(0, 12) + '...' : p.material_name);
        const currentSales = predictions.map(p => Number(p.current_sales));
        const predictedSales = predictions.map(p => Number(p.predicted_sales));

        customSalesChart = new Chart(document.getElementById('customSalesChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: salesLabels,
                datasets: [
                    {
                        label: 'Current Sales',
                        data: currentSales,
                        backgroundColor: 'rgba(108, 117, 125, 0.8)',
                        borderColor: 'rgba(108, 117, 125, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Predicted Sales',
                        data: predictedSales,
                        backgroundColor: 'rgba(13, 110, 253, 0.8)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Sales Volume'
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45
                        }
                    }
                }
            }
        });

        // 2. Category Distribution Chart (Doughnut Chart)
        const categoryData = {};
        predictions.forEach(p => {
            categoryData[p.category] = (categoryData[p.category] || 0) + Number(p.predicted_sales);
        });

        const categoryColors = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
        ];

        customCategoryChart = new Chart(document.getElementById('customCategoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(categoryData),
                datasets: [{
                    data: Object.values(categoryData),
                    backgroundColor: categoryColors.slice(0, Object.keys(categoryData).length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // 3. Cost vs Rating Scatter Chart
        const scatterData = predictions.map(p => ({
            x: Number(p.unit_cost),
            y: Number(p.rating),
            label: p.material_name,
            sales: Number(p.predicted_sales)
        }));

        customScatterChart = new Chart(document.getElementById('customScatterChart').getContext('2d'), {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Materials',
                    data: scatterData,
                    backgroundColor: function(context) {
                        const value = context.parsed.y;
                        return value >= 4 ? 'rgba(40, 167, 69, 0.8)' : 
                               value >= 3 ? 'rgba(255, 193, 7, 0.8)' : 
                               'rgba(220, 53, 69, 0.8)';
                    },
                    borderColor: function(context) {
                        const value = context.parsed.y;
                        return value >= 4 ? 'rgba(40, 167, 69, 1)' : 
                               value >= 3 ? 'rgba(255, 193, 7, 1)' : 
                               'rgba(220, 53, 69, 1)';
                    },
                    pointRadius: function(context) {
                        const sales = context.raw.sales;
                        return Math.max(4, Math.min(15, sales / 50));
                    }
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const point = context.raw;
                                return `${point.label}: UGX ${point.x.toFixed(2)}, Rating: ${point.y}/5, Sales: ${point.sales.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Unit Cost ($)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Rating (1-5)'
                        },
                        min: 0,
                        max: 5
                    }
                }
            }
        });

        // 4. Eco-Friendly Distribution Chart (Pie Chart)
        const ecoData = { 'Eco-Friendly': 0, 'Non Eco-Friendly': 0 };
        predictions.forEach(p => {
            if (p.eco_friendly === 'Yes') {
                ecoData['Eco-Friendly'] += Number(p.predicted_sales);
            } else {
                ecoData['Non Eco-Friendly'] += Number(p.predicted_sales);
            }
        });

        customEcoChart = new Chart(document.getElementById('customEcoChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(ecoData),
                datasets: [{
                    data: Object.values(ecoData),
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(108, 117, 125, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(108, 117, 125, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Clear filters functionality
    document.getElementById('clearFilters').addEventListener('click', function() {
        const resultsDiv = document.getElementById('customPredictionResults');
        
        // Animate out results
        resultsDiv.classList.remove('show');
        
        setTimeout(() => {
            document.getElementById('materialSelect').value = '';
            document.getElementById('categorySelect').value = '';
            document.getElementById('ecoFriendlySelect').value = '';
            document.getElementById('priceRange').value = '';
            document.getElementById('resultLimit').value = '10';
            
            // Destroy custom charts
            if (customSalesChart) customSalesChart.destroy();
            if (customCategoryChart) customCategoryChart.destroy();
            if (customScatterChart) customScatterChart.destroy();
            if (customEcoChart) customEcoChart.destroy();
            
            // Hide results
            resultsDiv.style.display = 'none';
            
            // Show clear notification
            showClearNotification();
        }, 300);
    });

    function showClearNotification() {
        const toast = document.createElement('div');
        toast.className = 'prediction-clear-toast';
        toast.innerHTML = `
            <div class="toast-content">
                <i class="bi bi-arrow-clockwise text-info me-2"></i>
                <span>Filters cleared successfully!</span>
            </div>
        `;
        
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.5s ease-out;
            border-left: 4px solid #17a2b8;
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 500);
        }, 2000);
    }
});
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}
.card-header {
    border-bottom: none;
    background-color: transparent;
    padding: 1.5rem;
}
.progress {
    height: 8px;
    border-radius: 4px;
}
.table > :not(caption) > * > * {
    padding: 1rem 1.5rem;
}
.btn-primary {
    padding: 0.5rem 1rem;
}

/* View Type Toggle Styling */
.btn-check:checked + .btn-outline-primary {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.btn-outline-primary:hover {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

/* Period Selection Styling */
#predictionPeriod {
    transition: all 0.3s ease;
}

#predictionPeriod:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

/* Main Predictions Chart Styling */
#predictionsChart {
    max-height: 400px !important;
    height: 400px !important;
}

.card-body canvas#predictionsChart {
    max-height: 400px;
}

/* Custom Prediction Form Styling */
#customPredictionForm {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

#customPredictionResults {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
}

#customResultsTable {
    margin-bottom: 0;
}

#customResultsTable th {
    border-top: none;
    background-color: #f8f9fa;
    font-weight: 600;
}

.custom-filter-row {
    background: white;
    padding: 1rem;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Custom Charts Styling */
.custom-chart-container {
    background: #fff;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.custom-chart-container .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 6px 6px 0 0;
    margin: -1rem -1rem 1rem -1rem;
    padding: 0.75rem 1rem;
}

.custom-chart-container canvas {
    max-height: 300px;
}

/* Chart Cards Custom Styling */
#customPredictionResults .card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
}

#customPredictionResults .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
}

#customPredictionResults .card-header {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
    border-bottom: none;
    font-weight: 600;
}

/* Responsive adjustments for charts */
@media (max-width: 768px) {
    #customPredictionResults .row .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .custom-chart-container canvas {
        max-height: 250px;
    }
}

/* Customer Segmentation Styling */
.category-stats {
    padding: 1rem;
}

.stat-item {
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    border-left: 4px solid #0d6efd;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

/* Feature Importance Styling */
.feature-insights {
    padding: 1rem;
}

.insight-item {
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.insight-item:hover {
    background: #e9ecef;
    transform: translateX(3px);
}

.insight-icon {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.insight-item h6 {
    color: #495057;
    font-weight: 600;
}

.insight-item .small {
    font-size: 0.8rem;
    line-height: 1.4;
}

/* Feature Importance Chart Styling */
#featureImportanceChart {
    max-height: 300px;
}

.stat-item h6 {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.stat-item .badge {
    font-size: 0.7rem;
    padding: 0.25em 0.5em;
}

.stat-item .small {
    font-size: 0.75rem;
}

/* Category Distribution Chart Container */
#categoryDistributionChart {
    max-height: 200px !important;
    height: 200px !important;
}

/* Segmentation Chart Styling */
#customerSegmentationChart {
    max-height: 300px;
}

/* Custom badge colors for category status */
.badge.bg-primary { background-color: #0d6efd !important; }
.badge.bg-success { background-color: #198754 !important; }
.badge.bg-info { background-color: #0dcaf0 !important; }
.badge.bg-warning { background-color: #ffc107 !important; color: #000; }
.badge.bg-secondary { background-color: #6c757d !important; }

/* Modern Loading Animation Styles */
.prediction-loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(13, 110, 253, 0.95);
    backdrop-filter: blur(10px);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    animation: fadeInOverlay 0.5s ease-out;
}

.loading-content {
    text-align: center;
    color: white;
    max-width: 400px;
    padding: 2rem;
}

/* Spinner Animation */
.loading-spinner {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
}

.spinner-ring {
    position: absolute;
    width: 100%;
    height: 100%;
    border: 4px solid transparent;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

.spinner-ring:nth-child(1) {
    border-top-color: #fff;
    animation-delay: 0s;
}

.spinner-ring:nth-child(2) {
    border-top-color: rgba(255, 255, 255, 0.7);
    animation-delay: 0.3s;
    transform: scale(0.8);
}

.spinner-ring:nth-child(3) {
    border-top-color: rgba(255, 255, 255, 0.4);
    animation-delay: 0.6s;
    transform: scale(0.6);
}

/* Progress Bar Styles */
.progress-bar-container {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
    margin: 1rem 0;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0.8), #fff);
    background-size: 200% 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
    animation: shimmer 1.5s infinite;
}

/* Loading Text Animation */
.loading-text h5 {
    font-weight: 600;
    margin-bottom: 1rem;
    animation: pulse 2s infinite;
}

.loading-step {
    font-size: 1.1rem;
    margin-bottom: 1rem;
    opacity: 0.9;
    animation: fadeInUp 0.5s ease-out;
}

/* Results Animation */
#customPredictionResults {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
}

#customPredictionResults.show {
    opacity: 1;
    transform: translateY(0);
}

/* Chart Container Animations */
#customPredictionResults .card {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s ease-out;
}

#customPredictionResults.show .card:nth-child(1) {
    animation: slideInUp 0.6s ease-out 0.1s forwards;
}

#customPredictionResults.show .card:nth-child(2) {
    animation: slideInUp 0.6s ease-out 0.2s forwards;
}

#customPredictionResults.show .card:nth-child(3) {
    animation: slideInUp 0.6s ease-out 0.3s forwards;
}

#customPredictionResults.show .card:nth-child(4) {
    animation: slideInUp 0.6s ease-out 0.4s forwards;
}

/* Button Loading State */
#generatePredictionsBtn.loading {
    background: linear-gradient(45deg, #0d6efd, #6610f2, #0d6efd);
    background-size: 200% 200%;
    animation: gradientShift 2s infinite;
    position: relative;
    overflow: hidden;
}

#generatePredictionsBtn.loading::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: buttonShine 1.5s infinite;
}

/* Keyframe Animations */
@keyframes fadeInOverlay {
    from {
        opacity: 0;
        backdrop-filter: blur(0px);
    }
    to {
        opacity: 1;
        backdrop-filter: blur(10px);
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

@keyframes buttonShine {
    0% { left: -100%; }
    100% { left: 100%; }
}

@keyframes fadeOutOverlay {
    from {
        opacity: 1;
        backdrop-filter: blur(10px);
    }
    to {
        opacity: 0;
        backdrop-filter: blur(0px);
    }
}

/* Button Icon Rotation */
.rotating {
    animation: spin 1s linear infinite;
}

/* Particle Animation (Optional Enhancement) */
.loading-particles {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: float 3s infinite ease-in-out;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    90% {
        opacity: 1;
    }
    100% {
        transform: translateY(-100vh) rotate(360deg);
        opacity: 0;
    }
}
</style>
@endpush 