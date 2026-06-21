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
        "store_name": "String (Name of the store/company, default empty string)",
        "receipt_date": "String (Date of receipt in YYYY-MM-DD format, default empty string)",
        "address": "String (Complete physical address of the store, default empty string)",
        "total": "Float (Grand total amount paid after all discounts, default 0.0)",
        "items": [
            {
                "item_name": "String (Name of the item/product)",
                "quantity": "Integer (Quantity purchased, default 1)",
                "price": "Float (Net price for this item after any discount, default 0.0)"
            }
        ]
    }

    IMPORTANT RULES:
    1. DATE FORMAT: This receipt is from Indonesia. If the date appears as DD-MM-YY or DD-MM-YYYY, treat it as Day-Month-Year (e.g., "10-06-26" means June 10, 2026, output as "2026-06-10"). NEVER swap the day and year.
    2. ITEMS: Extract every product/item line on the receipt into the "items" array. If a line labeled "HEMAT" or discount appears after an item, subtract that discount from the item's price to get the net price. Do NOT include discount/HEMAT lines as separate items.
    3. TOTAL: Use the grand total printed on the receipt (labeled TOTAL, JUMLAH, or similar). This should already reflect all discounts.
    4. PRICES: All prices/totals must be plain numbers without currency symbols or commas (e.g., 63890.0 not Rp 63,890).
    5. If any field is not found, use the default value specified above. If no items are found, return an empty array [].
    """
    
    import time
    
    image_parts = {
        "mime_type": mime_type,
        "data": image_bytes
    }
    
    max_retries = 3
    for attempt in range(max_retries):
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
            error_str = str(e)
            print(f"Gemini API Error (Attempt {attempt+1}/{max_retries}): {error_str}")
            
            # Jika terkena rate limit (429 / ResourceExhausted), tunggu sebentar lalu coba lagi
            if "429" in error_str or "ResourceExhausted" in error_str or "quota" in error_str.lower():
                if attempt < max_retries - 1:
                    print("Terkena rate limit, menunggu 20 detik sebelum mencoba lagi...")
                    time.sleep(20)
                    continue
            
            # Jika bukan rate limit atau sudah maksimal retry, kembalikan fallback
            return {
                "store_name": "",
                "receipt_date": "",
                "address": "",
                "total": 0.0,
                "items": [],
                "error": error_str
            }
