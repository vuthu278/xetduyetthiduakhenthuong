import os
import PyPDF2
from pathlib import Path

def convert_pdf_to_text(pdf_path, output_dir):
    """
    Convert PDF file to text and save to output directory
    """
    try:
        # Open the PDF file
        with open(pdf_path, 'rb') as file:
            # Create PDF reader object
            pdf_reader = PyPDF2.PdfReader(file)
            
            # Get text from all pages
            text = ""
            for page in pdf_reader.pages:
                text += page.extract_text()
            
            # Create output filename
            pdf_name = os.path.basename(pdf_path)
            txt_name = os.path.splitext(pdf_name)[0] + '.txt'
            output_path = os.path.join(output_dir, txt_name)
            
            # Save text to file
            with open(output_path, 'w', encoding='utf-8') as txt_file:
                txt_file.write(text)
            
            print(f"Successfully converted {pdf_name} to text")
            
    except Exception as e:
        print(f"Error converting {pdf_path}: {str(e)}")

def main():
    # Define paths
    current_dir = Path(__file__).parent
    pdf_dir = current_dir / 'pdf_content'
    output_dir = current_dir / 'txt_content'
    
    # Create output directory if it doesn't exist
    os.makedirs(output_dir, exist_ok=True)
    
    # Process all PDF files in the directory
    for pdf_file in pdf_dir.glob('*.pdf'):
        convert_pdf_to_text(pdf_file, output_dir)

if __name__ == "__main__":
    main()
