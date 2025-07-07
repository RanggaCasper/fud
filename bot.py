from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
import time
import xml.etree.ElementTree as ET
import requests

SITEMAP_URL = "https://fudz.my.id/sitemap-restaurants.xml"

def get_urls_from_sitemap():
    response = requests.get(SITEMAP_URL)
    response.raise_for_status()
    root = ET.fromstring(response.content)
    urls = [
        loc.text for loc in root.findall(".//{http://www.sitemaps.org/schemas/sitemap/0.9}loc")
    ]
    return urls

def setup_driver():
    chrome_options = Options()
    chrome_options.add_argument("--headless")
    chrome_options.add_argument("--disable-gpu")
    chrome_options.add_argument("--no-sandbox")
    chrome_options.add_argument("--window-size=1920,1080")
    chrome_options.add_argument("--disable-dev-shm-usage")
    driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=chrome_options)
    return driver

def visit_and_trigger_fetchImages(driver, url):
    print(f"Visiting {url}")
    driver.get(url)
    time.sleep(3)  # Tunggu JS load (fetchImages jalan otomatis, biasanya di onload)
    
    # Kalau kamu perlu paksa panggil fetchImages() manual:
    try:
        driver.execute_script("fetchImages()")
        print("✅ fetchImages() triggered manually.")
    except Exception as e:
        print("⚠️  Error running fetchImages():", e)

    time.sleep(2)  # Tunggu hasilnya
    # Optional: kamu bisa ambil image URLs yang dimuat JS
    images = driver.execute_script("return window.images || []")
    print(f"Found {len(images)} images.")

def main():
    urls = get_urls_from_sitemap()
    driver = setup_driver()
    try:
        for i, url in enumerate(urls, 1): 
            print(f"\n[{i}] {url}")
            visit_and_trigger_fetchImages(driver, url)
    finally:
        driver.quit()

if __name__ == "__main__":
    main()
