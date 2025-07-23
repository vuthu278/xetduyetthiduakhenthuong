import wikipedia
from wikipedia.exceptions import DisambiguationError, PageError
import os

wikipedia.set_lang("vi")
# đổi tên toppic để lấy dữ liệu từ trang kiwwi serch theo từ khóa.
# topic = "Mắt kính"
topic = "Đồng hồ"

try:
    # Lấy thông tin trang
    full_page = wikipedia.page(topic)

    # In thông tin
    print("🔹 Tiêu đề:", full_page.title)
    print("🔹 URL:", full_page.url)
    print("🔹 Nội dung đầy đủ (trích 1000 ký tự):\n")
    print(full_page.content[:1000])

    # Lưu nội dung ra file .txt
    output_dir = "wiki_content"
    os.makedirs(output_dir, exist_ok=True)
    safe_title = full_page.title.replace("/", "_")  # tránh lỗi khi có ký tự đặc biệt trong tên
    file_name = os.path.join(output_dir, f"{safe_title}.txt")

    with open(file_name, "w", encoding="utf-8") as f:
        f.write(full_page.content)

    print(f"\n✅ Đã lưu nội dung vào file: {file_name}")

except DisambiguationError as e:
    print("⚠️ Từ khóa quá chung, có nhiều trang. Cưng chọn 1 trong các gợi ý sau:")
    for option in e.options:
        print(f"- {option}")

except PageError:
    print("❌ Không tìm thấy trang phù hợp với từ khóa.")

except Exception as err:
    print("⚠️ Lỗi không xác định:", err)
