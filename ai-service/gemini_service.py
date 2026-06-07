import os
import json
import google.generativeai as genai
from dotenv import load_dotenv

def process_receipt_with_gemini(image_bytes: bytes, mime_type: str = "image/jpeg") -> dict:
    """
    Send the receipt image to Gemini and instruct it to extract data into a specific JSON format.
    """
    # Reload env to catch any runtime changes to .env
    load_dotenv(dotenv_path="../.env", override=True)
    load_dotenv(override=True)
    
    current_api_key = os.getenv("GEMINI_API_KEY")
    if not current_api_key:
        raise ValueError("GEMINI_API_KEY is not set in the .env file! Please add it.")
        
    genai.configure(api_key=current_api_key)
    
    # We use gemini-flash-latest as it is extremely fast and capable for multimodal tasks
    model = genai.GenerativeModel('gemini-flash-latest')

    prompt = """
    Analyze this receipt image and extract the following information in strict JSON format. 
    Only return the JSON object, nothing else. Do not use markdown blocks like ```json ... ```.
    
    Format required:
    {
        "store_name": "String (Name of the store, default empty string)",
        "receipt_date": "String (Date of receipt in YYYY-MM-DD format, default empty string)",
        "total": "Float (Total amount paid, default 0.0)",
        "items": [
            {
                "item_name": "String (Name of the item)",
                "price": "Float (Total price for this item row)",
                "quantity": "Integer (Quantity of this item, default 1)",
                "category_id": "Integer (Guess category ID based on the item name using the rules below)"
            }
        ]
    }
    
    Category Rules:
    1 = Makanan & Minuman (Food & Drinks)
    2 = Kebutuhan Rumah (Household Needs like soap, tissue)
    3 = Elektronik (Electronics)
    4 = Pakaian (Clothes)
    5 = Kesehatan (Health, medicine)
    6 = Transportasi (Transport, gas, parking)
    7 = Lainnya (Others, use this if it doesn't fit 1-6)
    
    Notes:
    - Extract ONLY the actual items purchased. Do NOT extract taxes, subtotals, change, cash, receipt numbers, dates, or card details as items.
    - If quantity is mentioned in the item name (e.g., '2 Ham Cheese'), extract 2 as quantity and 'Ham Cheese' as item_name.
    - Prices should be numbers without currency symbols or commas (e.g., 74000.0 instead of 74,000).
    """
    
    image_parts = {
        "mime_type": mime_type,
        "data": image_bytes
    }
    
    try:
        response = model.generate_content([prompt, image_parts])
        
        # Parse the JSON from the response text
        raw_text = response.text.strip()
        # Clean up any potential markdown formatting the AI might still add
        if raw_text.startswith('```json'):
            raw_text = raw_text[7:]
        if raw_text.startswith('```'):
            raw_text = raw_text[3:]
        if raw_text.endswith('```'):
            raw_text = raw_text[:-3]
            
        return json.loads(raw_text.strip())
        
    except Exception as e:
        print(f"Gemini API Error: {e}")
        # Return fallback structure so the frontend doesn't crash completely
        return {
            "store_name": "",
            "receipt_date": "",
            "total": 0.0,
            "items": [],
            "error": str(e)
        }
