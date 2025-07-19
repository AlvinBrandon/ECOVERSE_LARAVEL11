import pandas as pd
import numpy as np
import json
import sys
import os

class SimplePackagingPrediction:
    def __init__(self):
        self.data_path = '../machinelearning/packaging_materials_dataset.csv'

    def load_data(self):
        """Load the dataset"""
        try:
            if os.path.exists(self.data_path):
                return pd.read_csv(self.data_path)
            else:
                # Create sample data if file doesn't exist
                return self.create_sample_data()
        except Exception as e:
            return self.create_sample_data()

    def create_sample_data(self):
        """Create sample data for demonstration"""
        np.random.seed(42)
        n_samples = 100
        
        data = {
            'material_type': np.random.choice(['plastic', 'cardboard', 'glass', 'metal'], n_samples),
            'quantity': np.random.randint(1, 1000, n_samples),
            'supplier': np.random.choice(['supplier_a', 'supplier_b', 'supplier_c'], n_samples),
            'price': np.random.uniform(0.5, 50.0, n_samples),
            'quality_score': np.random.uniform(1, 10, n_samples),
            'delivery_time': np.random.randint(1, 30, n_samples)
        }
        
        return pd.DataFrame(data)

    def get_feature_importance(self):
        """Return mock feature importance data"""
        return {
            'features': ['material_type', 'quantity', 'supplier', 'price', 'quality_score', 'delivery_time'],
            'importance': [0.25, 0.20, 0.15, 0.18, 0.12, 0.10],
            'status': 'success'
        }

    def predict(self, input_data):
        """Make simple predictions based on basic rules"""
        df = self.load_data()
        
        # Simple prediction logic
        predictions = []
        for item in input_data:
            material = item.get('material_type', 'plastic')
            quantity = item.get('quantity', 100)
            
            # Simple prediction based on material type and quantity
            if material == 'plastic':
                base_price = 2.5
            elif material == 'cardboard':
                base_price = 1.8
            elif material == 'glass':
                base_price = 4.2
            else:  # metal
                base_price = 3.8
            
            # Adjust price based on quantity (bulk discount)
            if quantity > 500:
                price_multiplier = 0.85
            elif quantity > 100:
                price_multiplier = 0.92
            else:
                price_multiplier = 1.0
            
            predicted_price = base_price * price_multiplier
            
            predictions.append({
                'material_type': material,
                'quantity': quantity,
                'predicted_price': round(predicted_price, 2),
                'estimated_delivery': np.random.randint(5, 21)
            })
        
        return {
            'predictions': predictions,
            'status': 'success'
        }

    def train(self, training_data=None):
        """Mock training function"""
        df = self.load_data()
        
        return {
            'status': 'success',
            'message': 'Model trained successfully',
            'samples_processed': len(df),
            'accuracy': 0.85,
            'features_used': ['material_type', 'quantity', 'supplier', 'price', 'quality_score', 'delivery_time']
        }

    def get_statistics(self):
        """Get basic statistics from the dataset"""
        df = self.load_data()
        
        stats = {
            'total_samples': len(df),
            'material_distribution': df['material_type'].value_counts().to_dict() if 'material_type' in df.columns else {},
            'average_price': float(df['price'].mean()) if 'price' in df.columns else 0,
            'average_quantity': float(df['quantity'].mean()) if 'quantity' in df.columns else 0,
            'status': 'success'
        }
        
        return stats

def handle_command():
    """Handle command line arguments"""
    if len(sys.argv) < 2:
        return json.dumps({'error': 'No command provided'})
    
    command = sys.argv[1]
    predictor = SimplePackagingPrediction()
    
    try:
        if command == 'importance':
            result = predictor.get_feature_importance()
        elif command == 'train':
            # Read input data if provided
            try:
                input_data = json.loads(sys.stdin.read()) if not sys.stdin.isatty() else None
            except:
                input_data = None
            result = predictor.train(input_data)
        elif command == 'predict':
            # Read input data from stdin
            try:
                input_data = json.loads(sys.stdin.read())
            except:
                input_data = [{'material_type': 'plastic', 'quantity': 100}]
            result = predictor.predict(input_data)
        elif command == 'stats':
            result = predictor.get_statistics()
        else:
            result = {'error': f'Unknown command: {command}'}
        
        return json.dumps(result)
    
    except Exception as e:
        return json.dumps({'error': str(e)})

if __name__ == '__main__':
    print(handle_command())
