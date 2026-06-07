import os
import json
from ocr import process_image
from nlp import extract_structured_data

DATASET_DIR = "dataset/images"

def test_on_dataset(limit=15):
    """Test the OCR and NLP pipeline on a few images from the dataset."""
    if not os.path.exists(DATASET_DIR):
        print(f"Error: Directory {DATASET_DIR} does not exist.")
        return

    images = [f for f in os.listdir(DATASET_DIR) if f.lower().endswith(('.jpg', '.jpeg', '.png'))]
    
    if not images:
        print("No images found in dataset.")
        return
        
    print(f"Found {len(images)} images. Testing on {min(limit, len(images))} images...")
    
    for img_name in images[:limit]:
        img_path = os.path.join(DATASET_DIR, img_name)
        print(f"\n{'='*40}")
        print(f" Processing: {img_name} ")
        print(f"{'='*40}")
        
        try:
            with open(img_path, "rb") as f:
                image_bytes = f.read()
            
            # Step 1: OCR
            print("1. Running OCR (EasyOCR)...")
            text_lines = process_image(image_bytes)
            print(f"   -> Extracted {len(text_lines)} lines of text.")
            print(f"   -> Raw text: {text_lines}") # Print all raw text to debug
            
            # Step 2: NLP/Data Extraction
            print("2. Extracting structured data...")
            result = extract_structured_data(text_lines)
            
            print("3. Result:")
            print(json.dumps(result, indent=2))
        except Exception as e:
            print(f"Error processing {img_name}: {e}")

if __name__ == "__main__":
    test_on_dataset(limit=1)

