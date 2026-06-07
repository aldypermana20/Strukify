import re
import difflib
from typing import List, Dict, Any

# Keyword mapping to Laravel Category IDs
CATEGORY_KEYWORDS = {
    1: ['nasi', 'roti', 'kopi', 'teh', 'gula', 'garam', 'mie', 'ayam', 'daging', 'susu', 'air', 'minuman', 'makanan', 'snack', 'kue', 'indomie'], # Makanan & Minuman
    2: ['sabun', 'shampo', 'deterjen', 'pewangi', 'tisu', 'piring', 'gelas', 'sapu', 'pel', 'pembersih', 'rinso', 'sunlight'], # Kebutuhan Rumah
    3: ['kabel', 'charger', 'baterai', 'mouse', 'keyboard', 'laptop', 'hp', 'handphone', 'earphone'], # Elektronik
    4: ['baju', 'kaos', 'celana', 'kemeja', 'jaket', 'topi', 'sepatu', 'sandal'], # Pakaian
    5: ['obat', 'vitamin', 'masker', 'panadol', 'paramex', 'betadine', 'plester', 'tolak angin'], # Kesehatan
    6: ['bensin', 'parkir', 'tol', 'gojek', 'grab', 'pertalite', 'pertamax'], # Transportasi
}

def is_fuzzy_match(text: str, keywords: List[str], threshold: float = 0.8) -> bool:
    """Check if any keyword is present in text, allowing for slight OCR errors."""
    text_lower = text.lower()
    
    # Fast exact match
    for kw in keywords:
        if kw in text_lower:
            return True
            
    # Fuzzy match word by word using Levenshtein-like distance (SequenceMatcher)
    words = re.findall(r'\w+', text_lower)
    for kw in keywords:
        for word in words:
            # Only check if lengths are close to save processing time
            if abs(len(word) - len(kw)) <= 2:
                if difflib.SequenceMatcher(None, word, kw).ratio() >= threshold:
                    return True
    return False

def guess_category(item_name: str) -> int:
    """Guess category based on fuzzy keyword matching."""
    name_lower = item_name.lower()
    for category_id, keywords in CATEGORY_KEYWORDS.items():
        # High threshold for categories to prevent false positives
        if is_fuzzy_match(name_lower, keywords, threshold=0.85):
            return category_id
    return 7 # Default to "Lainnya"

def clean_price(price_str: str) -> float:
    """Clean price string and convert to float."""
    # Remove currency symbols and common noise
    clean = re.sub(r'[^\d.,]', '', price_str)
    
    # Handle European/Indonesian format (1.000,00) vs US format (1,000.00)
    if ',' in clean and '.' in clean:
        if clean.find('.') < clean.find(','):
            # 1.000,00 -> 1000.00
            clean = clean.replace('.', '').replace(',', '.')
        else:
            # 1,000.00 -> 1000.00
            clean = clean.replace(',', '')
    elif ',' in clean:
        # Check if comma is decimal or thousand separator
        # In ID: 10.000 or 10,00 (rarely 10,000)
        parts = clean.split(',')
        if len(parts[-1]) <= 2: # Likely decimal
            clean = clean.replace(',', '.')
        else:
            clean = clean.replace(',', '')
    
    try:
        return float(clean)
    except ValueError:
        return 0.0

def extract_structured_data(text_lines: List[str]) -> Dict[str, Any]:
    """
    Enhanced heuristic-based extraction from raw OCR lines.
    """
    store_name = ""
    receipt_date = ""
    total = 0.0
    items = []
    
    # Keywords for total detection
    total_keywords = ['total', 'grand total', 'jumlah', 'bayar', 'amount', 'nett', 'total harga']
    exclude_keywords = ['subtotal', 'diskon', 'discount', 'pajak', 'tax', 'service', 'ppn', 'kembali', 'change', 'tunai', 'cash']
    
    # Blacklist keywords that shouldn't be parsed as items
    blacklist = ['rcpt', 'check', 'pax', 'pos', 'cashier', 'op', 'kasir', 'struk', 'tanggal', 'date', 'waktu', 'time', 'telp', 'phone', 'jl', 'jalan', 'npwp']
    
    def is_separator(text: str) -> bool:
        clean = re.sub(r'\s+', '', text)
        return len(clean) >= 4 and len(re.sub(r'[-=_.*]', '', clean)) <= 1

    has_separators = any(is_separator(line) for line in text_lines)
    in_item_section = not has_separators
    
    # 1. Store Name Detection (First 3 lines that aren't purely numbers/date)
    for line in text_lines[:3]:
        if len(line.strip()) > 3 and not re.search(r'\d{2,}', line):
            store_name = line.strip()
            break
    if not store_name and text_lines:
        store_name = text_lines[0]

    date_pattern = r'\b(\d{1,4}[/-]\d{1,2}[/-]\d{1,4})\b'
    price_pattern = r'(\d{1,3}(?:[.,]\d{3})*(?:[.,]\d{2})?)'
    
    for i, line in enumerate(text_lines):
        line_lower = line.lower()
        
        # Separator logic to bound the items section
        if is_separator(line):
            if not in_item_section:
                in_item_section = True
            elif len(items) > 0:
                in_item_section = False
            continue
            
        # 2. Date Extraction
        if not receipt_date:
            date_match = re.search(date_pattern, line)
            if date_match:
                receipt_date = date_match.group(1).replace('/', '-')
        
        # 3. Total Extraction
        if is_fuzzy_match(line_lower, total_keywords) and not is_fuzzy_match(line_lower, exclude_keywords):
            # Search for price in same line or next
            potential_lines = [line]
            if i + 1 < len(text_lines):
                potential_lines.append(text_lines[i+1])
            
            for p_line in potential_lines:
                # Find all price-looking numbers
                prices = re.findall(price_pattern, p_line)
                if prices:
                    p_val = clean_price(prices[-1])
                    if p_val > total:
                        total = p_val
        
        # 4. Item Extraction
        # Look for lines with text and a price at the end
        if in_item_section and not is_fuzzy_match(line_lower, total_keywords + exclude_keywords):
            # Verify it's not a garbage header line
            if not any(b in line_lower for b in blacklist):
                # Check for pattern: [Text] [Price]
                # We look for a price at the end of the line
                matches = re.findall(price_pattern, line)
                if matches:
                    last_match = matches[-1]
                    idx = line.rfind(last_match)
                    item_name = line[:idx].strip()
                    
                    # Try to extract quantity from the start of the line
                    quantity = 1
                    qty_match = re.search(r'^(\d+)\s+', item_name.strip())
                    if qty_match:
                        try:
                            quantity = int(qty_match.group(1))
                        except:
                            pass
                    
                    # Cleanup item name (remove noise like "Rp", "*", numbers at start)
                    item_name = re.sub(r'^(?:rp|[\d\.\*]\s+)+', '', item_name, flags=re.I).strip()
                    
                    if len(item_name) > 2:
                        price = clean_price(last_match)
                        if price > 0:
                            items.append({
                                "item_name": item_name,
                                "price": price,
                                "quantity": quantity,
                                "category_id": guess_category(item_name)
                            })
                        
    return {
        "store_name": store_name,
        "receipt_date": receipt_date,
        "total": total,
        "items": items
    }

