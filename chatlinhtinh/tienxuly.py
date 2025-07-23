from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.schema.document import Document
import os
import json
import PyPDF2

# Tạo các thư mục cần thiết
base_path = os.path.dirname(os.path.abspath(__file__))
data_dir = os.path.join(base_path, "data")
txt_content_dir = os.path.join(data_dir, "txt_content")
chunked_dir = os.path.join(base_path, "chunked")
chroma_dir = os.path.join(base_path, "chroma")

os.makedirs(data_dir, exist_ok=True)
os.makedirs(txt_content_dir, exist_ok=True)
os.makedirs(chunked_dir, exist_ok=True)
os.makedirs(chroma_dir, exist_ok=True)

def extract_text_from_pdf(pdf_path):
    """Trích xuất text từ file PDF"""
    text = ""
    try:
        with open(pdf_path, 'rb') as file:
            pdf_reader = PyPDF2.PdfReader(file)
            for page in pdf_reader.pages:
                text += page.extract_text()
    except Exception as e:
        print(f"Lỗi khi đọc PDF: {str(e)}")
    return text

def save_text_to_txt(text, filename):
    """Lưu text vào file TXT"""
    txt_path = os.path.join(txt_content_dir, f"{filename}.txt")
    with open(txt_path, "w", encoding="utf-8") as f:
        f.write(text)
    return txt_path

def create_documents_from_txt(file_path):
    docs = []
    with open(file_path, "r", encoding="utf-8") as f:
        text = f.read()
        if text.strip():
            metadata = {"source": file_path}
            docs.append(Document(page_content=text.strip(), metadata=metadata))
    return docs

def chunk_documents(documents, chunk_size=500, chunk_overlap=50):
    splitter = RecursiveCharacterTextSplitter(
        chunk_size=chunk_size,
        chunk_overlap=chunk_overlap,
        separators=["\n\n", "\n", " ", ""]
    )
    return splitter.split_documents(documents)

def process_pdf(pdf_path):
    """Xử lý file PDF và tạo chunks"""
    print(f"🔵 Bắt đầu xử lý file PDF: {pdf_path}")
    
    # Trích xuất text từ PDF
    text = extract_text_from_pdf(pdf_path)
    if not text:
        print("❌ Không thể trích xuất text từ PDF")
        return
    
    # Lưu text vào file TXT
    filename = os.path.splitext(os.path.basename(pdf_path))[0]
    txt_path = save_text_to_txt(text, filename)
    print(f"✅ Đã lưu text vào: {txt_path}")
    
    # Tạo documents và chunks
    documents = create_documents_from_txt(txt_path)
    chunked_docs = chunk_documents(documents)
    
    # Lưu chunks vào file JSON
    chunked_file = os.path.join(chunked_dir, f"{filename}_chunked.json")
    with open(chunked_file, "w", encoding="utf-8") as f:
        json.dump([doc.page_content for doc in chunked_docs], f, ensure_ascii=False, indent=2)
    
    print(f"✅ Đã lưu {len(chunked_docs)} chunks vào: {chunked_file}\n")
    return chunked_file 