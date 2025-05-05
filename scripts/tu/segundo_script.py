import pandas as pd
from tkinter import Tk, filedialog, simpledialog

# Crear la ventana de selección de archivo
root = Tk()
root.withdraw()

# Abrir el cuadro de diálogo para seleccionar el archivo
file_path = filedialog.askopenfilename(title="Seleccionar archivo Excel", filetypes=[("Archivos Excel", "*.xlsx;*.xls")])

# Verificar si se seleccionó un archivo
if file_path:
    # Lee el archivo Excel seleccionado
    df = pd.read_excel(file_path, dtype=str)

    # Solicitar al usuario que ingrese el nombre de la tabla
    table_name = simpledialog.askstring("Nombre de la tabla", "Ingrese el nombre de la tabla:")

    # Verificar si se ingresó un nombre de tabla
    if table_name:
        # Solicitar la ubicación y nombre del archivo de salida
        output_file_path = filedialog.asksaveasfilename(
            title="Guardar comandos INSERT",
            defaultextension=".sql",
            filetypes=[("Archivos SQL", "*.sql")]
        )

        # Verificar si se seleccionó una ubicación y nombre de archivo de salida
        if output_file_path:
            # Abre un archivo SQL para escribir los comandos INSERT con codificación UTF-8
            with open(output_file_path, 'w', encoding='utf-8') as file:
                # Itera sobre las filas del DataFrame
                for index, row in df.iterrows():
                    # Construye el comando INSERT con los nombres de las columnas y sus valores
                    columns = ', '.join([f"`{col}`" for col in row.index])
                    values = ', '.join([f"'{value}'" if pd.notnull(value) else 'NULL' for value in row])
                    insert_command = f"INSERT INTO {table_name} ({columns}) VALUES ({values});\n"
                    file.write(insert_command)

            print(f"Comandos INSERT generados con éxito y guardados en '{output_file_path}'.")
        else:
            print("No se seleccionó ninguna ubicación o nombre de archivo de salida.")
    else:
        print("No se ingresó un nombre de tabla.")
else:
    print("No se seleccionó ningún archivo.")
