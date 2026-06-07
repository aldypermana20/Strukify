from fastapi import FastAPI, UploadFile, File, HTTPException
from fastapi.middleware.cors import CORSMiddleware
import gemini_service
import os
import psutil
from datetime import datetime

app = FastAPI(title="Strukify AI Service")

# Configure CORS for Laravel integration
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], # In production, restrict to Laravel's URL
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def read_root():
    return {"status": "ok", "service": "Strukify AI OCR & NLP Engine"}

@app.get("/api/health")
def health_check():
    """
    Phase 5: Observability Endpoint
    Returns system health, CPU/Mem usage, and Node ID.
    Used by Load Balancer to ensure this node is healthy.
    """
    try:
        cpu_usage = psutil.cpu_percent(interval=0.1)
        mem_info = psutil.virtual_memory()
        
        return {
            "status": "healthy",
            "node_id": os.getenv("NODE_ID", "ai-standalone-node"),
            "timestamp": datetime.now().isoformat(),
            "metrics": {
                "cpu_percent": cpu_usage,
                "memory_percent": mem_info.percent,
            }
        }
    except Exception as e:
        return {"status": "degraded", "error": str(e), "node_id": os.getenv("NODE_ID", "unknown")}

@app.post("/api/scan")
async def scan_receipt(image: UploadFile = File(...)):
    """
    Endpoint to receive a receipt image, run OCR, and extract structured data.
    """
    if not image.content_type.startswith('image/'):
        raise HTTPException(status_code=400, detail="File must be an image")
        
    try:
        contents = await image.read()
        mime_type = image.content_type
        
        # 1. Process directly with Gemini (OCR + NLP simultaneously)
        structured_data = gemini_service.process_receipt_with_gemini(contents, mime_type)
        
        # Add raw lines placeholder to maintain compatibility with frontend if it expects it
        structured_data["raw_text"] = ["Processed via Gemini API"]
        
        return structured_data
        
    except Exception as e:
        print(f"Error processing receipt: {e}")
        raise HTTPException(status_code=500, detail=str(e))

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8001)
