import os
import json
from tqdm import tqdm
from dotenv import load_dotenv
import chromadb
from chromadb.utils.embedding_functions import OpenAIEmbeddingFunction
from pymongo import MongoClient

# Load API Key và Mongo URI từ .env
load_dotenv()
openai_key = os.getenv("OPENAI_API_KEY")
mongo_uri = os.getenv("MONGO_URI")

if not openai_key:
    raise Exception("Không tìm thấy OPENAI_API_KEY trong file .env!")

if not mongo_uri:
    raise Exception("Không tìm thấy MONGO_URI trong file .env!")

# Tạo embedding function
embedding_function = OpenAIEmbeddingFunction(
    api_key=openai_key,
    model_name="text-embedding-3-small"
)

# Kết nối Chroma vectorstore
chroma_client = chromadb.PersistentClient(path="chroma")
collection = chroma_client.get_or_create_collection(
    name="quychesinhvien5tot_data",
    embedding_function=embedding_function
)

# Kết nối MongoDB
mongo_client = MongoClient(mongo_uri)
mongo_db = mongo_client["quychesinhvien5tot_data"]  # tên database
mongo_collection = mongo_db["documents"]   # tên collection

data_dir = 'chunked'
doc_id = 0
documents = []
ids = []
metadatas = []
mongo_docs = []

if not os.path.exists(data_dir):
    raise Exception(f"Thư mục {data_dir} không tồn tại!")

for filename in os.listdir(data_dir):
    if filename.endswith(".json"):
        filepath = os.path.join(data_dir, filename)
        try:
            with open(filepath, "r", encoding="utf-8") as f:
                chunks = json.load(f)
                if isinstance(chunks, str):
                    chunks = [json.loads(chunk) for chunk in chunks]
        except Exception as e:
            print(f"❌ Lỗi khi đọc {filename}: {e}")
            continue

        for chunk in tqdm(chunks, desc=f"Embedding {filename}"):
            try:
                content = json.dumps(chunk, ensure_ascii=False) if isinstance(chunk, dict) else str(chunk)
                
                # Lưu cho Chroma
                documents.append(content)
                ids.append(f"doc_{doc_id}")
                metadatas.append({"filename": filename})

                # Chuẩn bị cho MongoDB
                mongo_docs.append({
                    "doc_id": f"doc_{doc_id}",
                    "content": content,
                    "metadata": {"filename": filename}
                })

                doc_id += 1
            except Exception as e:
                print(f"⚠️ Lỗi khi xử lý đoạn trong {filename}: {e}")

# Bước 6: Thêm dữ liệu vào Chroma
if documents:
    try:
        collection.upsert(
            documents=documents,
            ids=ids,
            metadatas=metadatas
        )
        print(f"\n✅ Đã thêm {doc_id} documents vào collection 'taovector'.")
    except Exception as e:
        print(f"❌ Lỗi khi thêm dữ liệu vào collection Chroma: {e}")

# Bước 7: Thêm dữ liệu vào MongoDB
if mongo_docs:
    try:
        mongo_collection.insert_many(mongo_docs)
        print(f"✅ Đã thêm {len(mongo_docs)} documents vào MongoDB collection 'documents'.")
    except Exception as e:
        print(f"❌ Lỗi khi thêm dữ liệu vào MongoDB: {e}")

# Kiểm tra
print(f"📊 Số lượng tài liệu trong Chroma: {collection.count()}")
print(f"📊 Số lượng tài liệu trong MongoDB: {mongo_collection.count_documents({})}")
