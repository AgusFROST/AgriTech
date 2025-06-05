import rasterio
import numpy as np
import datetime
import sqlite3

# Path ke file NDVI .tif
ndvi_file_path = 'public/assets/data/NDVI.tif'

# Buka file .tif menggunakan rasterio
with rasterio.open(ndvi_file_path) as src:
    ndvi_data = src.read(1)
    ndvi_data = ndvi_data.astype('float32')
    ndvi_data[ndvi_data == src.nodata] = np.nan  # Mask nilai nodata

# Hitung statistik NDVI
average_ndvi = np.nanmean(ndvi_data)
healthy_area_percentage = np.sum(ndvi_data > 0.5) / np.sum(~np.isnan(ndvi_data)) * 100
alert_area_count = np.sum(ndvi_data < 0.2)

# Tentukan tanggal hari ini sebagai tanggal data
today = datetime.date.today()

# Simulasikan koneksi ke database SQLite Laravel (storage/database.sqlite)
conn = sqlite3.connect('database/database.sqlite')
cursor = conn.cursor()

# Buat tabel jika belum ada (untuk simulasi)
cursor.execute("""
CREATE TABLE IF NOT EXISTS ndvi_data (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    date TEXT,
    average_ndvi REAL,
    change_rate REAL,
    healthy_area_percentage REAL,
    alert_area_count INTEGER,
    created_at TEXT,
    updated_at TEXT
)
""")

# Ambil data sebelumnya untuk hitung change_rate
cursor.execute("SELECT average_ndvi FROM ndvi_data ORDER BY date DESC LIMIT 1")
previous = cursor.fetchone()
if previous:
    change_rate = ((average_ndvi - previous[0]) / previous[0]) * 100
else:
    change_rate = 0.0

# Simpan ke database
now = datetime.datetime.now().isoformat()
cursor.execute("""
INSERT INTO ndvi_data (date, average_ndvi, change_rate, healthy_area_percentage, alert_area_count, created_at, updated_at)
VALUES (?, ?, ?, ?, ?, ?, ?)
""", (today.isoformat(), average_ndvi, change_rate, healthy_area_percentage, int(alert_area_count), now, now))

conn.commit()
conn.close()

average_ndvi, change_rate, healthy_area_percentage, int(alert_area_count)
