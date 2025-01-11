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

def test_view_prescription_button():
    """Test Case 4: Verify that the 'View Prescription' button navigates to the prescription information page."""
    driver = setup_driver()
    try:
        driver.get("http://edgebook.wuaze.com/login.php")
        driver.find_element(By.ID, "username").send_keys("manager")
        driver.find_element(By.ID, "password").send_keys("password")
        driver.find_element(By.ID, "loginButton").click()

        # Wait for dashboard
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/manager.php"))

        # Locate and click 'View Prescription' button
        driver.find_element(By.ID, "viewPrescriptionButton").click()
        WebDriverWait(driver, 10).until(EC.url_to_be("http://edgebook.wuaze.com/view_prescription.php"))

        # Validate table headers
        table_headers = driver.find_elements(By.TAG_NAME, "th")
        headers = [header.text for header in table_headers]
        expected_headers = ["Prescription ID", "Patient Name", "Medication", "Dosage"]
        assert headers == expected_headers, f"Expected headers {expected_headers}, got {headers}"

        print("Test Case 4 Passed: 'View Prescription' button works as expected.")
    except Exception as e:
        print(f"Test Case 4 Failed: {e}")
    finally:
        driver.quit()

if __name__ == "__main__":
    test_view_prescription_button()