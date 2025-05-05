import pandas as pd
from simpledbf import Dbf5
from tkinter import filedialog, Tk, Button, Label, messagebox
import os

def seleccionar_archivos():
    root = Tk()
    root.withdraw()  # Ocultar la ventana principal

    archivos = filedialog.askopenfilenames(title='Seleccionar archivos DBF', filetypes=[('DBF files', '*.dbf')])
    root.destroy()  # Cerrar la ventana después de seleccionar los archivos
    return list(archivos)

def procesar_archivos(archivos):
    for archivo in archivos:
        try:
            dbf = Dbf5(archivo, codec='latin-1')
            df = dbf.to_dataframe()

            tamanos_relleno = {'MUNICIPIO': 3, 'ZONA': 2, 'MANZANA': 3, 'LOTE': 2}

            for col, size in tamanos_relleno.items():
                if col in df.columns:
                    df[col] = df[col].apply(lambda x: str(int(x)) if pd.notnull(x) else '').str.zfill(size)

            for col in ['EDIFICIO', 'DEPTO']:
                if col in df.columns:
                    df[col] = df[col].astype(str)

            cols_para_clave = ['MUNICIPIO', 'ZONA', 'MANZANA', 'LOTE', 'EDIFICIO', 'DEPTO']
            cols_para_clave = [col for col in cols_para_clave if col in df.columns]
            
            if cols_para_clave:
                df['CLAVE CATASTRAL'] = df[cols_para_clave].apply(lambda x: ''.join(x), axis=1)
                if 'CLAVE CATASTRAL' in df.columns:
                    columnas = ['CLAVE CATASTRAL'] + [col for col in df if col != 'CLAVE CATASTRAL']
                    df = df[columnas]

            nombre_excel = os.path.splitext(archivo)[0] + '.xlsx'
            df.to_excel(nombre_excel, index=False)

            print(f"Archivo convertido y guardado en: {nombre_excel}")

        except Exception as e:
            mensaje_error = f"Ocurrió un error al procesar el archivo {archivo}: {e}"
            print(mensaje_error)
            messagebox.showerror("Error", mensaje_error)

def iniciar_procesamiento():
    try:
        archivos = seleccionar_archivos()
        if archivos:
            procesar_archivos(archivos)
            messagebox.showinfo("Proceso Completado", "Todos los archivos han sido procesados correctamente.")
        else:
            messagebox.showinfo("Información", "No se seleccionaron archivos.")
    except Exception as e:
        mensaje_error = f"Ocurrió un error durante el procesamiento: {e}"
        print(mensaje_error)
        messagebox.showerror("Error", mensaje_error)

# Interfaz gráfica
root = Tk()
root.title("Procesador de Archivos DBF")

label = Label(root, text="Presiona el botón para seleccionar archivos y procesarlos.")
label.pack(pady=10)

button = Button(root, text="Seleccionar Archivos", command=iniciar_procesamiento)
button.pack(pady=10)

root.mainloop()
