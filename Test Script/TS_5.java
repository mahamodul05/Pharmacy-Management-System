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

def test_logout_button():
    """Test Case 5: Verify that the 'Logout' button logs out the user, terminates the session, and redirects to the login page."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("manager")
        driver.find_element(By.ID, "password").send_keys("password")
        driver.find_element(By.ID, "loginButton").click()

        # Wait for dashboard
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/manager.php"))

        # Locate and click 'Logout' button
        driver.find_element(By.ID, "logoutButton").click()
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/"))

        # Verify session termination
        driver.get("http://edgebook.wuaze.com/manager.php")
        assert driver.current_url == "http://edgebook.wuaze.com/login.php", "Session not terminated properly."

        print("Test Case 5 Passed: 'Logout' button works as expected.")
    except Exception as e:
        print(f"Test Case 5 Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    test_logout_button()
