import pandas as pd
from tkinter import filedialog, Tk

def replace_characters():
    # Abrir el cuadro de diálogo para seleccionar el archivo Excel
    root = Tk()
    root.withdraw()  # Ocultar la ventana principal
    file_path = filedialog.askopenfilename(filetypes=[("Excel files", "*.xlsx")])
    root.destroy()  # Cerrar la ventana principal

    if file_path:
        # Cargar el archivo Excel
        df = pd.read_excel(file_path)

        # Guardar el formato del encabezado
        header_format = df.columns

        # Reemplazar caracteres en todas las celdas
        df.replace({';': ',', '"': '', "'": ''}, regex=True, inplace=True)

        # Abrir ventana para guardar el archivo modificado
        root = Tk()
        root.withdraw()  # Ocultar la ventana principal
        save_path = filedialog.asksaveasfilename(defaultextension=".xlsx", filetypes=[("Excel files", "*.xlsx")])
        root.destroy()  # Cerrar la ventana principal

        # Guardar el archivo modificado
        if save_path:
            # Crear un nuevo DataFrame con el formato del encabezado original
            df_with_header = pd.DataFrame(columns=header_format)
            df_with_header = pd.concat([df_with_header, df], ignore_index=True)

            # Guardar el archivo modificado
            df_with_header.to_excel(save_path, index=False)
            print("¡Archivo modificado y guardado con éxito!")
        else:
            print("No se seleccionó una ubicación para guardar el archivo.")
    else:
        print("No se seleccionó ningún archivo.")

def main():
    replace_characters()

if __name__ == "__main__":
    main()
