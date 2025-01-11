from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import time

def setup_driver():
    """Sets up the Edge WebDriver."""
    options = webdriver.EdgeOptions()
    options.add_argument("--start-maximized")
    driver = webdriver.Edge(options=options)
    return driver

def test_manage_stock():
    """Test Case 6: Verify stock data is displayed in tabular format after navigating to 'Manage Stock'."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("manager")
        driver.find_element(By.ID, "password").send_keys("password")
        driver.find_element(By.ID, "loginButton").click()

        # Wait for dashboard
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/manager.php"))

        # Locate and click 'Manage Stock' button
        driver.find_element(By.ID, "manageStockButton").click()
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/stock.php"))

        # Validate table headers
        table_headers = driver.find_elements(By.TAG_NAME, "th")
        headers = [header.text for header in table_headers]
        expected_headers = ["Stock ID", "Product Name", "Quantity", "Price"]
        assert headers == expected_headers, f"Expected headers {expected_headers}, got {headers}"

        print("Test Case 6 Passed: 'Manage Stock' navigation and table validation passed.")
    except Exception as e:
        print(f"Test Case 6 Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    test_manage_stock()
