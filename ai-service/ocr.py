import easyocr
import numpy as np
import cv2

# Initialize reader globally so it's loaded once at startup
print("Initializing EasyOCR Reader...")
# Support English and Indonesian
reader = easyocr.Reader(['id', 'en'], gpu=False) 
print("EasyOCR Reader ready.")

def preprocess_image(img):
    """
    Preprocess image for better OCR accuracy.
    """
    # 1. Convert to grayscale
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    
    # 2. Resize image (Scale up by 1.5x to help with small text)
    width = int(gray.shape[1] * 1.5)
    height = int(gray.shape[0] * 1.5)
    resized = cv2.resize(gray, (width, height), interpolation=cv2.INTER_CUBIC)
    
    # 3. Apply CLAHE (Contrast Limited Adaptive Histogram Equalization)
    # This helps with uneven lighting on receipts
    clahe = cv2.createCLAHE(clipLimit=2.0, tileGridSize=(8,8))
    enhanced = clahe.apply(resized)
    
    # 4. Denoise image (slightly blur to remove artifacts)
    denoised = cv2.fastNlMeansDenoising(enhanced, None, h=10, searchWindowSize=21, templateWindowSize=7)
    
    # 5. Adaptive Thresholding (Binarization)
    thresh = cv2.adaptiveThreshold(denoised, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 21, 11)
    
    # EasyOCR expects 3-channel image typically, convert back
    processed_bgr = cv2.cvtColor(thresh, cv2.COLOR_GRAY2BGR)
    return processed_bgr

def process_image(image_bytes: bytes):
    """
    Process image bytes through EasyOCR and return text lines.
    """
    # Convert bytes to numpy array
    nparr = np.frombuffer(image_bytes, np.uint8)
    # Decode image
    img = cv2.imdecode(nparr, cv2.IMREAD_COLOR)
    
    if img is None:
        raise ValueError("Failed to decode image")
        
    # Preprocess the image
    processed_img = preprocess_image(img)
        
    # Run OCR with adjusted parameters
    # Adjusting text_threshold and link_threshold can help with broken words
    results = reader.readtext(
        processed_img,
        paragraph=False,
        y_ths=0.2, # Maximum vertical distance to merge text boxes
        x_ths=1.0, # Maximum horizontal distance to merge text boxes
    )
    
    # Extract just the text from results
    # results format: [(bounding_box, text, confidence), ...]
    text_lines = [text for (bbox, text, prob) in results if prob > 0.2]
    
    return text_lines
