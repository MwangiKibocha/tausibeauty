import sys
import mysql.connector
import smtplib
from email.mime.text import MIMEText

# Connect to the database
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="beauty"
)

# Get the date and time of the appointment
datetime = sys.argv[1]
date, time = datetime.split()

# Get the available stylists for the selected date and time
cursor = db.cursor()
query = "SELECT name FROM stylists WHERE available_%s = 1 AND start_time <= %s AND end_time >= %s"
cursor.execute(query, (date, time, time))
stylists = [row[0] for row in cursor.fetchall()]

# Check if there are available stylists
if len(stylists) > 0:
    # If there are available stylists, get the selected stylist
    stylist = sys.argv[2]
    if stylist not in stylists:
        # The selected stylist is not available, exit with an error message
        print("Error: The selected stylist is not available at the selected time.")
        sys.exit()

    # Book the appointment with the selected stylist
    query = "INSERT INTO appointments (stylist, customer, service, datetime) VALUES (%s, %s, %s, %s)"
    cursor.execute(query, (stylist, customer, service, datetime))
    db.commit()

    # Send confirmation email to the customer and the stylist
    email_customer(customer, stylist, service, datetime, customer_email)
    email_stylist(customer, stylist, service, datetime, stylist_email)

    # Return a success message
    print(f"Appointment booked for {stylist} at {datetime}.")
else:
    # If there are no available stylists, exit with an error message
    print("Error: No available stylists at the selected time.")
    sys.exit()

# Close the database connection
db.close()

def email_customer(customer, stylist, service, datetime, customer_email):
    # Set up the email message
    message = MIMEText(f"Hi {customer},\r\n\r\nYour appointment with {stylist} for {service} on {datetime} has been confirmed.\r\n\r\nThank you!")
    message["From"] = "booking@example.com"
    message["To"] = customer_email
    message["Subject"] = "Appointment Confirmation"

    # Send the email
    server = smtplib.SMTP("smtp.example.com")
    server.sendmail("booking@example.com", [customer_email], message.as_string())
    server.quit()

def email_stylist(customer, stylist, service, datetime, stylist_email):
    # Set up the email message
    message = MIMEText(f"Hi {stylist},\r\n\r\nYou have a new appointment with {customer} for {service} on {datetime}.\r\n\r\nThank you!")
    message["From"] = "booking@example.com"
    message["To"] = stylist_email
    message["Subject"] = "New Appointment"

    # Send the email
    server = smtplib.SMTP("smtp.example.com")
    server.sendmail("booking@example.com", [stylist_email], message.as_string())
    server.quit()
