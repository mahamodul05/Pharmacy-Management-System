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

def test_login_valid_credentials():
    """Test Case 1: Verify dashboard access with valid Manager credentials."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("manager")
        driver.find_element(By.ID, "password").send_keys("password")
        driver.find_element(By.ID, "loginButton").click()

        # Wait for dashboard
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/manager.php"))
        print("Test Case 1 Passed: Valid credentials allow dashboard access.")
    except Exception as e:
        print(f"Test Case 1 Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    test_login_valid_credentials()