import tkinter as tk
from datetime import datetime
import pytz

def find_country_and_time():
    country_code = entry.get().strip().upper()
    country_name = pytz.country_names.get(country_code, "Country not found!")

    if country_code in pytz.country_timezones:
        timezone = pytz.country_timezones[country_code][0]  # Take the first timezone
        local_time = datetime.now(pytz.timezone(timezone)).strftime(" %H:%M:%S %p %d-%m-%y ")
    else:
        local_time = "Time zone not available!"

    result_label.config(text=f"Country: {country_name}\nTime: {local_time}")

# GUI Setup
root = tk.Tk()
root.title("Country & Time Finder")
root.geometry("350x200")

tk.Label(root, text="Enter Country Code:").pack()
entry = tk.Entry(root)
entry.pack()

tk.Button(root, text="Find Country & Time", command=find_country_and_time).pack()
result_label = tk.Label(root, text="", font=("Arial", 12))
result_label.pack()

root.mainloop()
