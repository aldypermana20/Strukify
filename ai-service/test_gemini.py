import os
import google.generativeai as genai
from dotenv import load_dotenv

load_dotenv('../.env')
api_key = os.getenv('GEMINI_API_KEY')
print(f"Testing with API Key: {api_key[:10]}...")

genai.configure(api_key=api_key)

try:
    print("Daftar model yang tersedia untuk API Key Anda:")
    for m in genai.list_models():
        if 'generateContent' in m.supported_generation_methods:
            print(f"- {m.name}")
except Exception as e:
    print(f"ERROR: {e}")
