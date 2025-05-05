import tkinter as tk
from tkinter import filedialog, simpledialog
import pandas as pd

# Función para identificar las claves municipales únicas
def obtener_claves_municipales(datos):
    return datos['CLAVE MUNICIPIO'].unique()

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
    datos = pd.read_excel(nombre_archivo)
except FileNotFoundError:
    print("El archivo especificado no se encontró. Asegúrate de que el nombre y la ruta sean correctos.")
    exit()

# Extraer los primeros tres dígitos de la clave catastral y asignarlos a la clave municipio
datos['CLAVE MUNICIPIO'] = datos['CLAVE CATASTRAL'].astype(str).str[:3]

# Obtener las claves municipales únicas presentes en los datos
claves_municipales = obtener_claves_municipales(datos)

# Pedir al usuario que seleccione la clave municipal que se considerará como "procedente"
clave_procedente = simpledialog.askstring("Clave Municipal Procedente", "Selecciona la clave municipal que se considerará como 'procedente':\n\nClaves municipales presentes en los datos:\n" + "\n".join(claves_municipales), initialvalue=claves_municipales[0], parent=root)

if not clave_procedente:
    print("No se seleccionó ninguna clave municipal. Saliendo del programa.")
    exit()

# Separar los datos en dos DataFrames según la clave municipal seleccionada
datos_procedentes = datos[datos['CLAVE MUNICIPIO'] == clave_procedente]
datos_incorrectos = datos[datos['CLAVE MUNICIPIO'] != clave_procedente]

# Guardar los datos modificados en dos nuevos archivos Excel
nombre_archivo_procedentes = filedialog.asksaveasfilename(defaultextension=".xlsx", filetypes=[("Archivos de Excel", "*.xlsx")])
nombre_archivo_incorrectos = filedialog.asksaveasfilename(defaultextension=".xlsx", filetypes=[("Archivos de Excel", "*.xlsx")])

if nombre_archivo_procedentes and nombre_archivo_incorrectos:
    # Guardar los datos procedentes en el archivo correspondiente
    datos_procedentes.to_excel(nombre_archivo_procedentes, index=False)
    print(f"Los registros procedentes (clave municipio '{clave_procedente}') se han guardado en '{nombre_archivo_procedentes}'.")

    # Guardar los datos incorrectos en el archivo correspondiente
    datos_incorrectos.to_excel(nombre_archivo_incorrectos, index=False)
    print(f"Los registros incorrectos (clave municipio diferente a '{clave_procedente}') se han guardado en '{nombre_archivo_incorrectos}'.")
else:
    print("No se seleccionó un destino de archivo para ambos casos. Saliendo del programa.")
