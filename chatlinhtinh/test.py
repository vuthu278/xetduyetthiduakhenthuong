import os
from dotenv import load_dotenv
import chromadb
from pymongo import MongoClient
from chromadb.utils.embedding_functions import OpenAIEmbeddingFunction

# Load biến môi trường
load_dotenv()
openai_key = os.getenv("OPENAI_API_KEY")
mongo_uri = os.getenv("MONGO_URI")

if not openai_key:
    raise Exception("Không tìm thấy OPENAI_API_KEY trong file .env!")

if not mongo_uri:
    raise Exception("Không tìm thấy MONGO_URI trong file .env!")

# Kết nối Chroma
embedding_function = OpenAIEmbeddingFunction(
    api_key=openai_key,
    model_name="text-embedding-3-small"
)

chroma_client = chromadb.PersistentClient(path="chroma")
collection = chroma_client.get_or_create_collection(
    name="quychesinhvien5tot_data",
    embedding_function=embedding_function
)

# Kết nối MongoDB
mongo_client = MongoClient(mongo_uri)
mongo_db = mongo_client["quychesinhvien5tot_data"]   # tên database
mongo_collection = mongo_db["documents"]    # tên collection

print("\n🚀 Đọc dữ liệu từ MongoDB:")
mongo_docs = list(mongo_collection.find().limit(5))
for i, doc in enumerate(mongo_docs, 1):
    print(f"\n--- MongoDB Document {i} ---")
    print(f"ID: {doc.get('doc_id')}")
    print(f"Metadata: {doc.get('metadata')}")
    print(f"Nội dung: {doc.get('content')[:200]}...")  # In 200 kí tự đầu

print("\n🚀 Đọc dữ liệu từ Chroma:")
ids = [f"doc_{i}" for i in range(5)]  # Lấy 5 doc_id đầu tiên
chroma_docs = collection.get(ids=ids)

for i, (id_, doc, meta) in enumerate(zip(chroma_docs['ids'], chroma_docs['documents'], chroma_docs['metadatas']), 1):
    print(f"\n--- Chroma Document {i} ---")
    print(f"ID: {id_}")
    print(f"Metadata: {meta}")
    print(f"Nội dung: {doc[:200]}...")  # In 200 kí tự đầu
