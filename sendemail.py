from email.message import EmailMessage
import ssl
import smtplib
import sys

if len(sys.argv) > 1:
    who = sys.argv[1]

sender = 'nmjdeboer@gmail.com'
password = 'rucyvsadxskdchwa'
receiver = who

subject = 'Ticket bevestiging spacex'
body = """
    Hoi,

    Je tickte is geboekt. Hierbij je Ticket invormatie.
    Nog een fijne reis.

    Groetjes,
    Spacex
    """


em = EmailMessage()
em['From'] = sender
em['To'] = receiver
em['Subject'] = subject
em.set_content(body)

context = ssl.create_default_context()

with smtplib.SMTP_SSL('smtp.gmail.com', 465, context=context) as smtp:
    smtp.login(sender, password)
    smtp.sendmail(sender, receiver, em.as_string())
