import tkinter as tk
from tkinter import filedialog
import pandas as pd

# Crear una ventana emergente para seleccionar el archivo Excel
root = tk.Tk()
root.withdraw()  # Ocultar la ventana principal

nombre_archivo = filedialog.askopenfilename(title="Selecciona el archivo Excel que contiene los datos", filetypes=[("Archivos de Excel", "*.xlsx;*.xls")])

# Verificar si se seleccionó un archivo
if not nombre_archivo:
    print("No se seleccionó ningún archivo. Saliendo del programa.")
    exit()

# Cargar el archivo Excel en un DataFrame
try:
    datos = pd.read_excel(nombre_archivo, skiprows=8)  # Saltar las primeras 8 filas
except FileNotFoundError:
    print("El archivo especificado no se encontró. Asegúrate de que el nombre y la ruta sean correctos.")
    exit()

# Guardar los datos sin las primeras 8 filas en un nuevo archivo Excel
nombre_archivo_salida = filedialog.asksaveasfilename(defaultextension=".xlsx", filetypes=[("Archivos de Excel", "*.xlsx")])

# Verificar si se seleccionó un destino de archivo
if nombre_archivo_salida:
    # Guardar los datos modificados en el archivo de destino
    datos.to_excel(nombre_archivo_salida, index=False)
    print(f"Listo jbn '{nombre_archivo_salida}'.")
else:
    print("No se seleccionó un destino de archivo. Saliendo del programa.")