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

def test_login_invalid_credentials():
    """Test Case 2: Verify dashboard access denial with invalid Manager credentials."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("managerXYZ")
        driver.find_element(By.ID, "password").send_keys("wrongPassword")
        driver.find_element(By.ID, "loginButton").click()

        # Check for error message
        error_message = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "errorMsg"))
        ).text
        assert "Invalid credentials" in error_message, "Expected error message not shown"
        print("Test Case 2 Passed: Invalid credentials correctly denied access.")
    except Exception as e:
        print(f"Test Case 2 Failed: {e}")
    finally:
        driver.quit()

def test_view_users_button():
    """Test Case 3: Verify that the 'View Users' button navigates to the user information page."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("manager")
        driver.find_element(By.ID, "password").send_keys("password")
        driver.find_element(By.ID, "loginButton").click()

        # Wait for dashboard
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/manager.php"))

        # Locate and click 'View Users' button
        driver.find_element(By.ID, "viewUsersButton").click()
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/view.php"))

        # Validate table headers
        table_headers = driver.find_elements(By.TAG_NAME, "th")
        headers = [header.text for header in table_headers]
        expected_headers = ["Username", "Email", "Role"]
        assert headers == expected_headers, f"Expected headers {expected_headers}, got {headers}"

        print("Test Case 3 Passed: 'View Users' button works as expected.")
    except Exception as e:
        print(f"Test Case 3 Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    test_login_valid_credentials()
    test_login_invalid_credentials()
    test_view_users_button()