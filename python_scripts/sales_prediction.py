import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.ensemble import RandomForestRegressor
import joblib
import json
import sys
import os

class PackagingMaterialsPrediction:
    def __init__(self):
        self.model = None
        self.scaler = StandardScaler()
        self.label_encoders = {}
        self.model_path = 'models/packaging_prediction_model.joblib'
        self.scaler_path = 'models/packaging_scaler.joblib'
        self.encoders_path = 'models/label_encoders.joblib'

    def prepare_data(self, data):
        # Convert data to DataFrame if it's a dictionary
        if isinstance(data, dict):
            data = pd.DataFrame([data])
        
        # Feature engineering
        data['Month_Num'] = pd.to_datetime(data['Month'], format='%B').dt.month
        
        # Encode categorical variables
        categorical_features = ['Category', 'Eco-Friendly', 'Recommended For', 'Popular Regions']
        
        for feature in categorical_features:
            if feature in data.columns:
                if feature not in self.label_encoders:
                    self.label_encoders[feature] = LabelEncoder()
                    data[feature] = self.label_encoders[feature].fit_transform(data[feature])
                else:
                    data[feature] = self.label_encoders[feature].transform(data[feature])
        
        # Select features for prediction
        features = [
            'Unit Cost (USD)', 'Stock Level', 'Avg Lead Time (days)', 
            'Durability (1-10)', 'Customer Rating (1-5)', 'Seasonality Index',
            'Month_Num'
        ] + [f for f in categorical_features if f in data.columns]
        
        return data[features]

    def train(self, training_data):
        # Prepare features and target
        X = self.prepare_data(training_data)
        y = training_data['Monthly Sales']
        
        # Split data
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)
        
        # Scale features
        X_train_scaled = self.scaler.fit_transform(X_train)
        
        # Train model
        self.model = RandomForestRegressor(
            n_estimators=100,
            max_depth=10,
            min_samples_split=5,
            min_samples_leaf=2,
            random_state=42
        )
        self.model.fit(X_train_scaled, y_train)
        
        # Save model, scaler, and encoders
        os.makedirs('models', exist_ok=True)
        joblib.dump(self.model, self.model_path)
        joblib.dump(self.scaler, self.scaler_path)
        joblib.dump(self.label_encoders, self.encoders_path)
        
        # Calculate accuracy on test set
        X_test_scaled = self.scaler.transform(X_test)
        accuracy = self.model.score(X_test_scaled, y_test)
        
        # Calculate feature importance
        feature_importance = dict(zip(X.columns, self.model.feature_importances_))
        
        return {
            'accuracy': accuracy,
            'feature_importance': feature_importance,
            'rmse': np.sqrt(np.mean((self.model.predict(X_test_scaled) - y_test) ** 2)),
            'mae': np.mean(np.abs(self.model.predict(X_test_scaled) - y_test))
        }

    def predict(self, input_data):
        # Load model and scaler if not already loaded
        if self.model is None:
            self.model = joblib.load(self.model_path)
            self.scaler = joblib.load(self.scaler_path)
            self.label_encoders = joblib.load(self.encoders_path)
        
        # Prepare input data
        X = self.prepare_data(input_data)
        X_scaled = self.scaler.transform(X)
        
        # Make prediction
        prediction = self.model.predict(X_scaled)
        
        # Calculate confidence score (using prediction intervals)
        predictions = []
        for estimator in self.model.estimators_:
            predictions.append(estimator.predict(X_scaled))
        predictions = np.array(predictions)
        
        confidence = {
            'mean': prediction[0],
            'std': np.std(predictions, axis=0)[0],
            'lower_bound': np.percentile(predictions, 2.5, axis=0)[0],
            'upper_bound': np.percentile(predictions, 97.5, axis=0)[0]
        }
        
        return confidence

    def get_feature_importance(self):
        if self.model is None:
            self.model = joblib.load(self.model_path)
        
        # Get feature names from the most recent training
        feature_names = [
            'Unit Cost', 'Stock Level', 'Lead Time', 
            'Durability', 'Customer Rating', 'Seasonality',
            'Month', 'Category', 'Eco-Friendly', 'Recommended For',
            'Popular Regions'
        ]
        
        importance = self.model.feature_importances_
        return dict(zip(feature_names, importance))

def handle_command():
    if len(sys.argv) < 2:
        return json.dumps({'error': 'No command specified'})

    command = sys.argv[1]
    model = PackagingMaterialsPrediction()

    try:
        if command == 'train':
            # Read training data from stdin
            training_data = pd.read_json(sys.stdin)
            results = model.train(training_data)
            return json.dumps({
                'success': True,
                'accuracy': results['accuracy'],
                'feature_importance': results['feature_importance'],
                'rmse': results['rmse'],
                'mae': results['mae']
            })

        elif command == 'predict':
            # Read input data from stdin
            input_data = json.loads(sys.stdin.read())
            prediction = model.predict(input_data)
            return json.dumps({
                'prediction': prediction['mean'],
                'confidence': {
                    'std': prediction['std'],
                    'lower_bound': prediction['lower_bound'],
                    'upper_bound': prediction['upper_bound']
                }
            })

        elif command == 'importance':
            importance = model.get_feature_importance()
            return json.dumps(importance)

        else:
            return json.dumps({'error': 'Invalid command'})

    except Exception as e:
        return json.dumps({'error': str(e)})

if __name__ == '__main__':
    result = handle_command()
    print(result) 