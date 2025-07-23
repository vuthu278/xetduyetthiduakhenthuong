from fastapi import FastAPI, UploadFile, File, Form, Body, Request
from fastapi.middleware.cors import CORSMiddleware
import uvicorn
from typing import Optional
import os
from rag import handle_query, save_to_json
from tienxuly import process_pdf
import json
from fastapi.responses import JSONResponse
import time
import logging
import traceback

app = FastAPI()

# Enable CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # In production, replace with your Laravel domain
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

logger = logging.getLogger(__name__)

@app.post("/upload-document")
async def upload_document(file: UploadFile = File(...)):
    try:
        # Save the uploaded file temporarily
        base_path = os.path.dirname(os.path.abspath(__file__))
        pdf_content_dir = os.path.join(base_path, "data", "pdf_content")
        os.makedirs(pdf_content_dir, exist_ok=True)
        
        file_path = os.path.join(pdf_content_dir, file.filename)
        with open(file_path, "wb") as buffer:
            content = await file.read()
            buffer.write(content)
        
        # Process the PDF
        process_pdf(file_path)
        
        return {"success": True, "message": "Document processed successfully", "filename": file.filename}
    except Exception as e:
        return {"success": False, "error": str(e)}

# Thêm endpoint mới cho frontend
@app.post("/api/chatbot/upload")
async def chatbot_upload(request: Request):
    try:
        # Log request headers
        print("Request headers:", request.headers)
        
        # Try different ways to get the file
        try:
            # Try getting file from form data
            form = await request.form()
            print("Form data keys:", form.keys())
            file = form.get("document")
            if not file:
                # Try getting file directly from request
                file = await request.files()
                if file:
                    file = file.get("document")
            
            if not file:
                return {"success": False, "error": "No file uploaded"}
                
            # Save the uploaded file temporarily
            base_path = os.path.dirname(os.path.abspath(__file__))
            pdf_content_dir = os.path.join(base_path, "data", "pdf_content")
            os.makedirs(pdf_content_dir, exist_ok=True)
            
            file_path = os.path.join(pdf_content_dir, file.filename)
            content = await file.read()
            with open(file_path, "wb") as buffer:
                buffer.write(content)
            
            # Process the PDF
            process_pdf(file_path)
            
            return {"success": True, "message": "Document processed successfully", "filename": file.filename}
        except Exception as e:
            print("Error processing file:", str(e))
            return {"success": False, "error": f"Error processing file: {str(e)}"}
            
    except Exception as e:
        print("Error in chatbot_upload:", str(e))
        return {"success": False, "error": str(e)}

@app.post("/ask")
async def ask_question(request: Request):
    try:
        # Log request headers
        print("Request headers:", request.headers)
        
        # Parse request body
        body = await request.json()
        print("Request body:", body)
        
        question = body.get("question")
        if not question:
            return {
                "success": False,
                "error": "Question is required"
            }
            
        # Get answer using handle_query function
        answer = handle_query(question)
        
        # Save to chat history
        save_to_json(question, answer)
        
        return {
            "success": True,
            "content": answer,
            "answer": answer
        }
    except Exception as e:
        print("Error in ask_question:", str(e))
        return {
            "success": False,
            "error": str(e)
        }

# Thêm endpoint mới cho frontend
@app.post("/api/chatbot/ask")
async def chatbot_ask(request: Request):
    try:
        # Log request headers và body
        headers = dict(request.headers)
        body = await request.json()
        question = body.get('question')
        
        logger.info(f"Received question: {question}")
        logger.info(f"Request headers: {headers}")
        logger.info(f"Request body: {body}")

        if not question:
            logger.error("No question provided")
            return JSONResponse(
                status_code=400,
                content={"error": "Question is required"}
            )

        # Xử lý câu hỏi
        start_time = time.time()
        try:
            logger.info("Calling handle_query function...")
            answer = handle_query(question)
            logger.info(f"Answer from handle_query: {answer}")
        except Exception as e:
            logger.error(f"Error in handle_query: {str(e)}")
            logger.error(f"Traceback: {traceback.format_exc()}")
            raise e
            
        processing_time = time.time() - start_time
        logger.info(f"Processing time: {processing_time:.2f} seconds")

        # Lưu vào lịch sử chat
        save_to_json(question, answer)

        # Trả về câu trả lời
        return JSONResponse(
            content={
                "success": True,
                "answer": answer,
                "content": answer,
                "processing_time": f"{processing_time:.2f} seconds"
            }
        )
    except Exception as e:
        logger.error(f"Error processing question: {str(e)}")
        logger.error(f"Traceback: {traceback.format_exc()}")
        return JSONResponse(
            status_code=500,
            content={"error": f"Error processing question: {str(e)}"}
        )

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8002) 