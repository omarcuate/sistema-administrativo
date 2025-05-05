import tkinter as tk
from tkinter import filedialog
import pandas as pd

def procesar_archivo(archivo):
    # Lee el archivo CSV
    df = pd.read_excel(archivo)
    
    # Realiza las modificaciones requeridas
    df.replace(';', ',', regex=True, inplace=True)
    df.replace('"', '', regex=True, inplace=True)
    df.replace("'", '', regex=True, inplace=True)
    
    # Guarda el archivo procesado
    archivo_guardado = filedialog.asksaveasfilename(defaultextension=".xlsx")
    if archivo_guardado:
        df.to_excel(archivo_guardado, index=False)
        tk.messagebox.showinfo("Archivo guardado", "El archivo se ha guardado correctamente.")

def seleccionar_archivo():
    archivo = filedialog.askopenfilename(filetypes=[("Archivos Excel", "*.xlsx"), ("Todos los archivos", "*.*")])
    if archivo:
        procesar_archivo(archivo)

# Crear ventana principal
root = tk.Tk()
root.title("Procesar Archivo Excel")
root.geometry("400x200")  # Tamaño personalizado para la ventana

# Botón para seleccionar archivo
btn_seleccionar_archivo = tk.Button(root, text="Seleccionar Archivo Excel", command=seleccionar_archivo)
btn_seleccionar_archivo.pack(pady=20)

# Ejecutar la ventana
root.mainloop()
