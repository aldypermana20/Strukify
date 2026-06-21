import os
import google.generativeai as genai
from dotenv import load_dotenv

load_dotenv('../.env')
api_key = os.getenv('GEMINI_API_KEY')
print(f"Testing with API Key starting with: {api_key[:10] if api_key else 'None'}...")

genai.configure(api_key=api_key)

try:
    model = genai.GenerativeModel('gemini-1.5-flash-latest')
    response = model.generate_content('Say hello')
    print("Success! Gemini replied:", response.text)
except Exception as e:
    print(f"ERROR: {e}")
