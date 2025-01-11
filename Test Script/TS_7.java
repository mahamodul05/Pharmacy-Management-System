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

def test_update_user_invalid_data():
    """Test Case 7: Verify validation for updating a user with invalid data."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("manager")
        driver.find_element(By.ID, "password").send_keys("password")
        driver.find_element(By.ID, "loginButton").click()

        # Wait for dashboard
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/manager.php"))

        # Locate and click 'Edit User' button
        driver.find_element(By.ID, "editUserButton").click()

        # Enter invalid data in the username field
        username_field = driver.find_element(By.ID, "username")
        username_field.clear()
        username_field.send_keys("john@doe")
        driver.find_element(By.ID, "saveButton").click()

        # Validate error message
        error_message = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "errorMsg"))
        ).text
        assert "Username cannot contain special characters." in error_message, "Expected validation error not shown."

        print("Test Case 7 Passed: Validation for invalid data works as expected.")
    except Exception as e:
        print(f"Test Case 7 Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    test_update_user_invalid_data()