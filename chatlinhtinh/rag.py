from openai import OpenAI
from dotenv import load_dotenv
import chromadb
import os
import json
import traceback

load_dotenv()
openai_client = OpenAI(api_key=os.getenv("OPENAI_API_KEY"))

# ChromaDB
base_path = os.path.dirname(os.path.abspath(__file__))
chroma_path = os.path.abspath(os.path.join(base_path, "chroma"))
chroma_client = chromadb.PersistentClient(path=chroma_path)
collection = chroma_client.get_collection("quychesinhvien5tot_data")

# Kiểm tra số lượng documents
num_docs = collection.count()
print(f"Số lượng documents trong collection: {num_docs}")

def save_to_json(question, answer, filename="chat_history.json"):
    try:
        # Lưu file trong thư mục data
        filepath = os.path.join(base_path, "data", filename)
        if os.path.exists(filepath):
            with open(filepath, "r", encoding="utf-8") as f:
                data = json.load(f)
        else:
            data = []
        data.append({"question": question, "answer": answer})
        with open(filepath, "w", encoding="utf-8") as f:
            json.dump(data, f, ensure_ascii=False, indent=4)
        print(f"Đã lưu câu hỏi và câu trả lời vào {filepath}")
    except Exception as e:
        print(f"Lỗi khi lưu dữ liệu vào file: {str(e)}")

def get_embedding(query):
    return openai_client.embeddings.create(
        model="text-embedding-3-small", input=query
    ).data[0].embedding

def hybrid_search_rerank(query, top_k=5):
    if collection.count() == 0:
        return []
    num_documents = collection.count()
    print(f"Số lượng documents trong collection: {num_documents}")
    
    embedding = get_embedding(query)
    results = collection.query(
        query_embeddings=[embedding],
        query_texts=[query],
        n_results=top_k
    )
    
    docs = zip(results['ids'][0], results['documents'][0], results['distances'][0])
    
    return sorted(docs, key=lambda x: x[2])

def generate_answer(query, reranked_docs, history=None):
    if not reranked_docs:
        return "Không tìm thấy thông tin liên quan trong cơ sở dữ liệu."

    context = "\n---\n".join([doc for _, doc, _ in reranked_docs])
    
    print(f"Context tìm thấy từ dữ liệu:\n{context}")

    system_prompt = """
    Bạn là một trợ lý AI trả lời câu hỏi dựa trên dữ liệu người dùng cung cấp.

    - Bạn chỉ được phép trả lời ngắn gọn dựa trên dữ liệu có sẵn, không được tự suy luận.
    """.strip()

    messages = [{"role": "system", "content": system_prompt}]
    if history:
        messages += history[-10:]

    user_prompt = f"""
    Dưới đây là dữ liệu:

    {context}

    Hãy trả lời câu hỏi sau.

    Câu hỏi: {query}
    """.strip()

    messages.append({"role": "user", "content": user_prompt})

    response = openai_client.chat.completions.create(
        model="gpt-3.5-turbo",
        messages=messages,
        temperature=0.7,
    )
    return response.choices[0].message.content.strip()

def handle_query(query, history=None):
    reranked_docs = hybrid_search_rerank(query)
    return generate_answer(query, reranked_docs, history)

if __name__ == "__main__":
    try:
        # query = "Mẫu đồng hồ nào phù hợp với người thích phong cách thể thao?"
        # query = "Phân loại kính?"
        query = "ai là người có thẩm quyền đề xuất đối tượng được xét trao danh hiệu sinh viên 5 tốt?"
        answer = handle_query(query)

        save_to_json(query, answer)
        print(f"Câu hỏi: {query}")
        print(f"Câu trả lời: {answer}")
    
    except Exception as e:
        print(f"Lỗi trong quá trình xử lý: {str(e)}")
        traceback.print_exc()
